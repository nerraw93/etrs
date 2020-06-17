<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;

class LegacyAdminBatchTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/batches'), route('api.legacy.admin.batches'));
        $this->assertSame($this->legacy_base_api('/batches/1'), route('api.legacy.admin.batches.details', ['batchId' => 1]));
        $this->assertSame($this->legacy_base_api('/batches/1'), route('api.legacy.admin.batches.update', ['batchId' => 1]));
        $this->assertSame($this->legacy_base_api('/batches/1'), route('api.legacy.admin.batches.destroy', ['batchId' => 1]));
        $this->assertSame($this->legacy_base_api('/batches/1/reports'), route('api.legacy.admin.batches.report.post', ['batchId' => 1]));
    }

    /**
     * @test
     */
    public function canGetBatches()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.legacy.admin.batches'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        // Pagination
        $response = $this->json('GET', route('api.legacy.admin.batches', ['count' => 2, 'page' => 2]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        // Pagination with count
        $response = $this->json('GET', route('api.legacy.admin.batches', ['count' => 2]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        $this->assertEquals(count($data->data), 2);

        // Pagination with status
        $response = $this->json('GET', route('api.legacy.admin.batches', ['count' => 2, 'page' => 1, 'status' => 'draft']));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        $this->assertEquals(count($data->data), 2);
        foreach ($data->data as $batch) {
            $this->assertEquals($batch->status, 'draft');
        }

        // Pagination with status
        $response = $this->json('GET', route('api.legacy.admin.batches', ['page' => 1, 'status' => 'finish']));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        foreach ($data->data as $batch) {
            $this->assertEquals($batch->status, 'finish');
        }
    }

    /**
     * @test
     */
    public function adminCanUpdateBatchStatus()
    {
        $this->asAdmin();
        $randomBatch = $this->findRandomData('batches', ['status' => 0]);

        $response = $this->json('POST', route('api.legacy.admin.batches.update', ['batchId' => $randomBatch->id]), [
            'status' => 'finish'
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchResponseStructure()
            ]);

        $this->assertEquals($randomBatch->id, $data->data->id);
        $this->assertEquals($data->data->status, 'finish');
    }

    /**
     *
     */
    public function adminCanDeleteBatch()
    {
        $this->asAdmin();
        $randomBatch = $this->findRandomData('batches', ['status' => 0]);
        if ($randomBatch) {
            $response = $this->json('DELETE', route('api.legacy.admin.batches.destroy', ['batchId' => $randomBatch->id]));
            $data = $response->getData();
            $response
                ->assertStatus(self::RESPONSE_SUCCESS);

            $this->assertNull(Batch::find($randomBatch->id));
        } else {
            $this->assertNull($randomBatch);
        }
    }

    /**
     * @test
     */
    public function createTestBatch()
    {
        $this->asClient('perfect_client@gmail.com');

        // Find client that has `source` and `clinician`
        $client_source = $this->findRandomData('client_sources', ['user_id' => $this->user->id]);
        $clinician = $this->findRandomData('clinicians', ['user_id' => $this->user->id]);
        $patientType = \App\Models\PatientType::orderByRaw('RAND()')->first();
        $dispatcher = \App\Models\Dispatcher::orderByRaw('RAND()')->first();

        $response = $this->json('POST', route('api.client.batch.store'), [
            'source_id' => $client_source->source_id,
            'clinician_id' => $clinician->id,
            'patient_type_id' => $patientType->id,
            'client_id' => $this->user->id,
            'dispatcher_id' => $dispatcher->id,
            'payment_mode' => 0,
            'slides' => 99,
            'is_confirmed' => 0,
        ]);
        $data = $response->getData();
        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS);

        $this->assertObjectHasAttribute('batch', $data);
        $this->assertEquals($newBatch->source_id, $client_source->source_id);
        $this->assertEquals($newBatch->clinician_id, $clinician->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
        $this->assertEquals($newBatch->status, 0);

        $count = Batch::where('client_id', $this->user->id)->count();
        Batch::orderByRaw('RAND()')->where('client_id', $this->user->id)->limit($count/4)->update(['status' => 0]);
    }

    /**
     * @test
     */
    public function adminCanGetBatchReports()
    {
        $this->asAdmin();
        $randomBatch = $this->findRandomData('batches');

        $response = $this->json('POST', route('api.legacy.admin.batches.report.post', ['batchId' => $randomBatch->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->batchResponseStructure()
            ]);

        $this->assertEquals($randomBatch->id, $data->data->id);
    }

}
