<?php

namespace App\Http\Requests\ApiLegacy\Client;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class PatientStoreRequest extends BaseRequest
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
            'emailAddress' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => [
                'required',
                Rule::in(['male', 'female'])
            ],
            'birthDate' => 'required',
        ];
    }
}
