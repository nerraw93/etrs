<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;

class LegacyPatientTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/patients'), route('api.legacy.admin.patients'));
    }

    /**
     * @test
     */
    public function adminCanGetAllPatients()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.legacy.admin.patients'));
        $data = $response->getData();
        
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->patientResponseStructure()
                ]
            ]);

        // Pagination
        $response = $this->json('GET', route('api.legacy.admin.patients', ['page' => 2]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->patientResponseStructure()
                ]
            ]);

        // Pagination with count
        $response = $this->json('GET', route('api.legacy.admin.patients', ['count' => 2]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->patientResponseStructure()
                ]
            ]);

        $this->assertEquals(count($data->data), 2);
    }

}
