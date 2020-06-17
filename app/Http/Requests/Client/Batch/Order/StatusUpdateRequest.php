<?php

namespace App\Http\Requests\Client\Batch\Order;

use App\Models\Batch;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class StatusUpdateRequest extends BaseRequest
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
            'status' => 'required|integer|between:0,3',
        ];
    }
}
