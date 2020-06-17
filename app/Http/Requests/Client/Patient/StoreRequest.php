<?php

namespace App\Http\Requests\Client\Patient;

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
            'client_id' => [
                'required',
                'exists:users,id',
            ],
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => [
                'required',
                Rule::in(['male', 'female'])
            ],
            'birth_date' => 'required',
        ];
    }
}
