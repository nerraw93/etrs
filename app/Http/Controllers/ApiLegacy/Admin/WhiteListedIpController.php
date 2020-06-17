<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\WhiteListedIp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\WhiteListedIpResource;
use App\Http\Requests\ApiLegacy\Admin\WhiteListIpStoreRequest;

class WhiteListedIpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('filter')) {
            $white_listed_ips = WhiteListedIp::has('user')
                ->with(['user' => function($query) use ($request) {
                    $role = User::ROLE_CLIENT;
                    if ($request->filter == 'admin')
                        $role = User::ROLE_ADMIN;

                    $query->where('role', $role);
                }])->get();
        } else {
            $white_listed_ips = WhiteListedIp::all();
        }

        return WhiteListedIpResource::collection($white_listed_ips);
    }

    /**
     * Store
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(WhiteListIpStoreRequest $request)
    {
        $white_listed_ip = new WhiteListedIp();
        $white_listed_ip->address = $request->ipAddress;
        $white_listed_ip->user_id = $request->userId;
        $white_listed_ip->save();

        return new WhiteListedIpResource(WhiteListedIp::find($white_listed_ip->id));
    }

    /**
     * Destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $whiteListId)
    {
        $white_listed_ip = WhiteListedIp::findOrFail($whiteListId);
        $white_listed_ip->delete();
        return response()->json([]);
    }

}
