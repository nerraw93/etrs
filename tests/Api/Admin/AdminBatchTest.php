<?php

namespace Tests\Api\Admin;

use Tests\TestCase;
use App\Models\Batch;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminBatchTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function adminCanGetAllBatches()
    {
        $this->asAdmin();

        $response = $this->json('GET', route('api.admin.batch'));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);
        $this->assertEquals(Batch::count(), $data->batches->total);
    }

    /**
     * @test
     */
    public function adminCanFilterBatchStatus()
    {
        $this->asAdmin();
        $status = Batch::STATUS_CONFIRMED;
        $response = $this->json('GET', route('api.admin.batch', ['status' => $status]));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);
        $this->assertEquals(Batch::where('status', $status)->count(), $data->batches->total);

        foreach ($data->batches->data as $batch) {
            $this->assertEquals($status, $batch->status);
        }
    }

    /**
     * @test
     */
    public function adminCanSearchBatchAndFilterIt()
    {
        $this->asAdmin();

        $status = Batch::STATUS_CONFIRMED;
        $response = $this->json('GET', route('api.admin.batch', ['status' => $status, 'search' => 1]));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);
        $this->assertEquals(Batch::where('status', $status)->findById(1)->count(), $data->batches->total);

        foreach ($data->batches->data as $batch) {
            $this->assertEquals($status, $batch->status);
        }
    }
}
