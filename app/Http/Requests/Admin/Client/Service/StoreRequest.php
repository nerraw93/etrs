<?php

namespace App\Http\Requests\Admin\Client\Service;

use App\Models\User;
use App\Models\Service;
use App\Models\ClientService;
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
                'exists:users,code',
                function ($attribute, $value, $fail) {
                    $id = get_user_id($value);
                    $user = User::find($id);
                    if ($user->role != User::ROLE_CLIENT) {
                        $fail(trans('message.admin.service.user_not_client'));
                    }
                },
            ],
            'services' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $service) {
                        $serviceId = $service['id'];
                        if (!Service::find($serviceId)) {
                            $fail(trans('validation.exists', ['attribute' => 'service id']));
                        }
                    }
                },
            ],
        ];
    }
}
