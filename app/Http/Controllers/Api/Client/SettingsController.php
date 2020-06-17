<?php

namespace App\Http\Controllers\Api\Client;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Settings\UpdateUserDetailsRequest;
use App\Http\Requests\Client\Settings\UpdateUserPasswordRequest;

class SettingsController extends Controller
{
    /**
     * Get user profile details
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return success_data(compact('user'));
    }

    /**
     * Update client details
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(UpdateUserDetailsRequest $request)
    {
        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->business_name = $request->business_name;
        $user->business_address = $request->business_address;
        $user->contact_number = $request->contact_number;
        $user->save();

        return successful(trans('message.client.settings.success.profile_update'), [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update user password
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return successful(trans('message.client.settings.success.password_update'), [
            'user' => auth()->user(),
        ]);
    }
}
