<?php

namespace App\Http\Requests\ApiLegacy\Admin;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class WhiteListIpStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->admin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ipAddress' => 'required|ip',
            'userId' => 'sometimes|exists:users,id',
        ];
    }
}
