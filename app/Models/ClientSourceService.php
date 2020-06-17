<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSourceService extends Model
{
    protected $table = "client_source_services";

    protected $fillable = [
        'user_id',
        'source_id',
        'service_id',
        'price',
    ];

    protected $with = [
        'service',
    ];

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
