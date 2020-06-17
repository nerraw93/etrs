<?php

namespace App\Http\Controllers\Api\Admin\Batch;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $batches = Batch::when($request->filled('status'), function($query) use ($request) {
                        return $query->filterStatus($request->status);
                    })->when($request->filled('search'), function($query) use ($request) {
                        return $query->findById($request->search);
                    })->withCount([
                        'services',
                        'orders',
                    ])->orderBy('created_at', 'ASC')->paginate($request->count);
        return success_data(compact('batches'));
    }

    public function setToDone(Request $request)
    {
        $batch = Batch::findOrFail($request->id);
        $batch->status = 2;
        $batch->save();

        return successful('Batch order has been accomplished!', ['value' => $batch]);
    }

    /**
     * Generate PDF
     * @param  integer $id
     * @return string
     */
    public function viewPdf($id)
    {
        $path = get_batch_pdf($id);
        return success_data(compact('path'));
    }
}
