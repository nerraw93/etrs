<?php

namespace App\Http\Requests\Client\Settings;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserDetailsRequest extends BaseRequest
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
                'exists:users',
                function ($attribute, $value, $fail) {
                    if (auth()->user()->id != $value) {
                        $fail(trans('validation.touching_not_owned_data'));
                    }
                },
            ],
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }
}
