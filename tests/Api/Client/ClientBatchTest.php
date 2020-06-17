<?php

namespace Tests\Api\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use App\Models\ClientSource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientBatchTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetClientBatch()
    {
        $this->asClient('perfect_client@gmail.com');

        $response = $this->json('GET', route('api.client.batch'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('batches', $data);
        $batches = $data->batches;

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);

        // Check on database if results match
        $clientDatabaseResult = Batch::owned()->count();
        $this->assertEquals($batches->total, $clientDatabaseResult);
    }

    /**
     * @test
     */
    public function canStoreClientBatchInConfirmedMode()
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
            'is_confirmed' => Batch::STATUS_CONFIRMED,
        ]);
        $data = $response->getData();
        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.store'),
                'batch' => [
                    "code" => $newBatch->code,
                    "source_id" => $client_source->source_id,
                    'clinician_id' => $clinician->id,
                    'patient_type_id' => $patientType->id,
                    'client_id' => $this->user->id,
                    'dispatcher_id' => $dispatcher->id,
                    "payment_mode" => 0,
                    'slides' => 99,
                    "blood" => null,
                    "forms" => null,
                    "specimen" => null,
                    "status" => Batch::STATUS_CONFIRMED,
                ],
            ]);

        $this->assertObjectHasAttribute('batch', $data);
        $this->assertEquals($newBatch->source_id, $client_source->source_id);
        $this->assertEquals($newBatch->clinician_id, $clinician->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
    }

    /**
     * @test
     */
    public function canStoreBatchesWithNoClinician()
    {
        $this->asClient('perfect_client@gmail.com');

        // Find client that has `source` and `clinician`
        $client_source = $this->findRandomData('client_sources', ['user_id' => $this->user->id]);
        $patientType = \App\Models\PatientType::orderByRaw('RAND()')->first();
        $dispatcher = \App\Models\Dispatcher::orderByRaw('RAND()')->first();

        $response = $this->json('POST', route('api.client.batch.store'), [
            'source_id' => $client_source->source_id,
            'patient_type_id' => $patientType->id,
            'client_id' => $this->user->id,
            'dispatcher_id' => $dispatcher->id,
            'payment_mode' => 0,
            'slides' => 99,
            'is_confirmed' => Batch::STATUS_CONFIRMED,
        ]);
        $data = $response->getData();

        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.store'),
                'batch' => [
                    "code" => $newBatch->code,
                    "source_id" => $client_source->source_id,
                    'patient_type_id' => $patientType->id,
                    'client_id' => $this->user->id,
                    'dispatcher_id' => $dispatcher->id,
                    "payment_mode" => 0,
                    'slides' => 99,
                    "blood" => null,
                    "forms" => null,
                    "specimen" => null,
                    "status" => Batch::STATUS_CONFIRMED,
                ],
            ]);

        $this->assertObjectHasAttribute('batch', $data);
        $this->assertEquals($newBatch->source_id, $client_source->source_id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
    }

    /**
     * @test
     */
    public function canStoreClientBatchInDraftMode()
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
            'is_confirmed' => Batch::STATUS_DRAFT,
        ]);
        $data = $response->getData();
        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.store'),
                'batch' => [
                    "code" => $newBatch->code,
                    "source_id" => $client_source->source_id,
                    'clinician_id' => $clinician->id,
                    'patient_type_id' => $patientType->id,
                    'client_id' => $this->user->id,
                    'dispatcher_id' => $dispatcher->id,
                    "payment_mode" => 0,
                    'slides' => 99,
                    "blood" => null,
                    "forms" => null,
                    "specimen" => null,
                    "status" => Batch::STATUS_DRAFT,
                ],
            ]);

        $this->assertObjectHasAttribute('batch', $data);
        $this->assertEquals($newBatch->source_id, $client_source->source_id);
        $this->assertEquals($newBatch->clinician_id, $clinician->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
        $this->assertEquals($newBatch->patient_type_id, $patientType->id);
    }

    /**
     * @test
     */
    public function clientCanUpdateClientBatch()
    {
        $batch = Batch::orderByRaw('RAND()')->first();

        $this->asClient('perfect_client@gmail.com');
        $clinician_id = null;

        if ($batch->clinician) {
            $clinician_id = $batch->clinician->id;
        }

        $response = $this->json('POST', route('api.client.batch.update', ['id' => $batch->id]), [
            'source_id' => $batch->source->id,
            'clinician_id' => $clinician_id,
            'patient_type_id' => $batch->patientType->id,
            'client_id' => $this->user->id,
            'dispatcher_id' => $batch->dispatcher->id,
            'payment_mode' => 0,
            'slides' => 88,
            'is_confirmed' => Batch::STATUS_CONFIRMED,
        ]);
        $data = $response->getData();

        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.update'),
                'batch' => [
                    "code" => $newBatch->code,
                    "source_id" => $newBatch->source_id,
                    'clinician_id' => $newBatch->clinician_id,
                    'patient_type_id' => $newBatch->patient_type_id,
                    'client_id' => $this->user->id,
                    'dispatcher_id' => $newBatch->dispatcher_id,
                    "payment_mode" => 0,
                    'slides' => 88,
                    "blood" => null,
                    "forms" => null,
                    "specimen" => null,
                    "status" => Batch::STATUS_CONFIRMED,
                ],
            ]);

        $this->assertObjectHasAttribute('batch', $data);
    }

    /**
     * @test
     */
    public function clientCanDeleteBatch()
    {
        $batch = Batch::orderByRaw('RAND()')->first();

        $this->asClient('perfect_client@gmail.com');

        $response = $this->json('POST', route('api.client.batch.destroy', ['id' => $batch->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.destroy'),
            ]);

        // Check model is null
        $this->assertNull(Batch::find($batch->id));
    }

    /**
     * @test
     * @depends clientCanDeleteBatch
     */
    public function clientCannotDeleteBatchIfNotHisOwm()
    {
        $batch = Batch::orderByRaw('RAND()')->first();
        $this->asClient();

        $response = $this->json('POST', route('api.client.batch.destroy', ['id' => $batch->id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_NOT_FOUND);

        // Check model is null
        $this->assertNotNull(Batch::find($batch->id));
    }

    /**
     * @test
     */
    public function clientCanSearchUsingBatchNumber()
    {
        $this->asClient('perfect_client@gmail.com');

        // Search from database - find last_name
        $randomBatch = $this->findRandomData('batches', ['client_id' => $this->user->id]);

        $key = $randomBatch->id;

        $response = $this->json('GET', route('api.client.batch.search', ['key' => $key]));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);
    }

    /**
     * @test
     */
    public function clientCanGetOwnedBatchDetails()
    {
        $this->asClient('perfect_client@gmail.com');

        // Search from database - find last_name
        $randomBatch = $this->findRandomData('batches', ['client_id' => $this->user->id]);

        $id = $randomBatch->id;

        $response = $this->json('GET', route('api.client.batch.details', ['id' => $id]));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batch);
        $this->assertEquals($data->batch->id, $id);
    }

    /**
     * @test
     */
    public function cannotGetBatchDetailsIfUserIsNotTheOwnerOfBatch()
    {
        $this->asClient();

        // Search from database - find last_name
        $randomBatch = $this->findRandomData('batches');
        $id = $randomBatch->id;

        $response = $this->json('GET', route('api.client.batch.details', ['id' => $id]));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_NOT_FOUND);
    }

    /**
     * @test
     */
    public function clientCanFilterBatchStatus()
    {
        $this->asClient('perfect_client@gmail.com');
        $status_params = Batch::STATUS_DRAFT;

        $response = $this->json('GET', route('api.client.batch.search', ['key' => 0, 'status' => $status_params]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->batches);
        $this->paginationTest($data->batches);

        foreach ($data->batches->data as $batch) {
            // Check if all batches are same with the status parameters on search
            $this->assertEquals($batch->status, $status_params);
            // Check all batches return are come from the user
            $this->assertEquals($this->user->id, $batch->client_id);
        }
    }

    /**
     * @test
     * @depends clientCanUpdateClientBatch
     */
    public function canUpdateBatchWihNoClinicianAndAddClinician()
    {
        $batch = Batch::orderByRaw('RAND()')->whereNull('clinician_id')->first();
        $this->assertNull($batch->clinician_id);
        $this->asClient('perfect_client@gmail.com');

        $clinician = $this->findRandomData('clinicians', ['user_id' => $this->user->id]);

        $response = $this->json('POST', route('api.client.batch.update', ['id' => $batch->id]), [
            'source_id' => $batch->source->id,
            'clinician_id' => $clinician->id,
            'patient_type_id' => $batch->patientType->id,
            'client_id' => $this->user->id,
            'dispatcher_id' => $batch->dispatcher->id,
            'payment_mode' => 0,
            'slides' => 88,
            'is_confirmed' => Batch::STATUS_CONFIRMED,
        ]);
        $data = $response->getData();

        $newBatch = $data->batch;

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.batch.success.update'),
                'batch' => [
                    "code" => $newBatch->code,
                    "source_id" => $newBatch->source_id,
                    'clinician_id' => $newBatch->clinician_id,
                    'patient_type_id' => $newBatch->patient_type_id,
                    'client_id' => $this->user->id,
                    'dispatcher_id' => $newBatch->dispatcher_id,
                    "payment_mode" => 0,
                    'slides' => 88,
                    "blood" => null,
                    "forms" => null,
                    "specimen" => null,
                    "status" => Batch::STATUS_CONFIRMED,
                ],
            ]);

        $this->assertObjectHasAttribute('batch', $data);
    }
}
