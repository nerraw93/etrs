<?php

namespace App\Http\Controllers\Api\Staff\Batch;

use App\Models\Batch;
use App\Models\BatchOrder;
use Illuminate\Http\Request;
use App\Models\BatchOrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Batch\Order\StoreRequest;
use App\Http\Requests\Client\Batch\Order\UpdateRequest;
use App\Http\Requests\Client\Batch\Order\StatusUpdateRequest;

class BatchOrderController extends Controller
{
    /**
     * Get all orders on this batch
     *
     * @author goper
     * @return response
     */
    public function index($id)
    {
        $orders = BatchOrder::owned()->where('batch_id', $id)->get();
        return success_data(compact('orders'));
    }

    /**
     * Store
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $order = new BatchOrder();
        $order->client_id = get_staff_client_id();
        $order->batch_id = $request->batch_id;
        $order->patient_id = $request->patient_id;
        $order->id_prefix = $request->id_prefix;
        $order->or_number = $request->or_number;
        $order->clinical_information = $request->clinical_information;
        $order->special_instructions = $request->special_instructions;
        $order->status = BatchOrder::PENDING_STATUS;
        $order->is_urgent = $request->is_urgent;

        if ($order->save()) {
            $orderId = $order->id;
            // Save orders services
            foreach ($request->services as $serviceId) {
                $service = new BatchOrderService();
                $service->batch_order_id = $orderId;
                $service->service_id = $serviceId['id'];
                $service->save();
            }
        }

        $order = BatchOrder::find($orderId);
        return successful(trans('message.client.batch.order.success.store'), [
            'order' => $order,
        ]);
    }

    /**
     * Update batch order
     *
     * @param  integer $id
     * @return response
     */
    public function update(UpdateRequest $request, $id)
    {
        $order = BatchOrder::owned()->findOrFail($id);
        $order->batch_id = $request->batch_id;
        $order->patient_id = $request->patient_id;
        $order->id_prefix = $request->id_prefix;
        $order->or_number = $request->or_number;
        $order->clinical_information = $request->clinical_information;
        $order->special_instructions = $request->special_instructions;
        $order->status = BatchOrder::PENDING_STATUS;
        $order->is_urgent = $request->is_urgent;

        if ($order->save()) {
            $orderId = $order->id;

            // Delete all BatchOrderService first
            $services = $order->services()->delete();
            // Save orders services
            foreach ($request->services as $serviceId) {
                $service = new BatchOrderService();
                $service->batch_order_id = $orderId;
                $service->service_id = $serviceId['id'];
                $service->save();
            }
        }

        $order = BatchOrder::find($orderId);
        return successful(trans('message.client.batch.order.success.update'), [
            'order' => $order,
        ]);
    }

    /**
     * Update batch_order status
     *
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function updateStatus(StatusUpdateRequest $request, $id)
    {
        $order = BatchOrder::owned()->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        if ($request->status == BatchOrder::CANCELLED_STATUS)
            $message = trans('message.client.batch.order.success.update_status.cancelled');
        elseif ($request->status == BatchOrder::POSTED_STATUS)
            $message = trans('message.client.batch.order.success.update_status.posted');
        else
            $message = trans('message.client.batch.order.success.update');

        $order = BatchOrder::find($id);
        return successful($message, [
            'order' => $order,
        ]);
    }

    /**
     * Destroy
     *
     * @author goper
     * @param  integer $id
     * @return response
     */
    public function destroy($id)
    {
        $order = BatchOrder::owned()->findOrFail($id);

        // Check batch if not `draft` status
        if ($order->batch->status != Batch::STATUS_DRAFT) {
            return errorify(trans('message.client.batch.order.error.batch_is_not_draft'));
        }

        $order->delete();
        return successful(trans('message.client.batch.order.success.destroy'));
    }
}
