<?php
namespace Tests\ApiLegacy\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Patient;

class LegacyClientPatientTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/patients'), route('api.legacy.client.patient.store'));
        $this->assertSame($this->legacy_base_api('/patients/1'), route('api.legacy.client.patient.update', ['patientId' => 1]));
        $this->assertSame($this->legacy_base_api('/patients/1'), route('api.legacy.client.patient.destroy', ['patientId' => 1]));
    }

    /**
     * @test
     */
    public function canStoreClientPatient()
    {
        $this->asClient();

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $gender = $this->faker->randomElement(['male', 'female']);
        $birth_date = $this->faker->date('m/d/Y');
        $passport = $this->faker->ean13;
        $citizen = 'Pilipino';
        $blood_type = $this->faker->randomElement(['O', 'A', 'B', 'AB']);
        $address = $this->faker->address;
        $city = $this->faker->city;
        $senior_citizen_id = $this->faker->ean13;
        $telephone_number = $this->faker->tollFreePhoneNumber;
        $occupation = $this->faker->jobTitle;

        $response = $this->json('POST', route('api.legacy.client.patient.store'), [
            'firstName' => $firstName,
            'middleName' => 'middlename',
            'lastName' => $lastName,
            'emailAddress' => $email,
            'gender' => $gender,
            'birthDate' => $birth_date,
            'passportNumber' => $passport,
            'citizen' => $citizen,
            'bloodType' => $blood_type,
            'mothersMaidenName' => 'mothersMaidenName',
            'address' => $address,
            'city' => $city,
            'telNumber' => $telephone_number,
            'faxNumber' => '9999999',
            'mobileNumber' => '888888',
            'hmoCardNo' => '111111111111',
            'hmoCard' => '22222222222222',
        ]);

        $data = $response->getData();

        $this->assertEquals($data->data->birthDateAsTimestamp, \Carbon\Carbon::parse($birth_date)->timestamp);
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->patientResponseStructure()
            ]);
    }

    /**
     * @test
     */
    public function clientCanUpdatePatient()
    {
        do {
            // Get random client patient
            $patient = Patient::with('client')->whereNotNull('email')->where('email', '<>', '')->orderByRaw('RAND()')->first();
            $client = $patient->client;
        } while(!$client);

        $this->asClient($client->email);

        $newFirstName = $this->faker->firstName;
        $newLastName = $this->faker->lastName;

        $response = $this->json('POST', route('api.legacy.client.patient.update', ['patientId' => $patient->id]), [
            'firstName' => $newFirstName,
            'middleName' => $patient->middle_name,
            'lastName' => $newLastName,
            'emailAddress' => $patient->email,
            'gender' => $patient->gender,
            'birthDate' => \Carbon\Carbon::parse($patient->birth_date)->format('m/d/Y'),
            'passportNumber' => $patient->passport_number,
            'citizen' => $patient->citizen,
            'bloodType' => $patient->blood_type,
            'mothersMaidenName' => $patient->mothers_maiden_name,
            'address' => $patient->address,
            'city' => $patient->city,
            'telNumber' => $patient->telephone_number,
            'faxNumber' => $patient->fax_number,
            'mobileNumber' => $patient->mobile_number,
            'hmoCardNo' => $patient->hmo_card_no,
            'hmoCard' => $patient->hmo_card,
        ]);

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->patientResponseStructure()
            ]);

        $model = Patient::find($patient->id);
        $this->assertEquals($model->first_name, $newFirstName);
        $this->assertEquals($model->last_name, $newLastName);
    }

    /**
     * @test
     */
    public function clientCanDeletePatient()
    {
        do {
            // Get random client patient
            $patient = Patient::with('client')->orderByRaw('RAND()')->first();
            $client = $patient->client;
        } while(!$client);


        $this->asClient($client->email);

        $response = $this->json('DELETE', route('api.legacy.client.patient.destroy', ['patientId' => $patient->id]));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->patientResponseStructure()
            ]);

        // Check on database that patient is `present` but `deleted_at` column is filled
        // Only patient is archived
        $archivePatient = Patient::withTrashed()->find($patient->id);
        $this->assertTrue($archivePatient->trashed());
    }

}
