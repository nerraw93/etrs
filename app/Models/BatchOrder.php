<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchOrder extends Model
{
    use SoftDeletes;

    const URGENT = 1;
    const MINOR = 0;

    const PENDING_STATUS = 0;
    const CANCELLED_STATUS = 1;
    const DELETED_STATUS = 2;
    const POSTED_STATUS = 3;
    const PROCESS_STATUS = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'batch_id',
        'patient_id',
        'id_prefix',
        'or_number',
        'clinical_information',
        'special_instructions',
        'status',
        'is_urgent',
    ];

    /**
     * Eager loaded relationship
     *
     * @var array
     */
    protected $with = [
        'services',
        'patient',
    ];

    /**
     * Get client batch_orders
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
     * Get client batch_orders in `DRAFT` mode
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @author goper
     */
    public function scopeDraft($query)
    {
        return $query->where('status', self::PENDING_STATUS);
    }

    /**
     * Get client batch_orders in `DRAFT` mode
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @author goper
     */
    public function scopePosted($query)
    {
        return $query->where('status', self::POSTED_STATUS);
    }

    /**
     * Relationships
     */

    /**
     * Get batch_order client
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    /**
     * Get batch_order patient
     *
     * @return HasOne
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    /**
     * Get order's batch
     *
     * @author goper
     * @return HasOne
     */
    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    /**
     * Get services on this order
     *
     * @author goper
     * @return HasOne
     */
    public function services()
    {
        return $this->hasMany(BatchOrderService::class, 'batch_order_id', 'id');
    }
}
