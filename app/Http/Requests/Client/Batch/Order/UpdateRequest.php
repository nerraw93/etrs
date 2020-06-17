<?php

namespace App\Http\Requests\Client\Batch\Order;

use App\Models\Batch;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return is_client_or_staff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'batch_id' => [
                'required',
                'integer',
                'exists:batches,id',
                function ($attribute, $value, $fail) {
                    // Check batch if this is the owner
                    $model = \App\Models\Batch::find($value);
                    if ($model) {
                        if (get_client_id() != $model->client_id) {
                            $fail(trans('validation.touching_not_owned_data'));
                        }
                    } else {
                        $fail(trans('validation.touching_not_owned_data'));
                    }
                },
            ],
            /*'services' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $userId = auth()->user()->id;
                    // Check each `services_id` is own by the client
                    foreach ($value as $serviceId) {
                        $serviceModelCount = \App\Models\ClientService::where([
                            'user_id' => $userId,
                            'service_id' => $serviceId,
                        ])->count();

                        if ($serviceModelCount == 0) {
                            $fail(trans('message.client.batch.order.error.service_is_not_owned'));
                        }
                    }
                },
            ],*/
            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
                function ($attribute, $value, $fail) {
                    // Check batch if this is the owner
                    $model = \App\Models\Patient::find($value);
                    if (get_client_id() != $model->client_id) {
                        $fail(trans('validation.touching_not_owned_data'));
                    }
                },
            ],
            'is_urgent' => 'required|integer|between:0,1',
        ];
    }
}
