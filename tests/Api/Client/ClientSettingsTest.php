<?php

namespace Tests\Api\Client;

use DB;
use Hash;
use Tests\TestCase;
use \Carbon\Carbon;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientSettingsTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetClientProfileDetails()
    {
        $this->asClient();
        $response = $this->json('GET', route('api.client.settings.profile'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('user', $data);
        $responseUser = $data->user;
        
        $this->assertEquals($responseUser->id, $this->user->id);
        $this->assertEquals($responseUser->email, $this->user->email);
    }

    /**
     * @test
     */
    public function canUpdateClientProfileDetails()
    {
        $this->asClient();

        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $business_name = $this->faker->company;
        $business_address = $this->faker->address;
        $contact_number = $this->faker->tollFreePhoneNumber;

        $response = $this->json('POST', route('api.client.settings.update.profile'), [
            'id' => $this->user->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'business_name' => $business_name,
            'business_address' => $business_address,
            'contact_number' => $contact_number,
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.settings.success.profile_update'),
            ]);

        $this->assertObjectHasAttribute('user', $data);
        $responseUser = $data->user;

        $this->assertEquals($responseUser->first_name, $first_name);
        $this->assertEquals($responseUser->last_name, $last_name);
        $this->assertEquals($responseUser->business_name, $business_name);
        $this->assertEquals($responseUser->business_address, $business_address);
        $this->assertEquals($responseUser->contact_number, $contact_number);
    }

    /**
     * @test
     */
    public function cannotUpdateUserProfileIfProfileIsNotOwned()
    {
        $this->asClient();

        // Use this client id - to make update
        $hacker = User::where('id', '!=', $this->user->id)->client()->first();

        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $business_name = $this->faker->company;
        $business_address = $this->faker->address;
        $contact_number = $this->faker->tollFreePhoneNumber;

        $response = $this->json('POST', route('api.client.settings.update.profile'), [
            'id' => $hacker->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'business_name' => $business_name,
            'business_address' => $business_address,
            'contact_number' => $contact_number,
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_CLIENT_ERROR)
            ->assertJson([
                'success' => false,
                'message' => trans('validation.error'),
                'errors' => [
                    'id' => [trans('validation.touching_not_owned_data')]
                ]
            ])
            ->assertJsonValidationErrors(['id']);
    }

    /**
     * @test
     */
    public function clientCanUpdateTheirPassword()
    {
        $this->asClient();

        $newPassword = $this->faker->firstName;
        $constantPassword = 'secret';

        $response = $this->json('POST', route('api.client.settings.update.password'), [
            'id' => $this->user->id,
            'old_password' => $constantPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.settings.success.password_update'),
            ]);

        $this->assertObjectHasAttribute('user', $data);
        $responseUser = $data->user;
        $user = User::find($responseUser->id);
        // Check if password has been updated
        $this->assertTrue(Hash::check($newPassword, $user->password));

        // Reset back to 'secret'
        $response = $this->json('POST', route('api.client.settings.update.password'), [
            'id' => $this->user->id,
            'old_password' => $newPassword,
            'password' => $constantPassword,
            'password_confirmation' => $constantPassword,
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.client.settings.success.password_update'),
            ]);

        $this->assertObjectHasAttribute('user', $data);
        $responseUser = $data->user;
        $user = User::find($responseUser->id);
        // Check if password has been updated
        $this->assertTrue(Hash::check($constantPassword, $user->password));
    }

}
