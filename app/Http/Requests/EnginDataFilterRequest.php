<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnginDataFilterRequest extends FormRequest
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
            'maint_start_date' => ['nullable', 'date'],
            'maint_end_date' => ['nullable', 'date', 'after_or_equal:maint_start_date'],
            'usage_start_date' => ['nullable', 'date'],
            'usage_end_date' => ['nullable', 'date', 'after_or_equal:usage_start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'maint_end_date.after_or_equal' => 'La date de fin de maintenance doit être postérieure ou égale à la date de début.',
            'usage_end_date.after_or_equal' => "La date de fin d'utilisation doit être postérieure ou égale à la date de début.",
        ];
    }
}
