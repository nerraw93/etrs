<?php

namespace App\Helpers;

use DB;
use Str;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * Legacy helpers for API v1
 *
 * @author goper
 */
trait LegacyHelperTrait {

    /**
    * Return json response
    *
    * @param  Boolean $success                                 if response is a success or not
    * @param  array  $data                                     extra data to include
    * @param  integer  $status                                 response status code
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function legacyJsonify($data = [], $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    /**
    * Return an unsuccessful json response
    *
    * @param  String $message                                  message of the response
    * @param  array  $data                                     extra data to include
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function legacyErrorify($message, $extra = [])
    {
        return $this->legacyJsonify(array_merge(['errors' => [(object) ['code' => 401, 'message' => $message]]], $extra), 401);
    }

    /**
    * Successfull json response
    *
    * @param  string  $message                                 the message
    * @param  array   $extra                                   the extra data to attach
    * @param  integer $status                                  the status of the response
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function legacySuccessful($data = [])
    {
        return $this->legacyJsonify((object) ['data' => (object) $data], 200);
    }
}
