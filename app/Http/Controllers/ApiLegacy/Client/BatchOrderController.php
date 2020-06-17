<?php

namespace App\Http\Controllers\ApiLegacy\Client;

use App\Models\Batch;
use App\Models\BatchOrder;
use App\Models\BatchOrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\BatchResource;
use App\Http\Resources\Legacy\BatchOrderResource;
use App\Http\Requests\ApiLegacy\Client\BatchOrderStoreRequest;

class BatchOrderController extends Controller
{
    /**
     * Store
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function store(BatchOrderStoreRequest $request)
    {
        $order = new BatchOrder();
        $order->client_id = get_client_id();
        $order->batch_id = $request->batchId;
        $order->patient_id = $request->patientId;
        $order->id_prefix = $request->idPrefix;
        $order->or_number = $request->orNumber;
        $order->clinical_information = $request->clinicalInformation;
        $order->special_instructions = $request->specialInstructions;
        $order->status = BatchOrder::PENDING_STATUS;
        $order->is_urgent = $request->has('isUrgent') ? $request->isUrgent : 0;

        if ($order->save()) {
            $orderId = $order->id;
            // Save orders services
            foreach ($request->tests as $serviceId) {
                $service = new BatchOrderService();
                $service->batch_order_id = $orderId;
                $service->service_id = $serviceId['serviceId'];
                $service->save();
            }
        }

        $batch = Batch::find($request->batchId);
        return new BatchResource($batch);
    }

    /**
     * Update batch order - CANCEL!
     * @param  [type] $orderId
     * @return [type]
     */
    public function cancel($orderId)
    {
        $order = BatchOrder::owned()->findOrFail($orderId);
        $order->status = BatchOrder::CANCELLED_STATUS;
        $order->save();

        return new BatchOrderResource(BatchOrder::owned()->findOrFail($orderId));
    }

    /**
     * Update batch order - POST!
     * @param  [type] $orderId
     * @return [type]
     */
    public function post($orderId)
    {
        $order = BatchOrder::owned()->findOrFail($orderId);
        $order->status = BatchOrder::POSTED_STATUS;
        $order->save();

        return new BatchOrderResource(BatchOrder::owned()->findOrFail($orderId));
    }

    /**
     * Destroy
     * @param  [type] $orderId
     * @return [type]
     */
    public function destroy($orderId)
    {
        $order = BatchOrder::owned()->findOrFail($orderId)->delete();
        return response()->json([]);
    }

}
