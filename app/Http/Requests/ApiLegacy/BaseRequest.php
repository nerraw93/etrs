<?php

namespace App\Http\Requests\ApiLegacy;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Base class for FormRequest - modify api json response
 *
 * @author goper
 */
class BaseRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errorBag = $validator->errors();
            $errors = [];
            
            foreach ($errorBag->keys() as $key) {
                foreach ($errorBag->get($key) as $message) {
                    array_push($errors, (object) ['code' => 401, 'message' => $message]);
                }
            }
            $response = new JsonResponse(compact('errors'), 401);

            throw new ValidationException($validator, $response);
        }

        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }

}
