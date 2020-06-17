<?php

namespace Tests\Api\User;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessorTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function processorUserCanGetOwnData()
    {
        $this->asProcessor();

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
        $this->assertEquals($data->user->role, User::ROLE_PROCESSOR);
    }
}
