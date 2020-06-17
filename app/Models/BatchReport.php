<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_id',
        'code',
    ];

    /**
     * Relationships
     */

    /**
     * Get batch on this lab_transaction
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    /**
     * Get batch_lab order
     *
     * @return HasOne
     */
    public function order()
    {
        return $this->hasOne(BatchOrder::class, 'id', 'batch_order_id');
    }
}
