<?php

namespace App\Http\Requests;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaintenanceRequest extends FormRequest
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
            'type' => [Rule::enum(MaintenanceType::class)],
            'description' => ['string', 'required', 'max:255'],
            'date_planifiee' => 'required|date|after_or_equal:'.now(),
            'statut' => ['required', Rule::enum(MaintenanceStatus::class)],
            'engin_id' => ['numeric', 'exists:engins,id'],
            'technicien_id' => ['required', 'numeric', 'exists:users,id'],
            'incident_id' => ['numeric', 'nullable', 'exists:incidents,id'],
            'maintenance_automatique_id' => ['numeric', 'nullable', 'exists:maintenance_automatiques,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_planifiee.after_or_equal' => 'La date de la maintenance doit être postérieure ou égale à la date aujourd\'hui.',
        ];
    }
}
