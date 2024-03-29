<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SourcesSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(DispatcherSeeder::class); // Seed on live
        $this->call(WhiteListIpSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(ClientRelatedDataSeeder::class);
        $this->call(BatchDataSeeder::class);
        $this->call(AddStaffOnClients::class);
    }
}
