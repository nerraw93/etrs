<?php

namespace App\Http\Resources\Legacy;

use App\Models\BatchOrder;
use App\Models\ClientService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Legacy\UserResource;

class WhiteListedIpResource extends JsonResource
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
            "user" => new UserResource($this->user),
            "address" => $this->address,
        ];
    }


}
