<?php

namespace App\Helpers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Batch;
use App\Models\ClientStaff;
use Illuminate\Http\JsonResponse;
use App\Helpers\ShortCodeGenerator;
use App\Helpers\LegacyHelperTrait;
use Illuminate\Support\Str;
use PDF;
use DNS1D;

class Aider
{

    use ShortCodeGenerator, LegacyHelperTrait;

    /**
    * Return json response
    *
    * @param  Boolean $success                                 if response is a success or not
    * @param  array  $data                                     extra data to include
    * @param  integer  $status                                 response status code
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function jsonify($success, $data = [], $status = 200)
    {
        return new JsonResponse(array_merge([
            'success' => $success
        ], $data), $status);
    }

    /**
    * Return a successful json response
    *
    * @param  String $message                                  message of the response
    * @param  array  $data                                     extra data to include
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function successify($message, $extra = [])
    {
        return $this->jsonify(true, array_merge([
            'message' => $message
        ], $extra));
    }

    /**
    * Return a successful with data response
    *
    * @author goper
    * @param  string $message
    * @param  array  $extra
    * @return Illuminate\Http\JsonResponse
    */
    public function successData($data = [])
    {
        return $this->jsonify(true, array_merge([
            'message' => '',
        ], $data));
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
    public function successful($message, $extra = [], $status = 200)
    {
        return $this->jsonify(true, array_merge([
            'message' => $message
        ], $extra), $status);
    }

    /**
    * Return an unsuccessful json response
    *
    * @param  String $message                                  message of the response
    * @param  array  $data                                     extra data to include
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function errorify($message, $extra = [])
    {
        return $this->jsonify(false, array_merge([
            'message' => $message
        ], $extra), 422);
    }

    /**
    * Erroneous json response
    *
    * @param  string  $message                                 the message
    * @param  array   $extra                                   the extra data to attach
    * @param  integer $status                                  the response status
    * @return Illuminate\Http\JsonResponse
    * @author goper
    */
    public function erroneous($message, $extra = [], $status = 422)
    {
        return $this->jsonify(false, array_merge([
            'message' => $message
        ], $extra), $status);
    }

    /**
     * Get passport client credentials
     *
     * @return array
     */
    public function passportClientCredentials()
    {
        return DB::table('oauth_clients')->where('password_client', 1)->first();
    }

    /**
     * Get admin global prefix - default is first admin found
     *
     * @param  string $id
     * @return string
     */
    public function globalPrefix($id = '')
    {
        if ($id != '') {
            $admin = User::find($id);
        } else {
            $admin = User::where('role', User::ROLE_ADMIN)->first();
        }

        return $admin->global_prefix;
    }

    /**
     * Get userId based on user code given
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getUserId($code)
    {
        return User::where('code', $code)->first()->id;
    }

    /**
     * Get client_id based on staff
     *
     * @return integer
     */
    public function getStaffClientId()
    {
        if (auth()->user()->isStaff) {
            $staff = ClientStaff::where('staff_id', auth()->user()->id)->first();
            return $staff->client_id;
        }
    }

    /**
     * Get client id if auth user is a staff if not return client id
     * @return integer
     */
    public function getClientId()
    {
        $id = auth()->user()->id;
        if (auth()->user()->isStaff) {
            $id = $this->getStaffClientId();
        }
        return $id;
    }

    /**
     * Check if this user is `client` or `staff`
     * @return boolean
     */
    public function isClientOrStaff()
    {
        return auth()->user()->isStaff || auth()->user()->isClient;
    }

    /**
     * Get batch PDF path
     * @param  object $batch
     * @return string
     */
    public function getBatchPdf($batchId)
    {
        $batch = Batch::with(['orders' => function ($query) {
            $query->whereNotIn('status', [1]);
        }])->find($batchId);
        $path = $batch->pdf_path;

        if (!$path || !file_exists($path)) {
            $pdf_name = $batch->code . '_' . Str::random(10);
            $path = 'reports/' . $pdf_name . '.pdf';
            $barcode = DNS1D::getBarcodePNGPath($batch->id, "C128");

            $batch->pdf_path = $path;
            $batch->barcode_path = $barcode;
            $batch->save();
            $pdf = PDF::loadView('pdf.batch_report', compact('batch', 'barcode'))
                ->save(public_path($path));
        }

        return $path;
    }

    /**
     * Get current notifications that are not ended yet
     * @param  array $notifications
     * @return collections
     */
    public function getCurrentNotifications($notifications)
    {
        $ids = [];
        foreach ($notifications as $notification) {
            $id = $notification->id;
            $data = $notification->data;
            $endDate = Carbon::parse($data['end_date']);
            if ($endDate < Carbon::now())
                array_push($ids, $id);
        }
        // Filter notifications, remove that are ended
        return $notifications->except($ids);
    }

    /**
     * Generate global_custom_id on patient
     * @param  [type] $id
     * @param  string $prefix
     * @return string
     */
    public function patientGlobalCustomIdGenerator($id, $globalPrefix = '')
    {
        if ($globalPrefix == '')
            $globalPrefix = global_prefix();

        $prefix = '';
        for ($i=0; $i < (8 - strlen($id)); $i++) {
            $prefix .= '0';
        }
        return $globalPrefix . $prefix . (string)$id;
    }
}
