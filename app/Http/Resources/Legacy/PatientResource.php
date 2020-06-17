<?php

namespace App\Http\Resources\Legacy;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Legacy\UserResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
			"code" => $this->code,
			"globalCustomId" => $this->global_custom_id,
			"clientCustomId" => $this->client_custom_id,
			"emailAddress" => $this->email,
			"firstName" => $this->first_name,
			"middleName" => $this->middle_name,
			"lastName" => $this->last_name,
			"gender" => $this->gender,
			"age" => \Carbon\Carbon::parse($this->birth_date)->age,
			"birthDateAsTimestamp" => \Carbon\Carbon::parse($this->birth_date)->timestamp,
			"birthDate" => $this->birth_date,
			"passportNumber" => $this->passport_number,
			"citizen" => $this->citizen,
			"bloodType" => $this->blood_type,
			"mothersMaidenName" => $this->mothers_maiden_name,
			"address" => $this->address,
			"city" => $this->city,
			"seniorCitizenId" => $this->senior_citizen_id,
			"telNumber" => $this->telephone_number,
			"faxNumber" => $this->fax_number,
			"mobileNumber" => $this->mobile_number,
			"occupation" => $this->occupation,
			"hmoCard" => $this->hmo_card,
			"hmoCardNo" => $this->hmo_card_no,
			"lastVisitAt" => $this->last_visit_at,
			"archivedAt" => !$this->deleted_at ? null : $this->deleted_at->timestamp,
			"createdAt" => $this->created_at->timestamp,
			"updatedAt" => $this->updated_at->timestamp,
            "client" => new UserResource($this->client),
        ];
    }
}
