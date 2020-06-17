<?php

namespace Tests\Api\Admin\Client;

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
    public function canGetClientServices()
    {
        $this->asAdmin();
        $user = $this->findRandomData('client_services');

        $response = $this->json('GET', route('api.admin.client.services', ['id' => $user->user_id]));
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => '',
            ]);

        $this->assertObjectHasAttribute('services', $data);
        $responseServices = $data->services;

        // Check on database if results match
        $client = User::withCount('clientServices')->find($user->user_id); // Test hasManyThrough relationship
        $this->assertEquals($responseServices->total, count($client->clientServices));

        foreach ($client->clientServices as $clientService) {
            $this->assertEquals($clientService->user_id, $user->user_id);
            $this->assertNotNull(Service::find($clientService->service_id));
        }
    }


    /**
     * @test
     */
    public function canStoreServiceToAClient()
    {
        $this->asAdmin();

        // Get client user and a service
        $user = $this->findRandomData('users', ['role' => User::ROLE_CLIENT]);
        $servicesTaken = ClientService::select('service_id')->where('user_id', $user->id)->get()->toArray();
        $service = Service::whereNotIn('id', $servicesTaken)->first();

        $name = User::find($user->id);
        $name = $name->full_name;

        $price = $this->faker->numberBetween(100, 9999);
        $services = [(object) ['id' => $service->id, 'price' => $price]];

        $response = $this->json('POST', route('api.admin.client.services.store', ['id' => $user->id]), [
            'user_id' => $user->code,
            'services' => $services,
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.client.service.success.store', ['name' => $name]),
                'client' => [
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'price' => $price,
                ],
            ]);
    }

    /**
     * @test
     */
    public function canUpdateClientServicePrice()
    {
        $this->asAdmin();

        // Get client user and a service
        $clientService = $this->findRandomData('client_services');
        $userId = $clientService->user_id; // User is not client

        $newPrice = $this->faker->numberBetween(100, 9999);
        $response = $this->json('POST', route('api.admin.client.services.update', [
            'id' => $userId,
            'serviceId' => $clientService->id
        ]), [
            'user_id' => $userId,
            'service_id' => $clientService->service_id,
            'price' => $newPrice
        ]);
        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.client.service.success.update'),
                'client' => [
                    'user_id' => $userId,
                    'service_id' => $clientService->service_id,
                    'price' => $newPrice,
                ],
            ]);
    }

    /**
     * @test
     * @depends canUpdateClientServicePrice
     */
    public function canAdminArchiveClientServices()
    {
        $this->asAdmin();

        $clientService = $this->findRandomData('client_services');
        $user = User::find($clientService->user_id);
        $deletedId = $clientService->id;

        $response = $this->json('POST', route('api.admin.client.services.destroy', [
            'id' => $clientService->id,
            'serviceId' => $deletedId,
        ]));

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.client.service.success.destroy'),
            ]);

        $this->assertNull(ClientService::find($deletedId));
    }
}
