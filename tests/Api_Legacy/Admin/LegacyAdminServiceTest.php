<?php

namespace Tests\ApiLegacy\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;

class LegacyAdminServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isLoginRouteIsRight()
    {
        $this->assertSame($this->legacy_base_api('/service/prices'), route('api.legacy.admin.services.post'));
    }

    /**
     * @test
     */
    public function canStoreService()
    {
        $this->asAdmin();
        $code = $this->getRandomUniqueData('services', 'code', 'words', ['nb' => 3, 'asText' => true]);
        $name = $this->getRandomUniqueData('services', 'name', 'bs');
        $default_cost = $this->faker->numberBetween(100, 10000);

        $response = $this->json('POST', route('api.legacy.admin.services.post'), [
            'serviceCode' => $code,
            'sourceCode' => $name,
            'defaultCost' => $default_cost,
        ]);
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    'serviceCode',
                    'sourceCode',
                    'defaultCost',
                ]
            ]);

        $model = Service::where('code', $code)->first();
        $this->assertNotNull($model);
        $this->assertEquals($model->default_cost, $default_cost);
        $this->assertEquals($model->name, $name);

        $this->assertEquals($data->data->serviceCode, $code);
        $this->assertEquals($data->data->sourceCode, $name);
        $this->assertEquals($data->data->defaultCost, $default_cost);

        // Update
        $randomServices = $this->findRandomData('services');
        $name = $this->getRandomUniqueData('services', 'name', 'bs');
        $default_cost = $this->faker->numberBetween(100, 10000);

        $response = $this->json('POST', route('api.legacy.admin.services.post'), [
            'serviceCode' => $randomServices->code,
            'sourceCode' => $name,
            'defaultCost' => $default_cost,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJsonStructure([
                'data' => [
                    'serviceCode',
                    'sourceCode',
                    'defaultCost',
                ]
            ]);

        $model = Service::find($randomServices->id);
        $responseService = $data->data;
        $this->assertNotNull($model);
        $this->assertEquals($model->default_cost, $responseService->defaultCost);
        $this->assertEquals($model->name, $responseService->sourceCode);
    }
}
