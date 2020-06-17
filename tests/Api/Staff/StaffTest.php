<?php

namespace Tests\Api\Staff;

use Tests\TestCase;
use App\Models\User;
use App\Models\Batch;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canLoggedInAsStaff()
    {
        $this->loggedPerfectStaff();
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
        $this->assertEquals($data->user->role, User::ROLE_STAFF);
    }

    /**
     * @test
     */
    public function staffCannAccessClientRoutes()
    {
        $this->asStaff();
        $response = $this->json('GET', route('api.client.patient'));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('patients', $data);
    }

    /**
     * @test
     */
    public function staffCannotAccessRoutesOnViewingStaffOrCreatingStaff()
    {
        $this->asStaff();
        $response = $this->json('GET', route('api.client.staff'));
        $response
            ->assertStatus(self::RESPONSE_REDIRECTION);
    }

    /**
     * @test
     */
    public function staffCanGetDataSameAsClient()
    {
        $this->asStaff();

        $response = $this->json('GET', route('api.client.batch'));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('batches', $data);
    }
}
