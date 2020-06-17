<?php

namespace Tests\Api\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use App\Models\PatientType;
use App\Models\ClientSource;
use App\Models\ClientService;
use App\Models\BatchOrderService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function clientCanAccessCLientMiddlewareRoutes()
    {
        $this->asClient();
        $response = $this->json('GET', route('api.client.staff'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('staffs', $data);
    }

    /**
     * @test
     */
    public function cannotRequestOnClientRoutesIfUserIsNotAClient()
    {
        // User is not client
        $this->asProcessor();

        $response = $this->json('GET', route('api.client.staff'));
        $response
            ->assertStatus(self::RESPONSE_REDIRECTION);
    }

    /**
     * @test
     */
    public function canGetClientSourcesData()
    {
        $clientSource = ClientSource::with('user')->orderByRaw('RAND()')->first();

        $this->asClient($clientSource->user->email);

        $response = $this->json('GET', route('api.client.sources'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);
        $user = User::with('sources')->find($clientSource->user->id);
        $this->assertObjectHasAttribute('sources', $data);
        $this->assertEquals(count($data->sources), count($user->sources));
    }

    /**
     * @test
     */
    public function canGetAllPatientTypes()
    {
        $this->asClient();

        $response = $this->json('GET', route('api.client.patient_types'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $patientTypes = PatientType::all();
        $this->assertObjectHasAttribute('patient_types', $data);
        $this->assertEquals(count($data->patient_types), count($patientTypes));
    }

    /**
     * @test
     */
    public function clientCanGetItsServices()
    {
        $this->asClient('perfect_client@gmail.com');

        $response = $this->json('GET', route('api.client.services'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $services = ClientService::where('user_id', $this->user->id)->get();
        $this->assertObjectHasAttribute('services', $data);
        $this->assertEquals(count($data->services), count($services));
    }

    /**
     * @test
     */
    public function clientCanGetOwnedBatchesThatAreDraft()
    {
        $this->asClient('perfect_client@gmail.com');

        $response = $this->json('GET', route('api.client.dashboard.batches_draft'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('batches', $data);
        $batches = $data->batches;
        $this->paginationTest($batches);

        foreach ($batches->data as $batch) {
            $this->assertEquals($batch->status, Batch::STATUS_DRAFT);
            // Test that this batch is owned by this user
            $this->assertEquals($batch->client_id, $this->user->id);
            $this->assertObjectHasAttribute('orders', $batch);

            // Check batch services_count if match on database
            $orders = $batch->orders;

            $services_count_db = 0;
            $orders_count_db = 0;

            foreach ($orders as $order) {
                $batchOrderServiceCount = BatchOrderService::where('batch_order_id', $order->id)->count();
                $services_count_db += $batchOrderServiceCount;

                $orders_count_db++;
            }
            // Check - services_count if equal
            $this->assertObjectHasAttribute('services_count', $batch);
            $this->assertEquals($batch->services_count, $services_count_db);

            // Check - total_patients
            $this->assertObjectHasAttribute('orders_count', $batch);
            $this->assertEquals($batch->orders_count, $orders_count_db);
        }
    }

    /**
     * @test
     */
    public function clientCanGetOwnedBatchesThatAreConfirmed()
    {
        $this->asClient('perfect_client@gmail.com');
        $response = $this->json('GET', route('api.client.dashboard.batches_confirmed'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('batches', $data);
        $batches = $data->batches;
        $this->paginationTest($batches);

        foreach ($batches->data as $batch) {
            $this->assertEquals($batch->status, Batch::STATUS_CONFIRMED);
            $this->assertObjectHasAttribute('orders', $batch);
            // Test that this batch is owned by this user
            $this->assertEquals($batch->client_id, $this->user->id);

            // Check batch services_count if match on database
            $orders = $batch->orders;

            $services_count_db = 0;
            $orders_count_db = 0;

            foreach ($orders as $order) {
                $batchOrderServiceCount = BatchOrderService::where('batch_order_id', $order->id)->count();
                $services_count_db += $batchOrderServiceCount;

                $orders_count_db++;
            }
            // Check - services_count if equal
            $this->assertObjectHasAttribute('services_count', $batch);
            $this->assertEquals($batch->services_count, $services_count_db);

            // Check - total_patients
            $this->assertObjectHasAttribute('orders_count', $batch);
            $this->assertEquals($batch->orders_count, $orders_count_db);
        }
    }

    /**
     * @test
     */
    public function clientCanSearchServices()
    {
        $this->asClient('perfect_client@gmail.com');
        $service = ClientService::where('user_id', $this->user->id)->orderByRaw('RAND()')->first();

        $key = substr($service->service->name, 0, 2);

        $response = $this->json('GET', route('api.client.services', ['key' => $key]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $services = ClientService::where('user_id', $this->user->id)->get();
        $this->assertObjectHasAttribute('services', $data);
    }
}
