<?php

namespace App\Http\Controllers\Api\Admin\System;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System\GlobalPrefix\UpdateRequest;

class GlobalPrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global_prefix = auth()->user()->global_prefix;
        return success_data(compact('global_prefix'));
    }

    /**
     * Update
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $user = auth()->user();
        $globalPrefix = strtoupper($request->global_prefix);
        $user->global_prefix = $globalPrefix;
        $user->save();

        return successful(trans('message.admin.system.global_prefix.success.update', ['value' => $globalPrefix]), [
            'global_prefix' => $globalPrefix,
        ]);
    }
}
