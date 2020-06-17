<?php

namespace App\Http\Controllers\Api\Staff\Batch;

use App\Models\User;
use App\Models\Batch;
use App\Models\ClientStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Batch\StoreRequest;
use App\Http\Requests\Client\Batch\UpdateRequest;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches = Batch::owned()
                    ->when($request->filled('status'), function($query) use ($request) {
                        return $query->filterStatus($request->status);
                    })->when($request->filled('search'), function($query) use ($request) {
                        return $query->findById($request->search);
                    })->paginate($request->count);
        return success_data(compact('batches'));
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
        $client_id = get_staff_client_id();

        $batch = new Batch();
        $batch->code = str_random(5) . \Carbon\Carbon::now()->timestamp;
        $batch->source_id = $request->source_id;
        $batch->clinician_id = $request->clinician_id;
        $batch->patient_type_id = $request->patient_type_id;
        $batch->client_id = $client_id;
        $batch->dispatcher_id = $request->dispatcher_id;
        $batch->payment_mode = $request->payment_mode;
        $batch->slides = $request->slides;
        $batch->blood = $request->blood;
        $batch->forms = $request->forms;
        $batch->specimen = $request->specimen;
        $batch->status = $request->is_confirmed;
        $batch->save();

        return successful(trans('message.client.batch.success.store'), [
            'batch' => $batch,
        ]);
    }

    /**
     * Update
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->source_id = $request->source_id;
        $batch->clinician_id = $request->clinician_id;
        $batch->patient_type_id = $request->patient_type_id;
        $batch->dispatcher_id = $request->dispatcher_id;
        $batch->payment_mode = $request->payment_mode;
        $batch->slides = $request->slides;
        $batch->blood = $request->blood;
        $batch->forms = $request->forms;
        $batch->specimen = $request->specimen;
        $batch->status = $request->is_confirmed;
        $batch->save();

        return successful(trans('message.client.batch.success.update'), [
            'batch' => $batch,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $batch = Batch::owned()->findOrFail($id);
        $batch->delete();
        return successful(trans('message.client.batch.success.destroy'));
    }

    /**
     * Search batch based on key
     *
     * @param  string $key
     * @return response
     */
    public function search(Request $request, $key = '')
    {
        $batches = Batch::owned()
                    ->when($request->filled('status'), function($query) use ($request) {
                        return $query->filterStatus($request->status);
                    })
                    ->findById($key)
                    ->paginate(10);
        return success_data(compact('batches'));
    }

    /**
     * Display batch details
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function details($id)
    {
        $batch = Batch::owned()->findOrFail($id);
        return success_data(compact('batch'));
    }
}
