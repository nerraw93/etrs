<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchOrder;

class LegacyAdminBatchOrderTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/transactions/1'), route('api.legacy.admin.transactions', ['transactionId' => 1]));
        $this->assertSame($this->legacy_base_api('/transactions/1/status'), route('api.legacy.admin.transactions.update', ['transactionId' => 1]));
    }

    /**
     * @test
     */
    public function adminCanGetBatchOrder()
    {
        $this->asAdmin();
        $randomBatchOrder = $this->findRandomData('batch_orders');

        $response = $this->json('GET', route('api.legacy.admin.transactions', ['transactionId' => $randomBatchOrder->id]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchOrderResponseStructure()
            ]);
    }

    /**
     * @test
     */
    public function adminCannotGetBatchOrderDetailsIfIdOrOrderDoesntExist()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.legacy.admin.transactions', ['transactionId' => 99889599853132651]));
        $data = $response->getData();
        $response
            ->assertStatus(self::LEGACY_RESPONSE_CLIENT_ERROR)
            ->assertJsonStructure([
                'errors' => [
                    $this->errorResponseStructure()
                ],
            ]);
    }

    /**
     * @test
     */
    public function adminCanUpdateBatchOrderStatus()
    {
        $this->asAdmin();
        $randomBatchOrder = $this->findRandomData('batch_orders', ['status' => BatchOrder::PENDING_STATUS]);

        $response = $this->json('POST', route('api.legacy.admin.transactions.update', ['transactionId' => $randomBatchOrder->id]), [
            'status' => 'process'
        ]);
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchOrderResponseStructure()
            ]);

        $order = $data->data;
        $this->assertEquals($order->id, $randomBatchOrder->id);
        $this->assertEquals($order->status, 'process');
    }

}
