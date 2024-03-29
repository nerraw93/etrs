<?php

namespace Tests\Api\Admin\System;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Source;

class AdminSourceTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetSourceList()
    {
        $this->asAdmin();

        $response = $this->json('GET', route('api.admin.system.source'));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->sources);
        $this->paginationTest($data->sources);

    }

    /**
     * @test
     */
    public function canAdminStoreNewSource()
    {
        $this->asAdmin();

        $name = $this->getRandomUniqueData('sources', 'name', 'company');
        $code = $this->getRandomUniqueData('sources', 'code', 'word');

        $response = $this->json('POST', route('api.admin.system.source.store'), [
            'name' => $name,
            'code' => $code,
        ]);

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.system.source.success.store'),
                'source' => [
                    'name' => $name,
                    'code' => $code,
                ],
            ]);
    }

    /**
     * @test
     */
    public function canAdminUpdateSource()
    {
        $this->asAdmin();

        // Find random client
        $source = $this->findRandomData('sources');
        $name = $source->name;

        $newName = $this->getRandomUniqueData('sources', 'name', 'word');

        $response = $this->json('POST', route('api.admin.system.source.update', ['name' => $name]), [
            'id' => $source->id,
            'name' => $newName,
            'code' => $source->code,
        ]);

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.system.source.success.update', ['name' => $name]),
                'source' => [
                    'id' => $source->id,
                    'code' => $source->code,
                    'name' => $newName,
                ],
            ]);
    }

    /**
     * @test
     */
    public function canAdminDeleteSource()
    {
        $this->asAdmin();

        // Client
        $source = Source::first();
        $deletedId = $source->id;
        $response = $this->json('POST', route('api.admin.system.source.destroy', ['id' => $source->id]));
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.system.source.success.destroy'),
            ]);
        $this->assertNull(Source::find($deletedId));
    }

    /**
     * @test
     */
    public function canAdminSearchOnSourceUsingCodeOrName()
    {
        $this->asAdmin();

        $randomSource = $this->findRandomData('sources');
        $key = substr($randomSource->name, 0, 3);
        $key = strtolower($key);

        $response = $this->json('GET', route('api.admin.system.source.search', ['key' => $key]));

        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertNotEmpty($data->sources);
        $this->paginationTest($data->sources);
    }
}
