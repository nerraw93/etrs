<?php

namespace App\Http\Controllers\ApiLegacy\Client;

use Hash;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLegacy\Client\PatientStoreRequest;

use App\Http\Resources\Legacy\PatientResource;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $clientId)
    {
        return PatientResource::collection(Patient::where([
            'client_id' => $clientId,
        ])->get());
    }

    /**
     * Search client based on key
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $clientId)
    {
        $patients = Patient::where('client_id', $clientId)->findByName(rtrim($request->name))->get();
        return PatientResource::collection($patients);
    }

    /**
     * Store
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(PatientStoreRequest $request)
    {
        $timestamp = \Carbon\Carbon::now()->timestamp;

        $patient = new Patient();
        $patient->client_id = get_client_id();

        $patient->code = $timestamp;
        $patient->global_custom_id = $timestamp;
        $patient->hpo_patient_id = $timestamp;

        $patient->first_name = $request->firstName;
        $patient->middle_name = $request->middleName;
        $patient->last_name = $request->lastName;
        $patient->mothers_maiden_name = $request->mothersMaidenName;
        $patient->gender = $request->gender;
        $patient->birth_date = $request->birthDate;
        $patient->client_custom_id = $request->clientCustomId;
        $patient->email = $request->emailAddress;
        $patient->passport_number = $request->passportNumber;
        $patient->citizen = $request->citizen;
        $patient->blood_type = $request->bloodType;
        $patient->address = $request->address;
        $patient->city = $request->city;
        $patient->senior_citizen_id = $request->seniorCitizenId;
        $patient->telephone_number = $request->telNumber;
        $patient->fax_number = $request->faxNumber;
        $patient->mobile_number = $request->mobileNumber;
        $patient->hmo_card = $request->hmoCard;
        $patient->hmo_card_no = $request->hmoCardNo;
        $patient->occupation = $request->occupation;
        $patient->last_visit_at = $request->lastVisitAt;
        $patient->save();

        return new PatientResource(Patient::find($patient->id));
    }

    /**
     * Update
     * @param  [type] $patientId [description]
     * @return [type]            [description]
     */
    public function update(PatientStoreRequest $request, $patientId)
    {
        $patient = Patient::owned()->findOrFail($patientId);
        $patient->first_name = $request->firstName;
        $patient->middle_name = $request->middleName;
        $patient->last_name = $request->lastName;
        $patient->mothers_maiden_name = $request->mothersMaidenName;
        $patient->gender = $request->gender;
        $patient->birth_date = $request->birthDate;
        $patient->client_custom_id = $request->clientCustomId;
        $patient->email = $request->emailAddress;
        $patient->passport_number = $request->passportNumber;
        $patient->citizen = $request->citizen;
        $patient->blood_type = $request->bloodType;
        $patient->address = $request->address;
        $patient->city = $request->city;
        $patient->senior_citizen_id = $request->seniorCitizenId;
        $patient->telephone_number = $request->telNumber;
        $patient->fax_number = $request->faxNumber;
        $patient->mobile_number = $request->mobileNumber;
        $patient->hmo_card = $request->hmoCard;
        $patient->hmo_card_no = $request->hmoCardNo;
        $patient->occupation = $request->occupation;
        $patient->last_visit_at = $request->lastVisitAt;
        $patient->save();

        return new PatientResource(Patient::find($patient->id));
    }

    /**
     * destroy
     * @param  [type] $patientId [description]
     * @return [type]            [description]
     */
    public function destroy($patientId)
    {
        Patient::owned()->findOrFail($patientId)->delete();
        return new PatientResource(Patient::withTrashed()->find($patientId));
    }
}
