<?php

namespace Tests\Api\Admin\Service;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\ClientService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminClientServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function canGetClientService()
    {
        $this->asAdmin();

        // Get client user and a service
        $clientService = $this->findRandomData('client_services');
        $response = $this->json('GET', route('api.admin.service.client', ['id' => $clientService->service_id]));
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('clients', $data);
        $this->assertNotEmpty($data->clients);
        $clients = $data->clients;
        $this->paginationTest($clients);

        // Check all clients is the owner of this service
        foreach ($clients->data as $client_service) {
            $this->assertEquals($client_service->service_id, $clientService->service_id);
            $this->assertObjectHasAttribute('user', $client_service);
        }
    }

    /**
     * @test
     */
    public function canStoreClientOnService()
    {
        $this->asAdmin();

        // Get client user and a service
        $user = $this->findRandomData('users', ['role' => User::ROLE_CLIENT]);
        $service = $this->findRandomData('services');
        $price = $this->faker->numberBetween(1, 10000);

        $name = User::find($user->id);
        $name = $name->full_name;

        $response = $this->json('POST', route('api.admin.service.client.store'), [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'price' => $price,
        ]);
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.service.client.success.store', ['name' => $name]),
                'client' => [
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'price' => $price,
                ],
            ]);

        $client = $data->client;
        $this->assertObjectHasAttribute('service', $client);
        $responseService = $client->service;

        // Check source response has source data on fields like code, name etc...
        $this->assertObjectHasAttribute('service', $client);
        $this->assertObjectHasAttribute('code', $responseService);
        $this->assertObjectHasAttribute('name', $responseService);

        // Check on DB if match on response about the `source` data
        $dbSource = Service::find($responseService->id);
        $this->assertEquals($dbSource->id, $responseService->id);
        $this->assertEquals($dbSource->code, $responseService->code);
        $this->assertEquals($dbSource->name, $responseService->name);
    }

    /**
     * @test
     */
    public function canStoreClientServicesMultiple()
    {
        $this->asAdmin();

        // Get client user and a service
        $user = $this->findRandomData('users', ['role' => User::ROLE_CLIENT]);
        $service = $this->findRandomData('services');
        $price = $this->faker->numberBetween(1, 10000);

        $name = User::find($user->id);
        $name = $name->full_name;

        $response = $this->json('POST', route('api.admin.service.client.store'), [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'price' => $price,
        ]);
        $data = $response->getData();
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.service.client.success.store', ['name' => $name]),
                'client' => [
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'price' => $price,
                ],
            ]);

        $client = $data->client;
        $this->assertObjectHasAttribute('service', $client);
        $responseService = $client->service;

        // Check source response has source data on fields like code, name etc...
        $this->assertObjectHasAttribute('service', $client);
        $this->assertObjectHasAttribute('code', $responseService);
        $this->assertObjectHasAttribute('name', $responseService);

        // Check on DB if match on response about the `source` data
        $dbSource = Service::find($responseService->id);
        $this->assertEquals($dbSource->id, $responseService->id);
        $this->assertEquals($dbSource->code, $responseService->code);
        $this->assertEquals($dbSource->name, $responseService->name);
    }

    /**
     * @test
     */
    public function cannotStoreNewClientServicesIfUserIsNotClient()
    {
        $this->asAdmin();

        // Get client user and a service
        $user = $this->findRandomData('users', ['role' => User::ROLE_ADMIN]); // User is not client
        $service = $this->findRandomData('services');
        $price = $this->faker->numberBetween(1, 10000);

        $response = $this->json('POST', route('api.admin.service.client.store'), [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'price' => $price,
        ]);

        $response
            ->assertStatus(self::RESPONSE_CLIENT_ERROR)
            ->assertJson([
                'success' => false,
                'message' => trans('validation.error'),
            ])
            ->assertJsonValidationErrors(['user_id']);
    }

    /**
     * @test
     */
    public function canAdminUpdateClientServicePrice()
    {
        $this->asAdmin();

        // Find random client service
        do {
            $client = $this->findRandomData('client_services');
        } while(!$user = User::find($client->user_id));

        $name = $user->full_name;

        $oldPrice = $client->price;
        $newPrice = $this->faker->numberBetween(1, 10000);

        $response = $this->json('POST', route('api.admin.service.client.update', ['id' => $client->id]), [
            'id' => $client->id,
            'price' => $newPrice,
        ]);

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.service.client.success.update', ['name' => $name]),
                'client' => [
                    'id' => $client->id,
                    'user_id' => $client->user_id,
                    'service_id' => $client->service_id,
                    'price' => $newPrice,
                ],
            ]);
    }

    /**
     * @test
     */
    public function canAdminDeleteClientService()
    {
        $this->asAdmin();

        do {
            $client = ClientService::orderByRaw('RAND()')->first();
            $user = User::find($client->user_id);
        } while (!$user);

        $name = $user->full_name;
        $deletedId = $client->id;
        $userId = $client->user_id;
        $serviceId = $client->service_id;

        $response = $this->json('POST', route('api.admin.service.client.destroy', ['id' => $deletedId]));
        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.service.client.success.destroy', ['name' => $name]),
            ]);
        $this->assertNull(ClientService::find($deletedId));
    }
}
