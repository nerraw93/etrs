<?php

namespace Tests\ApiLegacy\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;

class ApiLegacyTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function legacyErrorResponse()
    {
        $response = $this->json('POST', route('api.legacy.login'), [
            'xAuthUsername' => 'none_existing_username',
            'xAuthPassword' => 'secret',
            'xAuthMode' => 'clientAuth',
        ]);

        $response
            ->assertStatus(self::LEGACY_RESPONSE_CLIENT_ERROR)
            ->assertExactJson([
                'errors' => [
                    [
                        'code' => self::LEGACY_RESPONSE_CLIENT_ERROR,
                        'message' => 'The selected username is invalid.'
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function legacyApiErrorCustomMessageResponse()
    {
        $this->asClient();

        $response = $this->json('POST', route('api.legacy.login'), [
            'xAuthUsername' => $this->user->username,
            'xAuthPassword' => 'secret',
            'xAuthMode' => 'clientAuth',
        ]);

        $response
            ->assertStatus(self::LEGACY_RESPONSE_CLIENT_ERROR)
            ->assertExactJson([
                'errors' => [
                    [
                        'code' => self::LEGACY_RESPONSE_CLIENT_ERROR,
                        'message' => trans('message.auth.login.error.already_login')
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function legacySuccessResponse()
    {
        $user = User::orderByRaw('RAND()')->first();

        $response = $this->json('POST', route('api.legacy.login'), [
            'xAuthUsername' => $user->username,
            'xAuthPassword' => 'secret',
            'xAuthMode' => 'clientAuth',
        ]);

        $responseData = $this->getPostResponse($response);
        $data = $responseData->data;
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertExactJson([
                'data' => [
                    'refresh_token' => $data->refresh_token,
                    'expires_in' => $data->expires_in,
                    'oauthToken' => $data->oauthToken,
                    'user' => (array) $data->user,
                ]
            ]);

        // Check if response has `logged_in_user`
        $this->assertObjectHasAttribute('user', $data);
        $this->assertObjectHasAttribute('oauthToken', $data);
        $this->assertSame($user->id, $data->user->id);
    }


}
