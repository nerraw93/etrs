<?php

use App\Models\User;
use App\Models\Clinician;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientRelatedDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
            $client = User::client()->orderByRaw('RAND()')->first();

            // Create clinician on this client
            $clinician = new Clinician();
            $clinician->user_id = $client->id;
            $clinician->name = $faker->firstName;
            $clinician->save();
        }

        // Seed perfect client
        $client = User::where('email', 'perfect_client@gmail.com')->first();

        // Create clinician on this client
        $clinician = new Clinician();
        $clinician->user_id = $client->id;
        $clinician->name = $faker->firstName;
        $clinician->save();

        // Seed client sources
        $source = \App\Models\Source::orderByRaw('RAND()')->first();
        $clientSource = new \App\Models\ClientSource();
        $clientSource->user_id = $client->id;
        $clientSource->source_id = $source->id;
        $clientSource->save();

        // Seed patient type
        // Create PatientType
        $patientType = new \App\Models\PatientType();
        $patientType->code = str_random(5);
        $patientType->name = $faker->firstName;
        $patientType->save();

    }
}
