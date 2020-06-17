<?php

namespace App\Http\Requests\ApiLegacy\Auth;

use App\Http\Requests\ApiLegacy\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|exists:users',
            'password' => 'required',
            'xAuthMode' => 'required|in:clientAuth',
        ];
    }
}
