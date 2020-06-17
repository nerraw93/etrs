<?php
namespace Tests\ApiLegacy\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Patient;
use App\Models\Batch;

class LegacyClientTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/clients/1/patients'), route('api.legacy.client.patient', ['clientId' => 1]));
        $this->assertSame($this->legacy_base_api('/clients/1/patients/search'), route('api.legacy.client.patient.search', ['clientId' => 1]));
        $this->assertSame($this->legacy_base_api('/clients/1/batches/search'), route('api.legacy.client.batches.search', ['clientId' => 1]));
    }

    /**
     * @test
     */
    public function canGetClientPatients()
    {
        $patient = Patient::orderByRaw('RAND()')->whereNull('deleted_at')->with('client')->first();

        $this->asClient($patient->client->email);
        $response = $this->json('GET', route('api.legacy.client.patient', ['clientId' => $patient->client->id]));
        $data = $response->getData();
        
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->patientResponseStructure()
                ]
            ]);

        $this->assertObjectHasAttribute('data', $data);

        // Check all patients are owned by the logged in client
        foreach ($data->data as $key => $patient) {
            $this->assertEquals($patient->client->id, $this->user->id);
        }

        $this->assertEquals(Patient::where([
            'client_id' => $patient->client->id,
            ])->count(), count($data->data));
    }

    /**
     * @test
     */
    public function canSearchOnClientPatient()
    {
        do {
            // Get random client patient
            $patient = Patient::with('client')->orderByRaw('RAND()')->first();
            $client = $patient->client;
        } while(!$client);
        // Get random client patient - and get it's name

        $this->asClient($client->email);

        $key = substr($patient->first_name, 0, 3);

        $response = $this->json('GET', route('api.legacy.client.patient.search', ['clientId' => $client->id]), [
            'name' => $key,
        ]);

        $data = $response->getData();

        $response
        ->assertStatus(self::RESPONSE_SUCCESS)
        ->assertJsonStructure([
            'data' => [
                $this->patientResponseStructure()
            ]
        ]);
    }

    /**
     * @test
     */
    public function canSearchOnbatches()
    {
        $this->asClient('perfect_client@gmail.com');
        $randomBatch = $this->findRandomData('batches', ['client_id' => $this->user->id, 'status' => 'draft']);

        $key = substr($randomBatch->id, 0, 4);
        $response = $this->json('GET', route('api.legacy.client.batches.search', ['clientId' => $this->user->id]), [
            'id' => $key,
            'status' => 'draft',
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->batchResponseStructure()
                ]
            ]);

        foreach ($data->data as $batch) {
            $this->assertEquals($batch->status, 'draft');
        }
    }

}
