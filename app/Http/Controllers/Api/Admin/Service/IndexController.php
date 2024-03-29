<?php

namespace App\Http\Controllers\Api\Admin\Service;

use Hash;
use App\Models\Service;
use App\Models\ClientService;
use App\Models\ClientSourceService;
use App\Imports\ServicesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\StoreRequest;
use App\Http\Requests\Admin\Service\UpdateRequest;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::withCount('tests');
        if ($request->has('clientId')) {
            $userId = get_user_id($request->clientId);
            // Get all clientServices service id
            $servicesId = [];
            $clientServices = ClientSourceService::select('service_id')
                ->where('user_id', $userId)
                ->where('source_id', $request->source)
                ->withOut('service')
                ->get()
                ->toArray();

                foreach ($clientServices as $service) {
                if (!in_array($service['service_id'], $servicesId)) {
                    array_push($servicesId, $service['service_id']);
                }
            }

            $services = $services->whereNotIn('id', $servicesId);
        }
        $services = $services->paginate(10);

        return success_data(compact('services'));
    }

    /**
     * Search services using code or name
     *
     * @author goper
     * @param  string $key
     * @return response
     */
    public function search($key = '', Request $request)
    {
        $services = Service::search($key);
        if ($request->has('clientId')) {
            $userId = get_user_id($request->clientId);

            // Get all clientServices service id
            $servicesId = [];
            $clientServices = ClientService::select('service_id')
                ->where('user_id', $userId)
                ->withOut('service')
                ->get()
                ->toArray();

            foreach ($clientServices as $service) {
                if (!in_array($service['service_id'], $servicesId)) {
                    array_push($servicesId, $service['service_id']);
                }
            }

            $services = $services->whereNotIn('id', $servicesId);
        }

        $services = $services->paginate(10);

        return success_data(compact('services'));
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
        $service = new Service();
        $service->code = $request->code;
        $service->name = $request->name;
        $service->default_cost = $request->default_cost;
        $service->save();

        return successful(trans('message.admin.service.success.store'), [
            'service' => $service,
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
        $service = Service::findOrFail($request->id);
        $name = $service->name;
        $service->code = $request->code;
        $service->name = $request->name;
        $service->default_cost = $request->default_cost;
        $service->save();

        return successful(trans('message.admin.service.success.update', ['name' => $name]), [
            'service' => $service,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return successful(trans('message.admin.service.success.destroy'));
    }

    /**
     * Display all clients accompanied by this service
     *
     * @param  [string] $code
     * @return \Illuminate\Http\Response
     */
    public function details($code)
    {
        // CHeck if code exist
        $service = Service::where('code', $code)->with('clients')->withCount('tests')->first();

        if (!$service) {
            return errorify(trans('message.admin.service.not_found'));
        }

        return success_data(compact('service'));
    }

    /**
     * Import services
     *
     * @return [type] [description]
     */
    public function import()
    {
        Excel::import(new ServicesImport, request()->file('file'));

        $services = Service::withCount('tests')->paginate(30);
        return successful(trans('message.admin.service.success.import'), [
            'services' => $services,
        ]);
    }
}
