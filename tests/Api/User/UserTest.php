<?php

namespace Tests\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetLoggedInUserData()
    {
        $this->loggedUserClient();
        Passport::actingAs($this->user);

        $response = $this->json('GET', route('api.user.me'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->user);
        $this->assertEquals($data->user->id, $this->user->id);
    }

    /**
     * @test
     */
    public function cannotGetIfUserIsNotLoggedIn()
    {
        $response = $this->json('GET', route('api.user.me'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Unauthenticated.',
            ]);
    }

    /**
     * @test
     */
    public function userCanGetAdminAnnouncements()
    {
        $this->asClient();

        $response = $this->json('GET', route('api.user.announcements.unread'));
        $data = $response->getData();
        dd($data);
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
    public function userCanGetAllAnnouncements()
    {
        $this->asClient();

        $response = $this->json('GET', route('api.user.announcements.all'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);
    }
}
