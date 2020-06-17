<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    const STATUS_DRAFT = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_ACCOMPLISHED = 2;

    const PAYMENT_CASH = 0;
    const PAYMENT_CHARGE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'code',
        'source_id',
        'clinician_id',
        'patient_type_id',
        // 'dispatcher_id',
        'payment_mode',
        'status',
        'slides',
        'blood',
        'forms',
        'specimen',
        'pdf_path',
        'barcode_path',
        'encoded_by',
    ];

    /**
     * Eager loaded relationship
     *
     * @var array
     */
    protected $with = [
        'dispatcher',
        'source',
        'clinician',
        'patientType',
        'client',
        'orders',
    ];

    /**
     * Find batch by id
     *
     * @param  QueryBuilder $query                              the query builder to use
     * @param  String $name                                     the name to look for
     * @return QueryBuilder
     * @author goper
     */
    public function scopeFindById($query, $id)
    {
        return $query->where('id', 'LIKE', '%' . $id . '%');
    }

    /**
     * Filter batch status
     *
     * @param  QueryBuilder $query                              the query builder to use
     * @param  String $name                                     the name to look for
     * @return QueryBuilder
     * @author goper
     */
    public function scopeFilterStatus($query, $status)
    {
        return $query->where('status', $status)->orderBy('created_at', 'asc');
    }

    /**
     * Get client batch_orders in `DRAFT` mode
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @author goper
     */
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    /**
     * Get client batch_orders in `DRAFT` mode
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @author goper
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Get client batches
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
     * Get the batch source
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function source()
    {
        return $this->hasOne(Source::class, 'id', 'source_id');
    }

    /**
     * Get the batch clinician
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clinician()
    {
        return $this->hasOne(Clinician::class, 'id', 'clinician_id');
    }

    /**
     * Get the client who created this batch
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function client()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    /**
     * Get batch patient_type
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patientType()
    {
        return $this->hasOne(PatientType::class, 'id', 'patient_type_id');
    }

    /**
     * Get batch dispatcher
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dispatcher()
    {
        return $this->belongsTo(Dispatcher::class, 'dispatcher_id', 'id');
    }

    /**
     * Get batch orders
     *
     * @author goper
     * @return hasMany
     */
    public function orders()
    {
        return $this->hasMany(BatchOrder::class, 'batch_id', 'id');
    }

    /**
     * Get all of the posts for the country.
     */
    public function services()
    {
        return $this->hasManyThrough(BatchOrderService::class, BatchOrder::class);
    }
}
