<?php

namespace App\Console\Commands;

use DB;
use Str;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchOrder;
use Illuminate\Console\Command;
use App\Helpers\MigratorHelperTrait;

/**
 * Migrate old database and insert old data to new database
 *
 * @author goper
 */
class DatabaseMigrator extends Command
{
    use MigratorHelperTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etrs:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old database to new one and apply changes. Add to .env the old database value.';

    private $connection;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->connection = DB::connection('old_db');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->seedDispatchersTable();
        $this->seedUsersTable();
        $this->seedClinicians();
        $this->seedIpWhiteList();
        $this->seedPatientTypes();
        $this->seedServices();
        $this->seedCLientServices();
        $this->seedClientPatients();
        $this->seedSources();
        $this->seedClientSources();
        $this->seedClientStaff();
        $this->seedBatches();
    }

    /**
     * Seed `disaptchers` table
     * @return void
     */
    public function seedDispatchersTable()
    {
        $dispatchers = $this->getDataFromTable('dispatchers');
        foreach ($dispatchers as $dispatcher) {
            $model = new \App\Models\Dispatcher();
            $model->code = $dispatcher->code;
            $model->name = $dispatcher->name;
            $model->save();
        }

        $this->comment("Dispatcher table finished seeding.");
    }

    /**
     * Seed `batches` table
     *
     * @return void
     */
    public function seedBatches()
    {
        $prefix = 658000001;
        DB::update("ALTER TABLE batches AUTO_INCREMENT = $prefix;");

        $batches = $this->getDataFromTable('batches');
        $count = 0;
        foreach ($batches as $batch) {
            $count++;
            $clinicianId = null;

            $source = $this->getDataFromOldToNew('sources', $batch->source, 'name', 'name');
            // Can't find the source `name`, try the source `code`
            if (!$source) {
                $source = $this->getDataFromOldToNew('sources', $batch->source, 'code', 'code');
            }

            if ($source) {
                $model = new Batch();

                if ($batch->clinician != '' || $batch->clinician != null) {
                    $clinicianId = $this->getDataFromOldToNew('clinicians', $batch->clinician, 'name');

                    if (!$clinicianId)
                        $clinicianId = null;
                    else
                        $clinicianId = $clinicianId->id;
                }

                $client = $this->getUser($batch->createdById);

                $patientType = $this->getPatientTypes($batch->patientType);

                $model->code = str_random(5) . \Carbon\Carbon::now()->timestamp;
                $model->source_id = $source->id;
                $model->clinician_id = $clinicianId;
                $model->patient_type_id = $patientType->id;
                // $model->dispatcher_id = $this->getDispatherId($batch->dispatchMode);
                $model->payment_mode = $batch->paymentMode == 'charge' ? \App\Models\Batch::PAYMENT_CHARGE : \App\Models\Batch::PAYMENT_CASH;

                $model->client_id = $client->id;

                $status = Batch::STATUS_DRAFT;
                if ($batch->status == 'draft')
                    $status = Batch::STATUS_DRAFT;
                elseif ($batch->status == 'finish')
                    $status = Batch::STATUS_ACCOMPLISHED;
                elseif ($batch->status == 'sent')
                    $status = Batch::STATUS_CONFIRMED;

                $model->status = $status;

                $model->slides = $batch->slides;
                $model->blood = $batch->blood;
                $model->forms = $batch->forms;
                $model->specimen = is_int($batch->specimen) ? $batch->specimen : null;
                $model->updated_at = $batch->updatedAt;
                $model->created_at = $batch->createdAt;
                $model->save();
                $this->info("Batch has been added count - $count.");

                // Seed orders - get batchOrders on this batch
                $orders = $this->getBatchOrders($batch->id);

                foreach ($orders as $order) {
                    $data = $this->getBatchOrderData($order->transactionId);
                    $patient = $this->getPatient($data->patientId);

                    //------------------------------------------------
                    $dateCreated = $data->createdAt;
                    $prefixYear = \Carbon\Carbon::parse($dateCreated)->format("y");
                    $prefixCustom = env('BATCH_ORDER_PREFIX', '07');
                    $prefix = $prefixYear . $prefixCustom;
                    // Check if this year already on the database -
                    if (!\App\Models\BatchOrder::where('id_prefix', 'like', "$prefix%")->first()) {
                        // Alter increment - start count on this `$prefixYear`!
                        $startOn = $prefix . '000002';
                        // Next insertion will be start at xxxxx2
                        $startOn = (int)$startOn;
                        DB::update("ALTER TABLE batch_orders AUTO_INCREMENT = $startOn;");
                    }
                    //------------------------------------------------

                    $batchOrderModel = new \App\Models\BatchOrder();

                    $batchOrderModel->client_id = $client->id;
                    $batchOrderModel->id_prefix = $data->id_prefix;
                    $batchOrderModel->batch_id = $model->id;
                    $batchOrderModel->patient_id = $patient->id;

                    $batchOrderModel->or_number = $data->orNumber;
                    $batchOrderModel->clinical_information = $data->clinicalInformation;
                    $batchOrderModel->special_instructions = $data->specialInstructions;

                    $status = BatchOrder::PENDING_STATUS;

                    if ($data->status == 'cancelled')
                        $status = BatchOrder::CANCELLED_STATUS;
                    elseif ($data->status == 'deleted')
                        $status = BatchOrder::DELETED_STATUS;
                    elseif ($data->status == 'posted')
                        $status = BatchOrder::POSTED_STATUS;

                    $batchOrderModel->status = $status;
                    $batchOrderModel->is_urgent = $data->isUrgent;
                    $batchOrderModel->updated_at = $data->updatedAt;
                    $batchOrderModel->created_at = $data->createdAt;
                    $batchOrderModel->save();
                }

            } else {
                $this->error("Batch empty source! count - $count with source name -$batch->source-.");
            }

        }

        $this->comment("Batches table finished seeding.");
    }

    /**
     * Seed `client_staffs` table
     *
     * @return void
     */
    public function seedClientStaff()
    {
        $clientStaffs = $this->getDataFromTable('client_staff');
        foreach ($clientStaffs as $clientStaff) {
            $model = new \App\Models\ClientStaff();

            $client = $this->getUser($clientStaff->clientId);
            $staff = $this->getUser($clientStaff->userId);

            $model->client_id = $client->id;
            $model->staff_id = $staff->id;
            $model->save();
            $this->info("Client named $client->username has beed added $staff->username as staff.");
        }
        $this->comment("Client_staff has finished seeding.");
    }

    /**
     * Seed `sources` table
     *
     * @return void
     */
    public function seedSources()
    {
        $sources = $this->getDataFromTable('sources');
        foreach ($sources as $source) {
            $model = new \App\Models\Source();
            $model->code = $source->code;
            $model->name = $source->name;
            $model->save();
            $this->info("Source $source->name has beed added.");
        }
        $this->comment("Sources table has finished seeding.");
    }

    /**
     * Seed `client_sources` table
     *
     * @return void
     */
    public function seedClientSources()
    {
        $clientSources = $this->getDataFromTable('client_sources');

        foreach ($clientSources as $clientSource) {
            $model = new \App\Models\ClientSource();

            $user = $this->getUser($clientSource->userId);
            $source = $this->getDataFromOldToNew('sources', $clientSource->sourceId, 'name');

            $model->user_id = $user->id;
            $model->source_id = $source->id;
            $model->save();
            $this->info("Source `$source->name` has been added to client $user->username");

        }
        $this->comment("Client_sources table has finished seeding.");
    }

    /**
     * Seed client_patients data
     *
     * @return void
     */
    public function seedClientPatients()
    {
        $clientPatients = $this->getDataFromTable('client_patients');

        foreach ($clientPatients as $clientPatient) {
            $model = new \App\Models\Patient();

            $user = $this->getUser($clientPatient->clientId);
            $timestamp = \Carbon\Carbon::now()->timestamp;

            $model->client_id = $user->id;

            $model->code = $timestamp;
            $model->global_custom_id = $timestamp;
            $model->hpo_patient_id = $timestamp;

            $model->client_custom_id = $clientPatient->clientCustomId;
            $model->email = $clientPatient->emailAddress;
            $model->first_name = $clientPatient->firstName;
            $model->middle_name = $clientPatient->middleName;
            $model->last_name = $clientPatient->lastName;
            $model->mothers_maiden_name = $clientPatient->mothersMaidenName;
            $model->gender = $clientPatient->gender;
            $model->passport_number = $clientPatient->passportNumber;
            $model->citizen = $clientPatient->citizen;
            $model->blood_type = $clientPatient->bloodType;
            $model->address = $clientPatient->address;
            $model->city = $clientPatient->city;
            $model->senior_citizen_id = $clientPatient->seniorCitizenId;
            $model->telephone_number = $clientPatient->telNumber;
            $model->fax_number = $clientPatient->faxNumber;
            $model->mobile_number = $clientPatient->mobileNumber;
            $model->occupation = $clientPatient->occupation;
            $model->hmo_card = $clientPatient->hmoCard;
            $model->hmo_card_no = $clientPatient->hmoCardNo;
            $model->last_visit_at = $clientPatient->lastVisitAt;

            $birth_date = \Carbon\Carbon::createFromFormat('Y-m-d', $clientPatient->birthDate)->format('m/d/Y');
            $model->birth_date = $birth_date;

            $model->deleted_at = $clientPatient->archivedAt;
            $model->updated_at = $clientPatient->updatedAt;
            $model->created_at = $clientPatient->createdAt;
            $model->save();

            $this->info("$clientPatient->firstName $clientPatient->lastName patient table finished.");
        }
        $this->comment("Patients table has been seeded.");
    }

    private function seedUsersTable()
    {
        $users = $this->getDataFromTable('users');

        foreach ($users as $user) {
            if (User::where('email', $user->emailAddress)->count() == 0) {
                $model = new User();

                if ($user->dispatchMode != '' || $user->dispatchMode != null) {
                    $model->dispatcher_id = $this->getDispatherId($user->dispatchMode);
                }

                if ($user->type == 'admin') {
                    $model->role = User::ROLE_ADMIN;
                    $model->global_prefix = $user->globalPrefix;
                } elseif ($user->type == 'client') {
                    $model->role = User::ROLE_CLIENT;
                } elseif ($user->type == 'processor') {
                    $model->role = User::ROLE_CLIENT;
                } elseif ($user->type == 'staff') {
                    $model->role = User::ROLE_STAFF;
                }

                if ($user->paymentMode == 'charge')
                    $model->payment_mode = User::PAYMENT_CHARGE;
                elseif ($user->paymentMode == 'cash')
                    $model->payment_mode = User::PAYMENT_CASH;

                $model->username = $user->username;
                $model->password = ($user->username == 'test_admin4041') ? bcrypt('hpo_staging2020') : bcrypt('secret');
                $model->email = $user->emailAddress;

                if ($user->firstName)
                    $model->first_name = $user->firstName;
                else
                    $model->first_name = Str::before($user->emailAddress, '@');

                if ($user->lastName)
                    $model->last_name = $user->lastName;
                else
                    $model->last_name = Str::before($user->emailAddress, '@');

                $model->contact_number = $user->contactNumber;
                $model->business_name = $user->businessName;
                $model->business_address = $user->businessAddress;
                $model->is_active = $user->active;
                $model->updated_at = $user->createdAt;
                $model->created_at = $user->updatedAt;
                $model->save();
                $this->info("Users $user->emailAddress has been added.");
            } else {
                $this->error("This email $user->emailAddress has not added because of duplicate.");
            }

        }
        $this->comment("Users table finished.");
    }

    /**
     * Seed clinicians
     *
     * @return void
     */
    public function seedClinicians()
    {
        $clinicans = $this->getDataFromTable('clinicians');
        foreach ($clinicans as $clinician) {
            $model = new \App\Models\Clinician();
            $newDbUser = $this->getUser($clinician->userId);

            $model->user_id = $newDbUser->id;
            $model->name = $clinician->name;
            $model->save();

            $this->info("$clinician->name clinician has been added.");
        }

        $this->comment("Clinicians table finished.");
    }

    /**
     * Sedd ip_white_list to  `white_listed_ips
     * `
     * @return void
     */
    public function seedIpWhiteList()
    {
        $ips = $this->getDataFromTable('ip_white_list');
        foreach ($ips as $ip) {
            $model = new \App\Models\WhiteListedIp();
            $model->address = $ip->address;
            $model->save();
        }
        $this->comment("Ip White list table finished.");
    }

    /**
     * Seed patienttypes
     *
     * @return void
     */
    public function seedPatientTypes()
    {
        $types = $this->getDataFromTable('patient_types');
        foreach ($types as $type) {
            $model = new \App\Models\PatientType();
            $model->code = $type->code;
            $model->name = $type->name;
            $model->save();
        }
        $model = new \App\Models\PatientType();
        $model->code = 'WI';
        $model->name = 'WALK-IN';
        $model->save();
        $this->comment("Patient types table finished.");
    }

    /**
     * Seed services table
     *
     * @return void
     */
    public function seedServices()
    {
        $services = $this->getDataFromTable('services', 'createdAt');

        foreach ($services as $service) {
            try {

                $model = new \App\Models\Service();
                $model->code = $service->code;
                $model->name = $service->name;
                $model->default_cost = $service->defaultCost;
                $model->save();

                $this->info("Service named $service->name has been added.");

            } catch (\Exception $e) {
                $this->error("Service named $service->name is duplicate, didn't add.");
            }
        }
        $this->comment("Services table finished.");
    }

    /**
     * Seed client_services
     *
     * @return void
     */
    public function seedCLientServices()
    {
        $clientServices = $this->getDataFromTable('client_services');
        foreach ($clientServices as $clientService) {
            $model = new \App\Models\ClientService();

            $user = $this->getUser($clientService->userId);
            $service = $this->getDataFromOldToNew('services', $clientService->serviceId, 'name');

            $model->user_id = $user->id;
            $model->service_id = $service->id;
            $model->price = $clientService->price;
            $model->save();
            $this->info("Client services named $service->name, table finished.");
        }

        $this->comment("Client services table finished.");
    }

}
