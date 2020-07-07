<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Service extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'default_cost'
    ];

    public function getNameAttribute($name) {
        return ucwords($name);
    }

    /**
     * Get services of client
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(User::class, 'client_services', 'service_id', 'user_id')->withPivot('price');
    }

    /**
     * Get tests on this service
     *
     * @return hasMany
     */
    public function tests()
    {
        return $this->hasMany(BatchOrderService::class, 'service_id', 'id');
    }

    /**
     * Find service by name or code
     *
     * @param  QueryBuilder $query                              the query builder to use
     * @param  String $name                                     the name to look for
     * @return QueryBuilder
     * @author goper
     */
    public function scopeSearch($query, $key)
    {
        $key = strtolower($key);
        return $query->where('name', 'LIKE', '%' . $key . '%')->orWhere("code","like","%$key%");
    }
}
