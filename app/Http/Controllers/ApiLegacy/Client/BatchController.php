<?php

namespace App\Http\Controllers\ApiLegacy\Client;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\BatchResource;

class BatchController extends Controller
{
    /**
     * Search batches based on name
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $clientId)
    {
        $status = 0;
        if ($request->has('status')) {
            if ($request->status == 'sent' || $request->status == 'processing')
                $status = Batch::STATUS_CONFIRMED;
            elseif ($request->status == 'finish')
                $status = Batch::STATUS_ACCOMPLISHED;
        }

        $batches = Batch::where('client_id', $clientId)
            ->filterStatus($status)
            ->findById($request->id)
            ->get();
        return BatchResource::collection($batches);
    }

}
