<?php

namespace App\Http\Controllers\Api\Admin\Client;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Source\StoreRequest;
use App\Http\Requests\Admin\Client\Source\UpdateRequest;

class SourcesController extends Controller
{

    /**
     * Get client sources
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userId = get_user_id($id);
        $sources = ClientSource::where('user_id', $userId)->has('source')->paginate(10);

        return success_data(compact('sources'));
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
        $source_id = $request->source_id;
        $user_id = get_user_id($request->user_id);

        $exist = ClientSource::where([
            ['user_id', $user_id],
            ['source_id', $source_id],
        ])->get();

        if ($exist->count() > 0) {
            return errorify('Source already exists!');
        }
        else {
            $client = new ClientSource();
            $client->source_id = $source_id;
            $client->user_id = $user_id;
            $client->save();
        }

        $name = $client->user->full_name;
        $client = ClientSource::with('source')->find($client->id);
        return successful(trans('message.admin.client.source.success.store', ['name' => $name]), [
            'source' => $client,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $sourceId)
    {
        $client = ClientSource::findOrFail($sourceId);
        $client->delete();
        return successful(trans('message.admin.client.source.success.destroy'));
    }
}
