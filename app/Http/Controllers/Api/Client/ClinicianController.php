<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Clinician;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Settings\Clinician\StoreRequest;
use App\Http\Requests\Client\Settings\Clinician\UpdateRequest;

class ClinicianController extends Controller
{
    /**
     * Get list of client clinicians
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('page') && $request->page == 'all')
            $clinicians = Clinician::owned()->get();
        else
            $clinicians = Clinician::owned()->paginate(30);
        return success_data(compact('clinicians'));
    }

    /**
     * Store client clinician
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $clinician = new Clinician();
        $clinician->user_id = get_client_id();
        $clinician->name = $request->name;
        $clinician->save();

        return successful(trans('message.client.settings.clinician.success.store'), [
            'clinician' => $clinician,
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
        $clinician = Clinician::owned()->findOrFail($request->id);
        $clinician->name = $request->name;
        $clinician->save();

        return successful(trans('message.client.settings.clinician.success.update'), [
            'clinician' => $clinician,
        ]);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $clinician = Clinician::owned()->findOrFail($id);
        $clinician->delete();
        return successful(trans('message.client.settings.clinician.success.destroy'));
    }
}
