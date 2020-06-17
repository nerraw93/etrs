<?php

namespace App\Http\Controllers\ApiLegacy\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legacy\PatientResource;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $count = 10;
        if ($request->has('count'))
            $count = $request->count;

        return PatientResource::collection(Patient::paginate($count));
    }
}
