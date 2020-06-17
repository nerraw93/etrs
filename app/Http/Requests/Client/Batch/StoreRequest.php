<?php

namespace App\Http\Requests\Client\Batch;

use App\Models\Clinician;
use App\Models\ClientStaff;
use App\Models\ClientSource;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
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
            'source_id' => [
                'required',
                'integer',
                'exists:sources,id',
                function ($attribute, $value, $fail) {
                    $client_id = get_client_id();

                    $model = ClientSource::where([
                        'source_id' => $value,
                        'user_id' => $client_id,
                    ])->first();

                    if ($client_id != $model->user_id) {
                        $fail(trans('validation.touching_not_owned_source'));
                    }
                },
            ],
            'patient_type_id' => 'required|integer|exists:patient_types,id',
            'payment_mode' => 'integer|between:0,1',
            'is_confirmed' => 'integer|between:0,1',
        ];
    }
}
