<?php

namespace App\Http\Requests\Client\Settings\Clinician;

use App\Models\Clinician;
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
            'id' => [
                'required',
                'exists:clinicians',
                function ($attribute, $value, $fail) {
                    $model = Clinician::find($value);
                    if (get_client_id() != $model->user_id) {
                        $fail(trans('validation.touching_not_owned_data'));
                    }
                },
            ],
            'name' => 'required|min:3|unique:clinicians,name,' . $this->id,
        ];
    }
}
