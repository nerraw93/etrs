<?php
namespace Tests\ApiLegacy\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Patient;
use App\Models\Batch;
use App\Models\BatchOrder;

class LegacyClientBatchTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/orders'), route('api.legacy.client.orders.store'));
        $this->assertSame($this->legacy_base_api('/orders/1/cancel'), route('api.legacy.client.orders.cancel', ['orderId' => 1]));
        $this->assertSame($this->legacy_base_api('/orders/1/post'), route('api.legacy.client.orders.post', ['orderId' => 1]));
        $this->assertSame($this->legacy_base_api('/orders/1'), route('api.legacy.client.orders.destroy', ['orderId' => 1]));
    }

    /**
     * @test
     */
    public function clientCanStoreBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');
        $batch = $this->findRandomData('batches', ['client_id' => $this->user->id, 'status' => Batch::STATUS_DRAFT]);

        // Get client patient
        $patient = $this->findRandomData('patients', ['client_id' => $this->user->id]);

        // Get client_services - get two
        $services = [];
        for ($i=0; $i < 2; $i++) {
            $service = $this->findRandomData('client_services', ['user_id' => $this->user->id]);
            array_push($services, [
                'id' => $service->id,
                'serviceId' => $service->service_id,
            ]);
        }

        $information = $this->faker->realText;
        $instruction = $this->faker->realText;

        $response = $this->json('POST', route('api.legacy.client.orders.store'), [
            'batchId' => $batch->id,
            'tests' => $services,
            'patientId' => $patient->id,
            'clinicalInformation' => $information,
            'specialInstructions' => $instruction,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchResponseStructure()
            ]);
    }

    /**
     * @test
     */
    public function clientCanCancelBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');

        // Update to `POSTED_STATUS` from `PENDING_STATUS`
        // Get random batch order
        $batchOrder = $this->findRandomData('batch_orders', [
            'client_id' => $this->user->id,
            'status' => BatchOrder::PENDING_STATUS,
        ]);

        $response = $this->json('PUT', route('api.legacy.client.orders.cancel', ['orderId' => $batchOrder->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchOrderResponseStructure()
            ]);

        $this->assertObjectHasAttribute('data', $data);
        $order = $data->data;
        $this->assertEquals($batchOrder->id, $order->id);
        $this->assertEquals('cancelled', $order->status);
    }

    /**
     * @test
     */
    public function clientCanPostBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');

        // Update to `POSTED_STATUS` from `PENDING_STATUS`
        // Get random batch order
        $batchOrder = $this->findRandomData('batch_orders', [
            'client_id' => $this->user->id,
            'status' => BatchOrder::PENDING_STATUS,
        ]);

        $response = $this->json('PUT', route('api.legacy.client.orders.post', ['orderId' => $batchOrder->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchOrderResponseStructure()
            ]);

        $this->assertObjectHasAttribute('data', $data);
        $order = $data->data;
        $this->assertEquals($batchOrder->id, $order->id);
        $this->assertEquals('posted', $order->status);
    }

    /**
     * @test
     */
    public function clientCanDeleteBatchOrder()
    {
        $this->asClient('perfect_client@gmail.com');
        $batchOrder = $this->findRandomData('batch_orders');

        $response = $this->json('DELETE', route('api.legacy.client.orders.destroy', ['orderId' => $batchOrder->id]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS);

        $this->assertNull(BatchOrder::find($batchOrder->id));
    }

}
