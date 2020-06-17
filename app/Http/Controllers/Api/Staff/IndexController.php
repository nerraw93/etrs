<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\User;
use App\Models\Batch;
use App\Models\PatientType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Get client `sources` data
     *
     * @return \Illuminate\Http\Response
     */
    public function sources()
    {
        $sources = User::with('sources')->find(auth()->user()->id)->sources;
        return success_data(compact('sources'));
    }

    /**
     * Get all `patientTypes`
     *
     * @return response
     */
    public function patientTypes()
    {
        $patient_types = PatientType::all();
        return success_data(compact('patient_types'));
    }

    /**
     * Get all `dispatchers`
     *
     * @return response
     */
    public function dispatchers()
    {
        $dispatchers = PatientType::all();
        return success_data(compact('dispatchers'));
    }

    /**
     * Get client sevices
     * @return [type] [description]
     */
    public function services()
    {
        $services = User::with('services')->find(auth()->user()->id)->services;
        return success_data(compact('services'));
    }

    /**
     * Get all batch drafts
     *
     * @return response
     */
    public function batchDraft()
    {
        $batches = Batch::owned()->draft()->with('orders')->withCount([
                'services',
                'orders',
            ])->latest()->paginate(10);

        return success_data(compact('batches'));
    }

    /**
     * Get all batches that are confirmed
     *
     * @return response
     */
    public function batchConfirmed()
    {
        $batches = Batch::owned()->confirmed()->with('orders')->withCount([
                'services',
                'orders',
            ])->latest()->paginate(10);
        return success_data(compact('batches'));
    }
}
