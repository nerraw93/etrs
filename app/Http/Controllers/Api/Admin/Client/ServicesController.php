<?php

namespace App\Http\Controllers\Api\Admin\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClientService;
use App\Models\ClientSourceService;
use App\Imports\ClientServicesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Service\StoreRequest;
use App\Http\Requests\Admin\Client\Service\UpdateRequest;

class ServicesController extends Controller
{

    /**
     * Get client sources
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $sourceId)
    {
        $userId = get_user_id($id);
        $services = ClientSourceService::where([
            'user_id' => $userId,
            'source_id' => $sourceId
        ])->has('service')->paginate(10);
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
        foreach ($request->services as $service) {
            $client = new ClientSourceService();
            $client->source_id = $request->source_id;
            $client->service_id = $service['id'];
            $client->user_id = get_user_id($request->user_id);
            $client->price = $service['price'] ?? 0;
            $client->save();
        }

        $name = $client->user->full_name;
        return successful(trans('message.admin.client.service.success.store', ['name' => $name]), [
            'service' => [],
        ]);
    }

    /**
     * Update client service price
     *
     * @param  UpdateRequest $request
     * @return response
     */
    public function update(UpdateRequest $request)
    {
        $client = ClientSourceService::findOrFail($request->id);
        $client->price = $request->price;
        $client->save();

        $name = $client->user->full_name;
        $client = ClientSourceService::with('service')->find($client->id);
        return successful(trans('message.admin.client.service.success.update'), [
            'service' => $client,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $sourceId, $serviceId)
    {
        $client = ClientSourceService::findOrFail($serviceId);
        $client->delete();
        return successful(trans('message.admin.client.service.success.destroy'));
    }

    public function import($id, $sourceId)
    {
        Excel::import(new ClientServicesImport($sourceId), request()->file('file'));

        $services = ClientSourceService::where('user_id', substr(get_user_id($id), 8))->has('service')->paginate(30);
        return successful(trans('message.admin.service.success.import'), [
            'services' => $services,
        ]);
    }
}
