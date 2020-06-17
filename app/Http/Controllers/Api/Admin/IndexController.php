<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * User `processor` role controller
 * Controlled by Admin
 *
 * @author goper
 */
class IndexController extends Controller
{
    /**
     * Display a listing of batches in draft status
     *
     * @return \Illuminate\Http\Response
     */
    public function batchDraft()
    {
        $batches = Batch::draft()->with('orders')->withCount([
                'services',
                'orders',
            ])->latest()->paginate(10);

        return success_data(compact('batches'));
    }

    /**
     * Display list of batches in confirmed status
     *
     * @return response
     */
    public function batchConfirmed()
    {
        $batches = Batch::confirmed()->with('orders')->withCount([
                'services',
                'orders',
            ])->latest()->paginate(10);
        return success_data(compact('batches'));
    }
}
