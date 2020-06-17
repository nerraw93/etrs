<?php

namespace App\Observers;

use App\Models\BatchReport;

class BatchReportObserver
{
    /**
     * Handle the batch "created" event.
     *
     * @param  \App\Batch  $batch
     * @return void
     */
    public function created(BatchReport $batch)
    {
        $batch->code = int_to_code($batch->id);
        $batch->save();
    }
}
