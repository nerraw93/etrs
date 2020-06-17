<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\WhiteListedIpResource;
use App\Http\Requests\ApiLegacy\Admin\ServiceStoreRequest;

class ServicesController extends Controller
{
    /**
     * Store
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $service = Service::firstOrCreate(['code' => $request->serviceCode], [
            'name' => $request->sourceCode,
            'default_cost' => $request->defaultCost
        ]);

        return response()->json([
            'data' => [
                'serviceCode' => $service->code,
                'sourceCode' => $service->name,
                'defaultCost' => $service->default_cost,
            ]
        ]);
    }



}
