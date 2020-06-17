<?php

namespace Tests\Api\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchOrder;
use App\Models\ClientSource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientBatchOrderTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function clientCanGetBatchOrders()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = $this->findRandomData('batches', ['client_id' => $this->user->id]);

        $response = $this->json('GET', route('api.client.batch.order', ['id' => $batch->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('orders', $data);
        $orders = $data->orders;

        foreach ($orders as $order) {
            $this->assertObjectHasAttribute('services', $order);

            foreach ($order->services as $service) {
                $this->assertObjectHasAttribute('services', $order);
            }
        }

        // Check on database if results match
        $clientDatabaseResult = BatchOrder::owned()->where('batch_id', $batch->id)->count();
        $this->assertEquals(count($orders), $clientDatabaseResult);
    }

    /**
     * @test
     */
    public function clientCanAddOrdersOnBatch()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = $this->findRandomData('batches', ['client_id' => $this->user->id, 'status' => Batch::STATUS_DRAFT]);

        // Get client patient
        $patient = $this->findRandomData('patients', ['client_id' => $this->user->id]);

        // Get client_services - get two
        $services = [];
        for ($i=0; $i < 2; $i++) {
            $service = $this->findRandomData('client_services', ['user_id' => $this->user->id]);
            array_push($services, $service->service_id);
        }

        $information = $this->faker->realText;
        $instruction = $this->faker->realText;

        $response = $this->json('POST', route('api.client.batch.order.store'), [
            'batch_id' => $batch->id,
            'services' => $services,
            'patient_id' => $patient->id,
            'clinical_information' => $information,
            'special_instructions' => $instruction,
            'is_urgent' => BatchOrder::MINOR,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.order.success.store'),
            ]);

        $this->assertObjectHasAttribute('order', $data);

        $batch = $this->findRandomData('batches', ['client_id' => $this->user->id, 'status' => Batch::STATUS_CONFIRMED]);
        $information = $this->faker->realText;
        $instruction = $this->faker->realText;

        // Get client_services - get two
        $services = [];
        for ($i=0; $i < 2; $i++) {
            $service = $this->findRandomData('client_services', ['user_id' => $this->user->id]);
            array_push($services, $service->service_id);
        }

        $response = $this->json('POST', route('api.client.batch.order.store'), [
            'batch_id' => $batch->id,
            'services' => $services,
            'patient_id' => $patient->id,
            'clinical_information' => $information,
            'special_instructions' => $instruction,
            'is_urgent' => BatchOrder::MINOR,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.order.success.store'),
            ]);

        $this->assertObjectHasAttribute('order', $data);
        $order = $data->order;
        // Check order has services
        $this->assertObjectHasAttribute('services', $order);
        foreach ($order->services as $service) {
            $this->assertTrue(in_array($service->service_id, $services));
        }
    }

    /**
     * @test
     */
    public function clientCannotAddOrderIfServiceGivenIsNotOwnedByClient()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = $this->findRandomData('batches', ['client_id' => $this->user->id, 'status' => Batch::STATUS_DRAFT]);

        // Get client patient
        $patient = $this->findRandomData('patients', ['client_id' => $this->user->id]);

        // Get client_services - get two
        $services = [93204952];

        $information = $this->faker->realText;
        $instruction = $this->faker->realText;

        $response = $this->json('POST', route('api.client.batch.order.store'), [
            'batch_id' => $batch->id,
            'services' => $services,
            'patient_id' => $patient->id,
            'clinical_information' => $information,
            'special_instructions' => $instruction,
            'is_urgent' => BatchOrder::MINOR,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_CLIENT_ERROR)
            ->assertJson([
                'success' => false,
                'message' => trans('validation.error'),
                'errors' => [
                    'services' => [trans('message.client.batch.order.error.service_is_not_owned')]
                ]
            ]);
    }

    /**
     * @test
     * @depends clientCanUpdateBatchOrder
     */
    public function clientCanDeleteBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = Batch::orderByRaw('RAND()')->where([
            'client_id' => $this->user->id,
            'status' => Batch::STATUS_DRAFT
        ])->has('orders')->first();

        $id = $batch->orders[0]->id;
        $response = $this->json('POST', route('api.client.batch.order.destroy', ['id' => $id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.order.success.destroy'),
            ]);

        // Check order has been deleted via `soft_delete` and status is changed to `Deleted`
        $this->assertNull(BatchOrder::find($id));
        $deleted = BatchOrder::withTrashed()->find($id);
        $this->assertNotNull($deleted); // Sof delete
        $this->assertEquals(BatchOrder::DELETED_STATUS, $deleted->status);
    }

    /**
     * @test
     */
    public function cannotDeleteBatchOrderIfBatchIsNotDraftStatus()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = Batch::orderByRaw('RAND()')->where([
            'client_id' => $this->user->id,
            'status' => Batch::STATUS_CONFIRMED // Not draft status
        ])->has('orders')->first();

        if (!$batch) {
            $this->assertNull($batch);
        } else {
            $id = $batch->orders[0]->id;

            $response = $this->json('POST', route('api.client.batch.order.destroy', ['id' => $id]));
            $data = $response->getData();

            $response
                ->assertStatus(self::RESPONSE_CLIENT_ERROR)
                ->assertJson([
                    'success' => false,
                    'message' => trans('message.client.batch.order.error.batch_is_not_draft'),
                ]);

            // Check order has not been deleted
            $databaseData = BatchOrder::find($id);
            $this->assertNotNull($databaseData);
            $this->assertNotEquals(BatchOrder::DELETED_STATUS, $databaseData->status);
        }
    }

    /**
     * @test
     * @depends clientCanDeleteBatchOrder
     */
    public function clientCanUpdateBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');

        // Get random batch that is not (deleted) soft
        $batch = Batch::orderByRaw('RAND()')->where('client_id', $this->user->id)->first();

        // Get random batch order
        $batchOrder = BatchOrder::where([
            'client_id' => $this->user->id,
            'batch_id' => $batch->id
        ])->orderByRaw('RAND()')->first();

        // Get client_services - get two
        $services = [];
        for ($i=0; $i < 2; $i++) {
            $service = $this->findRandomData('client_services', ['user_id' => $this->user->id]);
            array_push($services, $service->service_id);
        }

        $information = $this->faker->realText;
        $instruction = $this->faker->realText;

        $response = $this->json('POST', route('api.client.batch.order.update', ['id' => $batchOrder->id]), [
            'batch_id' => $batchOrder->batch_id,
            'services' => $services,
            'patient_id' => $batchOrder->patient_id,
            'clinical_information' => $information,
            'special_instructions' => $instruction,
            'is_urgent' => BatchOrder::MINOR,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.order.success.update'),
            ]);

        $this->assertObjectHasAttribute('order', $data);
        $order = $data->order;

        $this->assertEquals($batchOrder->id, $order->id);
        $this->assertEquals($information, $order->clinical_information);
        $this->assertEquals($instruction, $order->special_instructions);
    }

    /**
     * @test
     */
    public function clientCanUpdateBatchOrderStatus()
    {
        $this->asClient('perfect_client@gmail.com');

        // Update to `POSTED_STATUS` from `PENDING_STATUS`
        // Get random batch order
        $batchOrder = $this->findRandomData('batch_orders', [
            'client_id' => $this->user->id,
            'status' => BatchOrder::PENDING_STATUS,
        ]);

        $response = $this->json('POST', route('api.client.batch.order.update.status', ['id' => $batchOrder->id]), [
            'status' => BatchOrder::POSTED_STATUS,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.order.success.update_status.posted'),
            ]);

        $this->assertObjectHasAttribute('order', $data);
        $order = $data->order;
        $this->assertEquals($batchOrder->id, $order->id);
        $this->assertEquals(BatchOrder::POSTED_STATUS, $order->status); // Check status is posted
    }

    /**
     * @test
     */
    public function cannotUpdateBatchOrderIfClientDontOwnedData()
    {
        $client = User::client()->where('email', '!=', 'perfect_client@gmail.com')->orderByRaw('RAND()')->first();

        $this->asClient($client->email);

        // Update to `POSTED_STATUS` from `PENDING_STATUS`
        // Get random batch order
        $batchOrder = $this->findRandomData('batch_orders', [
            'status' => BatchOrder::PENDING_STATUS,
        ]);

        $response = $this->json('POST', route('api.client.batch.order.update.status', ['id' => $batchOrder->id]), [
            'status' => BatchOrder::POSTED_STATUS,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_NOT_FOUND);
    }
}
