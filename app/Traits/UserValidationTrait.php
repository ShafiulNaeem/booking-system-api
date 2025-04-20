<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

trait UserValidationTrait
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('api')->check() ?? false;
    }


    /**
     * @param Validator $validator
     * @return mixed
     */

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            sendError(
                'Validation Error',
                $validator->errors()->toArray(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }


    /**
     * @return mixed
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            sendError(
                'Unauthorized',
                [],
                Response::HTTP_UNAUTHORIZED
            )
        );
    }
}
