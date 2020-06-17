<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;

class LegacyAdminClientTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/clients'), route('api.legacy.admin.client'));
        $this->assertSame($this->legacy_base_api('/clients/search'), route('api.legacy.admin.client.search'));
        $this->assertSame($this->legacy_base_api('/clients/1'), route('api.legacy.admin.client.destroy', ['id' => 1])); // Delete
    }

    /**
     * @test
     */
    public function canGetClientList()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.legacy.admin.client'));
        $data = $response->getData();
        
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->userResponseStructure()
                ]
            ]);

        // Pagination
        $response = $this->json('GET', route('api.legacy.admin.client', ['page' => 2]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->userResponseStructure()
                ]
            ]);

        // Pagination with count
        $response = $this->json('GET', route('api.legacy.admin.client', ['count' => 2]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->userResponseStructure()
                ]
            ]);

        $this->assertEquals(count($data->data), 2);
    }

    /**
     * @test
     */
    public function canSearchClient()
    {
        $this->asAdmin();
        $key = 'a';
        $response = $this->json('GET', route('api.legacy.admin.client.search', ['name' => $key]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    $this->userResponseStructure()
                ]
            ]);

        $data = $data->data;
        $this->assertNotEmpty($data);
        $sampleResult = $data[0];
        $name = $sampleResult->firstName . ' ' . $sampleResult->lastName;

        $isFound = false;
        if (Str::contains($name, $key))
            $isFound = true;
        elseif (Str::contains(strtolower($sampleResult->email), $key))
            $isFound = true;

        $this->assertTrue($isFound);
    }

    /**
     * @test
     */
    public function canDestroyClient()
    {
        $this->asAdmin();

        // Client
        $client = User::client()->first();
        $deletedId = $client->id;
        $response = $this->json('DELETE', route('api.legacy.admin.client.destroy', ['id' => $client->id]));
        $response
            ->assertStatus(self::RESPONSE_SUCCESS);
        $this->assertNull(User::find($deletedId));
    }
}
