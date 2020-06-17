<?php

use App\Models\User;
use App\Models\Source;
use App\Models\ClientSource;
use Illuminate\Database\Seeder;

class BatchDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Seed client sources
        for ($i=0; $i < 10; $i++) {
            $client = User::client()->orderByRaw('RAND()')->first();
            $source = Source::orderByRaw("RAND()")->first();

            // ClientSource
            $clientSource = new ClientSource();
            $clientSource->user_id = $client->id;
            $clientSource->source_id = $source->id;
            $clientSource->save();
        }

        $perfectClient = User::where('email', 'perfect_client@gmail.com')->first();

        $batch = new \App\Models\Batch();
        $batch->code = str_random(5) . \Carbon\Carbon::now()->timestamp;
        $batch->source_id = \App\Models\ClientSource::where('user_id', $perfectClient->id)->first()->id;
        $batch->clinician_id = \App\Models\Clinician::where('user_id', $perfectClient->id)->first()->id;
        $batch->patient_type_id = \App\Models\Clinician::first()->id;
        $batch->client_id = $perfectClient->id;
        $batch->dispatcher_id = \App\Models\Dispatcher::first()->id;
        $batch->payment_mode = 0;
        $batch->slides = 0;
        $batch->blood = 0;
        $batch->forms = 0;
        $batch->specimen = 0;
        $batch->status = 1;
        $batch->save();

        // Seed batch that are in draft mode
        $batch = new \App\Models\Batch();
        $batch->code = str_random(5) . \Carbon\Carbon::now()->timestamp;
        $batch->source_id = \App\Models\ClientSource::where('user_id', $perfectClient->id)->first()->id;
        $batch->clinician_id = \App\Models\Clinician::where('user_id', $perfectClient->id)->first()->id;
        $batch->patient_type_id = \App\Models\Clinician::first()->id;
        $batch->client_id = $perfectClient->id;
        $batch->dispatcher_id = \App\Models\Dispatcher::first()->id;
        $batch->payment_mode = 0;
        $batch->slides = 0;
        $batch->blood = 0;
        $batch->forms = 0;
        $batch->specimen = 0;
        $batch->status = 0;
        $batch->save();
    }
}
