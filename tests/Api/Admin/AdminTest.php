<?php

namespace Tests\Api\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchOrder;
use App\Models\BatchOrderService;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canAccessToAdminRoutes()
    {
        $this->asAdmin();

        $response = $this->json('GET', route('api.admin.client'));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

    }

    /**
     * @test
     */
    public function cannotAccessIfUserIsNotAdmin()
    {
        $this->asClient();

        $response = $this->json('GET', route('api.admin.client'));

        $response
            ->assertStatus(self::RESPONSE_REDIRECTION);
    }

    /**
     * @test
     */
    public function cannotAccessIfUserIsNotLoggedIn()
    {
        $response = $this->json('GET', route('api.admin.client'));
        $response
            ->assertStatus(self::RESPONSE_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function adminDashboardGetDraftBatches()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.admin.dashboard.batches_draft'));
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
    public function adminDashboardCanGetBatchConfirmedStatus()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.admin.dashboard.batches_confirmed'));
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
}
