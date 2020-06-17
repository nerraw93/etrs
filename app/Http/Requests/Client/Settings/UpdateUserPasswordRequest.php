<?php

namespace App\Http\Requests\Client\Settings;

use Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateUserPasswordRequest extends BaseRequest
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
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail(trans('auth.failed'));
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
        ];
    }
}
