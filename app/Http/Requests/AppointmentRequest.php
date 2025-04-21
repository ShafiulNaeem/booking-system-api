<?php

namespace App\Http\Requests;

use App\Traits\UserValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    use UserValidationTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
            'avaiability_id' => [
                'required',
                'exists:avaiabilities,id',
                Rule::unique('appoinments')
                    ->where(function ($query) {
                        $query->where('date', $this->date)
                            ->where('status', '!=', 'cancelled');
                    })
            ],
            'notes' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'The date field is required.',
            'date.date_format' => 'The date must be in the format Y-m-d.',
            'avaiability_id.required' => 'The avaiibility id field is required.',
            'avaiability_id.exists' => 'The selected avaiibility id is invalid.',
            'avaiability_id.unique' => 'This slot already have an appointment for this date.',
            'notes.string' => 'The notes must be a string.',
            'notes.max' => 'The notes may not be greater than 255 characters.'
        ];
    }
}
