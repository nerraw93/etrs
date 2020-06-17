<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\BatchResource;
use App\Http\Requests\ApiLegacy\Admin\UpdateBatchStatus;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $count = 30;
        if ($request->has('count'))
            $count = $request->count;

        $batches = Batch::when($request->filled('status'), function($query) use ($request) {
                        $status = Batch::STATUS_CONFIRMED;
                        if ($request->has('status')) {
                            if ($request->status == 'draft')
                                $status = Batch::STATUS_DRAFT;
                            elseif ($request->status == 'finish')
                                $status = Batch::STATUS_ACCOMPLISHED;
                        }

                        return $query->filterStatus($status);
                    })->paginate($count);
        return BatchResource::collection($batches);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, $batchId)
    {
        return new BatchResource(Batch::findOrFail($batchId));
    }

    /**
     * Update
     * @param  Request $request [description]
     * @param  [type]  $batchId [description]
     * @return [type]           [description]
     */
    public function update(UpdateBatchStatus $request, $batchId)
    {
        $batch = Batch::findOrFail($batchId);

        $status = Batch::STATUS_CONFIRMED;
        if ($request->status == 'finish')
            $status = Batch::STATUS_ACCOMPLISHED;

        $batch->status = $status;
        $batch->save();

        return new BatchResource($batch);
    }

    /**
     * destroy
     * @param  [type] $batchId [description]
     * @return [type]          [description]
     */
    public function destroy($batchId)
    {
        $model = Batch::findOrFail($batchId);
        if ($model->status != Batch::STATUS_DRAFT) {
            return legacy_errorify('Draft batch can only be deleted.');
        }

        $model->delete();
        return response()->json(['data' => null]);
    }
}
