<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientGlobalIdUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patientGlobalIdUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patient table global_custom_id turn into max of 10 characters.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $globalPrefix = global_prefix();
        $patients = Patient::withTrashed()->get();

        foreach ($patients as $patient) {
            $id = $patient->id;
            $globalCustomId = patient_global_custom_id_generator($id, $globalPrefix);

            $patient->global_custom_id = $globalCustomId;
            $patient->save();
            $this->info("Patient with id - $patient->id - has been updated - $globalCustomId.");
        }
    }
}
