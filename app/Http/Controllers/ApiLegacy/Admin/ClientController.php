<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\UserResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $count = 10;
        if ($request->has('count')) {
            $count = $request->count;
        }

        $clients = User::client()->paginate($count);
        return UserResource::collection($clients);
    }

    /**
     * Search client based on key
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $count = 10;
        if ($request->has('count')) {
            $count = $request->count;
        }

        $clients = User::client()->findByName(rtrim($request->name))->paginate($count);
        return UserResource::collection($clients);
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json([]);
    }
}
