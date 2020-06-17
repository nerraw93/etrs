<?php

namespace App\Http\Resources\Legacy;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = 'client';
        if ($this->role == User::ROLE_PROCESSOR)
            $role = 'processor';
        elseif ($this->role == User::ROLE_PATIENT)
            $role = 'patient';
        elseif ($this->role == User::ROLE_STAFF)
            $role = 'staff';
        elseif ($this->role == User::ROLE_ADMIN)
            $role = 'admin';

        $paymentMode = null;
        if ($this->role == User::PAYMENT_CASH)
            $paymentMode = 'cash';
        elseif ($this->role == User::PAYMENT_CHARGE)
            $paymentMode = 'charge';


        return [
            'id' => $this->id,
            'globalPrefix' => $this->globglobal_prefixalPrefix,
            'code' => $this->code,
            'type' => $role,
            'paymentMode' => $paymentMode,
            'emailAddress' => $this->email,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'username' => $this->username,
            'businessName' => $this->business_name,
            'businessAddress' => $this->business_address,
            'contactNumber' => $this->contact_number,
            'active' => $this->is_active,
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp,
        ];
    }
}
