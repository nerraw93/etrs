<?php

namespace App\Http\Requests\ApiLegacy\Client;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class BatchOrderStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientId' => 'required|exists:patients,id',
            'tests' => 'required|array',
            'batchId' => 'required|exists:batches,id',
        ];
    }
}
