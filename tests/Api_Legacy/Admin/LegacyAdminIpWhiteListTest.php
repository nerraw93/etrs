<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\WhiteListedIp;

class LegacyAdminIpWhiteListTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/white-list/ips'), route('api.legacy.admin.white.list.post'));
        $this->assertSame($this->legacy_base_api('/white-list/ips'), route('api.legacy.admin.white.list'));
        $this->assertSame($this->legacy_base_api('/white-list/ips/1'), route('api.legacy.admin.white.list.destroy', ['whiteListId' => 1]));
    }

    /**
     * @test
     */
    public function adminCanCreateIpWhiteList()
    {
        $this->asAdmin();
        $address = $this->getRandomUniqueData('white_listed_ips', 'address', 'ipv4');
        $response = $this->json('POST', route('api.legacy.admin.white.list.post'), [
            'ipAddress' => $address
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->ipWhiteListResponseStructure()
            ]);
        $ipResponse = $data->data;
        $model = WhiteListedIp::find($ipResponse->id);
        $this->assertNotNull($model);
        $this->assertEquals($model->address, $ipResponse->address);

        // Add address with user
        $randomUser = $this->findRandomData('users', ['role' => 0]);
        $address = $this->getRandomUniqueData('white_listed_ips', 'address', 'ipv4');
        $response = $this->json('POST', route('api.legacy.admin.white.list.post'), [
            'ipAddress' => $address,
            'userId' => $randomUser->id,
        ]);

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => $this->ipWhiteListResponseStructure(false)
            ]);
        $ipResponse = $data->data;
        $model = WhiteListedIp::find($ipResponse->id);
        $this->assertNotNull($model);
        $this->assertEquals($model->address, $ipResponse->address);
        $this->assertEquals($randomUser->id, $ipResponse->user->id);
    }

    /**
     * @test
     */
    public function canGetIpWhitelists()
    {
        $this->asAdmin();
        $response = $this->json('GET', route('api.legacy.admin.white.list'));
        $data = $response->getData();
        
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [$this->ipWhiteListResponseStructure()]
            ]);

        // Filter - client
        $response = $this->json('GET', route('api.legacy.admin.white.list'), [
            'filter' => 'client'
        ]);

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [$this->ipWhiteListResponseStructure()]
            ]);

        $ips = $data->data;
        foreach ($ips as $ip) {
            $this->assertNotNull($ip->user);
            $this->assertEquals($ip->user->type, 'client');
        }
    }

    /**
     * @test
     */
    public function adminCanDeleteIpWhiteList()
    {
        $this->asAdmin();
        $white_listed_ip = WhiteListedIp::first();
        $deletedId = $white_listed_ip->id;

        $response = $this->json('DELETE', route('api.legacy.admin.white.list.destroy', [
            'whiteListId' => $deletedId
        ]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS);

        $this->assertNull(WhiteListedIp::find($deletedId));
    }

}
