<?php

namespace App\Http\Requests\Admin\Client\Service;

use App\Models\User;
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
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user->role != User::ROLE_CLIENT) {
                        $fail(trans('message.admin.service.user_not_client'));
                    }
                },
            ],
            'service_id' => 'required|exists:services,id',
        ];
    }
}
