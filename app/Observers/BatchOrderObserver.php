<?php

namespace App\Observers;

use App\Models\BatchOrder;
use DB;

class BatchOrderObserver
{
    /**
     * Handle the batch "created" event.
     *
     * @param  \App\BatchOrder  $batchOrder
     * @return void
     */
    public function created(BatchOrder $batchOrder)
    {
        // Get date-created of this order!
        $dateCreated = $batchOrder->created_at;
        $prefixYear = $dateCreated->format("y");
        $prefixCustom = env('BATCH_ORDER_PREFIX', '07');
        $prefix = $prefixYear . $prefixCustom;
        // Check if this year already on the database -
        if (!BatchOrder::where('id_prefix', 'like', "$prefix%")->first()) {
            // Alter increment - start count on this `$prefixYear`!
            $startOn = $prefix . '000002';
            // Next insertion will be start at xxxxx2
            $startOn = (int)$startOn;
            DB::update("ALTER TABLE batch_orders AUTO_INCREMENT = $startOn;");
            // Update this order_id!
            $batchOrder->id_prefix = $startOn - 1;
        } else {
            $id = $batchOrder->id;
            $batchOrder->id_prefix = $id;
        }

        $batchOrder->save();
    }

    /**
     * Handle the batch "updated" event.
     *
     * @param  \App\Batch  $batchOrder
     * @return void
     */
    public function updated(BatchOrder $batchOrder)
    {
        //
    }

    /**
     * Handle the batch "deleted" event.
     *
     * @param  \App\BatchOrder  $batchOrder
     * @return void
     */
    public function deleted(BatchOrder $batchOrder)
    {
        $batchOrder->status = BatchOrder::DELETED_STATUS;
        $batchOrder->save();
    }

    /**
     * Handle the batch "restored" event.
     *
     * @param  \App\BatchOrder  $batchOrder
     * @return void
     */
    public function restored(BatchOrder $batchOrder)
    {
        //
    }

    /**
     * Handle the batch "force deleted" event.
     *
     * @param  \App\BatchOrder  $batchOrder
     * @return void
     */
    public function forceDeleted(BatchOrder $batchOrder)
    {
        //
    }
}
