<?php

namespace Tests\Api\Admin\System;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminGlobalPrefixTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetAdminGlobalPrefix()
    {
        $this->asAdmin();

        $response = $this->json('GET', route('api.admin.system.global_prefix'));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
                'global_prefix' => $this->user->global_prefix
            ]);

        $this->assertEquals(global_prefix(), $this->user->global_prefix);
        $this->assertEquals(global_prefix(), $data->global_prefix);

        // Check if global_prefix is in all caps
        $this->assertTrue(ctype_upper($data->global_prefix));
        $this->assertTrue(ctype_upper(global_prefix()));
    }

    /**
     * @test
     */
    public function canAdminUpdateGlobalPrefix()
    {
        $this->asAdmin();

        $newPrefix = $this->faker->randomLetter . $this->faker->randomLetter;

        $response = $this->json('POST', route('api.admin.system.global_prefix.update'), [
            'global_prefix' => $newPrefix,
        ]);

        $data = $response->getData();
        $newPrefix = strtoupper($newPrefix);
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.system.global_prefix.success.update', ['value' => $newPrefix]),
                'global_prefix' => $newPrefix,
            ]);

        $this->assertEquals(global_prefix(), $newPrefix);
        $this->assertEquals(global_prefix(), $data->global_prefix);
        // Check global_prefix is in uppercase
        $this->assertTrue(ctype_upper($data->global_prefix));
        $this->assertTrue(ctype_upper(global_prefix()));

        // Update back to `OL`
        $defaultValue = 'OL';
        $response = $this->json('POST', route('api.admin.system.global_prefix.update'), [
            'global_prefix' => $defaultValue,
        ]);

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.system.global_prefix.success.update', ['value' => $defaultValue]),
                'global_prefix' => $defaultValue,
            ]);

        $this->assertEquals(global_prefix(), $defaultValue);
        $this->assertEquals(global_prefix(), $data->global_prefix);
        // Check global_prefix is in uppercase
        $this->assertTrue(ctype_upper($data->global_prefix));
        $this->assertTrue(ctype_upper(global_prefix()));
    }
}
