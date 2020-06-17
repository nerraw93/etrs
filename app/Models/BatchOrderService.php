<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchOrderService extends Model
{
    /**
     * @{inheritdoc}
     */
    protected $table = "batch_order_services";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_order_id',
        'service_id',
    ];

    /**
     * Eager loaded relationship
     *
     * @var array
     */
    protected $with = [
        'service',
    ];

    /**
     * Relationships
     */

    /**
     * Get batch_order_test batch order
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function order()
    {
        return $this->belongsTo(BatchOrder::class, 'id', 'batch_order_id');
    }

    /**
     * Get batch_order_test services
     *
     * @return HasMany
     */
    public function service()
    {
        return $this->belongsTo(ClientService::class, 'service_id', 'service_id');
    }
}
