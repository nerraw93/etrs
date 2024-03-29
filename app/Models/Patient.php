<?php

namespace App\Models;

use DB;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'code',
        'global_custom_id',
        'hpo_patient_id',
        'client_custom_id',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'mothers_maiden_name',
        'gender',
        'birth_date',
        'passport_number',
        'citizen',
        'blood_type',
        'address',
        'city',
        'senior_citizen_id',
        'telephone_number',
        'fax_number',
        'mobile_number',
        'occupation',
        'hmo_card',
        'hmo_card_no',
        'last_visit_at',
    ];

    /**
     *  The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'updated_at',
        'created_at',
        'birth_date',
    ];

    /**
     * Mutators
     */
     /**
      * Set the user's first name.
      *
      * @param  string  $value
      * @return void
      */
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
    }

    /**
     * Find patient by name
     *
     * @param  QueryBuilder $query                              the query builder to use
     * @param  String $name                                     the name to look for
     * @return QueryBuilder
     * @author goper
     */
    public function scopeFindByName($query, $name)
    {
        $name = strtolower($name);
        return $query->where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $name . '%')->orWhere("email", "like", "%$name%");
    }

    /**
     * Get patient that owned by this `Client`
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @author goper
     */
    public function scopeOwned($query)
    {
        return $query->where('client_id', get_client_id());
    }

    /**
     * Relationships
     */

    /**
     * Get user on this service
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }
}
