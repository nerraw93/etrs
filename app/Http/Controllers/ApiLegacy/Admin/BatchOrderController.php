<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\Batch;
use App\Models\BatchOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\BatchOrderResource;
use App\Http\Requests\ApiLegacy\Admin\UpdateBatchOrderStatus;

class BatchOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $transactionId)
    {
        return new BatchOrderResource(BatchOrder::findOrFail($transactionId));
    }

    /**
     * Update
     * @param  Request $request       [description]
     * @param  [type]  $transactionId [description]
     * @return [type]                 [description]
     */
    public function update(UpdateBatchOrderStatus $request, $transactionId)
    {
        $status = $request->status == 'done' ? BatchOrder::POSTED_STATUS : BatchOrder::PROCESS_STATUS;
        $model = BatchOrder::findOrFail($transactionId)->update([
            'status' => $status
        ]);
        return new BatchOrderResource(BatchOrder::findOrFail($transactionId));
    }

}
