<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
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
}
