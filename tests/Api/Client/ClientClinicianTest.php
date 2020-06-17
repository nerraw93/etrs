<?php

namespace Tests\Api\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clinician;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientClinicianTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetClientClinicians()
    {
        $allClinician = Clinician::all();
        if ($allClinician->count() == 0) {
            $this->assertEmpty($allClinician);
        } else {

            do {
                // Get client that has `clinicians`
                $clinician = Clinician::with('client')->orderByRaw('RAND()')->first();
                $client = User::find($clinician->user_id);
            } while(!$client);

            if ($clinician) {

                $this->asClient($client->email);
                $response = $this->json('GET', route('api.client.settings.clinician'));
                $data = $response->getData();
                $response
                    ->assertStatus(self::RESPONSE_SUCCESS)
                    ->assertJson([
                        'success' => true,
                        'message' => '',
                    ]);

                $this->assertObjectHasAttribute('clinicians', $data);
                $clinicians = $data->clinicians;

                $this->assertNotEmpty($data->clinicians);
                $this->paginationTest($data->clinicians);

                // Check on database if results match
                $clientDatabaseResult = Clinician::where('user_id', $this->user->id)->count();
                $this->assertEquals($clinicians->total, $clientDatabaseResult);
            } else {
                $this->assertEmpty($clinician);
            }
        }

    }

    /**
     * @test
     */
    public function canStoreClientOnClinician()
    {
        $this->asClient();

        $name = $this->faker->name;

        $response = $this->json('POST', route('api.client.settings.clinician.store'), [
            'name' => $name,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.settings.clinician.success.store'),
                'clinician' => [
                    'user_id' => $this->user->id,
                    'name' => $name,
                ],
            ]);

        $this->assertObjectHasAttribute('clinician', $data);
        $this->assertNotEmpty(Clinician::where(['user_id' => $this->user->id, 'name' => $name])->get());
    }

    /**
     * @test
     */
    public function canUpdateClientCliniciansName()
    {
        do {
            // Get client that has `clinicians`
            $clinician = Clinician::orderByRaw('RAND()')->first();
            $client = User::find($clinician->user_id);
        } while(!$client);

        if ($clinician) {
            $this->asClient($client->email);

            $new_name = $this->faker->name;

            $response = $this->json('POST', route('api.client.settings.clinician.update', [
                'id' => $clinician->id
            ]), [
                'id' => $clinician->id,
                'name' => $new_name,
            ]);
            $data = $response->getData();
            $response
                ->assertStatus(self::RESPONSE_SUCCESS)
                ->assertJson([
                    'success' => true,
                    'message' => trans('message.client.settings.clinician.success.update'),
                    'clinician' => [
                        'user_id' => $this->user->id,
                        'name' => $new_name,
                    ],
                ]);

            $this->assertObjectHasAttribute('clinician', $data);
            $database = Clinician::where(['user_id' => $this->user->id, 'name' => $new_name])->first();
            $this->assertEquals($database->user_id, $this->user->id);
            $this->assertEquals($database->name, $new_name);

        } else {
            $this->assertEmpty($clinician);
        }
    }

    /**
     * @test
     */
    public function clientCanDestroyClinician()
    {
        // Get client that has `clinicians`
        $clinician = Clinician::orderByRaw('RAND()')->first();

        if ($clinician) {
            $client = User::find($clinician->user_id);
            $this->asClient($client->email);

            $response = $this->json('POST', route('api.client.settings.clinician.destroy', [
                'id' => $clinician->id
            ]));
            $data = $response->getData();
            $response
                ->assertStatus(self::RESPONSE_SUCCESS)
                ->assertJson([
                    'success' => true,
                    'message' => trans('message.client.settings.clinician.success.destroy'),
                ]);

            $database = Clinician::find($clinician->id);
            $this->assertNull($database);

        } else {
            $this->assertEmpty($clinician);
        }
    }

    /**
     * @test
     */
    public function cannotDestroyClinicianIfClinicianIsNotOwnedByTheClient()
    {
        $allClinician = Clinician::all();
        if ($allClinician->count() == 0) {
            $this->assertEmpty($allClinician);
        } else {
            // Get client that has `clinicians`
            $clinician = Clinician::orderByRaw('RAND()')->first();
            $real_owner = User::find($clinician->user_id);

            if ($clinician) {
                $client = User::where('id', '!=', $clinician->user_id)->client()->first();
                $this->asClient($client->email);

                $new_name = $this->faker->name;

                $response = $this->json('POST', route('api.client.settings.clinician.destroy', [
                    'id' => $clinician->id
                ]));
                $data = $response->getData();

                $response
                    ->assertStatus(self::RESPONSE_NOT_FOUND);

                // Check data has not been deleted
                $database = Clinician::find($clinician->id);
                $this->assertNotNull($database);

            } else {
                $this->assertEmpty($clinician);
            }
        }

    }
}
