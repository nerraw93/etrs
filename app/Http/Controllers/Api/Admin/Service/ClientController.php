<?php

namespace App\Http\Controllers\Api\Admin\Service;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\Client\StoreRequest;
use App\Http\Requests\Admin\Service\Client\UpdateRequest;

class ClientController extends Controller
{
    /**
     * Display listing resources
     *
     * @author goper
     * @return response
     */
    public function index($id)
    {
        $clients = ClientService::where('service_id', $id)->has('service')->with('user')->paginate(10);
        return success_data(compact('clients'));
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
        if ($this->checkIfExist($request->service_id, $request->user_id)) {
            return errorify(trans('message.admin.service.client.error.exist'));
        }
        else {
            $client = new ClientService();
            $client->service_id = $request->service_id;
            $client->user_id = $request->user_id;
            $client->price = $request->price;
            $client->save();

            $name = User::find($request->user_id)->full_name;
            $client = ClientService::with('service')->find($client->id);

            return successful(trans('message.admin.service.client.success.store', ['name' => $name]), [
                'client' => $client,
            ]);
        }
    }

    /**
     * Update price only
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $client = ClientService::with('user')->findOrFail($request->id);
        $name = $client->user->full_name;
        $client->price = $request->price;
        $client->save();

        return successful(trans('message.admin.service.client.success.update', ['name' => $name]), [
            'client' => $client,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $client = ClientService::findOrFail($id);
        $name = $client->user->full_name;
        $client->delete();
        return successful(trans('message.admin.service.client.success.destroy', ['name' => $name]));
    }

    public function archive($serviceId, $userId)
    {
        $client = ClientService::where([
            'service_id' => $serviceId,
            'user_id' => $userId
        ])->first();
        $name = $client->user->full_name;
        $client->delete();
        return successful(trans('message.admin.service.client.success.destroy', ['name' => $name]));
    }

    private function checkIfExist($serviceId, $userId)
    {
        $client = ClientService::where([
            'service_id' => $serviceId,
            'user_id' => $userId
        ])->first();

        if ($client) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updatePrice(Request $request)
    {
        $client = ClientService::where([
            'service_id' => $request->service_id,
            'user_id' => $request->user_id
        ])->first();

        $name = $client->user->full_name;
        $client->price = $request->price;
        $client->save();

        return successful(trans('message.admin.service.client.success.update', ['name' => $name]), [
            'client' => $client,
        ]);
    }
}
