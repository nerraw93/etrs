<?php

namespace App\Http\Resources\Legacy;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Batch;
use App\Http\Resources\Legacy\UserResource;
use App\Http\Resources\Legacy\BatchOrderResource;

class BatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment_mode = 'cash';
        if ($this->payment_mode == Batch::PAYMENT_CHARGE)
            $payment_mode = 'charge';

        $status = 'draft';
        if ($this->status == Batch::STATUS_CONFIRMED)
            $status = 'sent';
        elseif ($this->status == Batch::STATUS_ACCOMPLISHED)
            $status = 'finish';

        $labTestsCount = 0;
        foreach ($this->orders() as $order) {
            $labTestsCount += $order->services()->count();
        }

        $source = null;
        if ($this->source)
            $source = $this->source->toArray();


        $clinician_name = '';
        if ($this->clinician)
            $clinician_name = $this->clinician->name;

        $dispathcer_name = '';
        if ($this->client) {
            if ($this->client->dispatcher)
                $dispathcer_name = $this->client->dispatcher->name;
        }

        $patient_type_name = '';
        if ($this->patientType)
            $patient_type_name = $this->patientType->name;

        return [
            "id" => $this->id,
            "code" => $this->code,
            "source" => $source,
            "clinician" => $clinician_name,
            "dispatchMode" => $dispathcer_name,
            "patientType" => $patient_type_name,
            "paymentMode" => $payment_mode,
            "status" => $status,
            "tag" => $this->tag_mode,
            "slides" => $this->slides,
            "blood" => $this->blood,
            "forms" => $this->forms,
            "specimen" => $this->specimen,
            "encodedBy" => $this->encoded_by,
            "createdAt" => $this->created_at->timestamp,
            "updatedAt" => $this->updated_at->timestamp,
            "createdBy" => new UserResource($this->client),
            "transactionsCount" => $this->orders()->count(),
            "labTestsCount" => $labTestsCount,
            "reportId" => $this->pdf_path,
            "transactions" => BatchOrderResource::collection($this->orders()->get()),
        ];
    }
}
