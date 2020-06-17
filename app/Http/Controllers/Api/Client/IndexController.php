<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\User;
use App\Models\Batch;
use App\Models\Service;
use App\Models\PatientType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class IndexController extends Controller
{
    /**
     * Get client `sources` data
     *
     * @return \Illuminate\Http\Response
     */
    public function sources()
    {
        $sources = User::with('sources')->find(get_client_id())->sources;
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
    public function services(Request $request)
    {
        if ($request->has('key')) {
            // Search services
            $services = Service::search($request->key)->wherehas('clients', function($query) {
                $query->where('user_id', '=', get_client_id());
            })->get();
        } else {
            $clientId = get_client_id();
            $clientServicesKey = "client.services.$clientId";
            $services = Cache::get($clientServicesKey);
            if (!Cache::has($clientServicesKey)) {
                $services = User::with('services')->find($clientId)->services()->orderBy('name')->get();
                Cache::put($clientServicesKey, $services, 120);
            }
        }

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
