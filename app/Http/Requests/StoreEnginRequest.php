<?php

namespace App\Http\Requests;

use App\Enums\EnginCarburant;
use App\Enums\EnginStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEnginRequest extends FormRequest
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
            'designation' => 'required|string|max:255',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255',
            'compteur_h' => 'required|numeric|min:0',
            'compteur_km' => 'required|numeric|min:0',
            'capacite_reservoir' => 'required|numeric|min:0',
            'type_carburant' => ['required', new Enum(EnginCarburant::class)],
            'etat' => ['required', new Enum(EnginStatus::class)],
            'image_engin' => 'nullable|image|max:2048',
            'date_acquisition' => 'required|date',
            'type_engin_id' => 'required|numeric|exists:type_engins,id',
        ];
    }
}
