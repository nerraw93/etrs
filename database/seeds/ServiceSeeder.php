<?php

use App\Models\User;
use App\Models\Service;
use Faker\Factory as Faker;
use App\Models\ClientService;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=1; $i < 15; $i++) {
            $service = new Service();
            $service->code = str_random(10) . \Carbon\Carbon::now()->timestamp;
            $service->name = substr($faker->bs, 0, 40);
            $service->default_cost = $faker->numberBetween(100, 10000);
            $service->save();

            $client = User::orderByRaw('RAND()')->client()->first();

            $clientService = new ClientService();
            $clientService->service_id = $service->id;
            $clientService->user_id = $client->id;
            $clientService->price = $faker->numberBetween(100, 10000);
            $clientService->save();

            // Seed perfect_client at least two services
            if ($i < 10) {
                $client = User::where('email', 'perfect_client@gmail.com')->first();

                $clientService = new ClientService();
                $clientService->service_id = $service->id;
                $clientService->user_id = $client->id;
                $clientService->price = $faker->numberBetween(100, 10000);
                $clientService->save();
            }
        }
    }
}
