<?php

namespace App\Http\Resources\Legacy;

use App\Models\BatchOrder;
use App\Models\ClientService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Legacy\UserResource;
use App\Http\Resources\Legacy\PatientResource;

class BatchOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = 'pending';
        if ($this->status == BatchOrder::CANCELLED_STATUS)
            $status = 'cancelled';
        elseif ($this->status == BatchOrder::DELETED_STATUS)
            $status = 'deleted';
        elseif ($this->status == BatchOrder::POSTED_STATUS)
            $status = 'posted';
        elseif ($this->status == BatchOrder::PROCESS_STATUS)
            $status = 'process';


        $tests = [];
        foreach ($this->services()->get() as $batchOrderService) {
            $clientService = $batchOrderService->service;
            array_push($tests, [
                "id" => $batchOrderService->service->id,
                "code" => $clientService->service->code,
                "name" => $clientService->service->name,
                "cost" => $clientService->price,
            ]);
        }

        return [
            "id" => $this->id,
            "idPrefix" => $this->id_prefix,
            "patient" => new PatientResource($this->patient),
            "clinicalInformation" => $this->clinical_information,
            "specialInstructions" => $this->special_instructions,
            "orNumber" => $this->or_number,
            "client" => new UserResource($this->client),
            "status" => $status,
            "isUrgent" => $this->is_urgent,
            "tests" => $tests,
            "createdAt" => $this->created_at->timestamp,
        ];
    }
}
