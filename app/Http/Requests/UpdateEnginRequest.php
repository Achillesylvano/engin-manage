<?php

namespace App\Http\Requests;

use App\Enums\EnginStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateEnginRequest extends FormRequest
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
            'type_engin_id' => 'required|numeric|exists:type_engins,id',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'numero_serie' => ['required', 'string', 'max:255', Rule::unique('engins', 'numero_serie')->ignore($this->engin->id)],
            'compteur_h' => 'required|numeric|min:0',
            'compteur_km' => 'required|numeric|min:0',
            'seuil_maintenance_h' => 'required|numeric|min:0',
            'seuil_maintenance_km' => 'required|numeric|min:0',
            'etat' => ['required', new Enum(EnginStatus::class)],
            'date_acquisition' => 'required|date',
            'capacite_reservoir' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'designation.string' => 'La désignation doit être une chaîne de caractères.',
            'designation.max' => 'La désignation ne peut pas dépasser 255 caractères.',
            'marque.string' => 'La marque doit être une chaîne de caractères.',
            'marque.max' => 'La marque ne peut pas dépasser 255 caractères.',
            'modele.string' => 'Le modèle doit être une chaîne de caractères.',
            'modele.max' => 'Le modèle ne peut pas dépasser 255 caractères.',
            'numero_serie.string' => 'Le numéro de série doit être une chaîne de caractères.',
            'numero_serie.max' => 'Le numéro de série ne peut pas dépasser 255 caractères.',
            'compteur_h.numeric' => 'Le compteur en heures doit être un nombre.',
            'compteur_h.min' => 'Le compteur en heures ne peut pas être négatif.',
            'compteur_km.numeric' => 'Le compteur en kilomètres doit être un nombre.',
            'compteur_km.min' => 'Le compteur en kilomètres ne peut pas être négatif.',
            'seuil_maintenance_h.numeric' => 'Le seuil de maintenance en heures doit être un nombre.',
            'seuil_maintenance_h.min' => 'Le seuil de maintenance en heures ne peut pas être négatif.',
            'seuil_maintenance_km.numeric' => 'Le seuil de maintenance en kilomètres doit être un nombre.',
            'seuil_maintenance_km.min' => 'Le seuil de maintenance en kilomètres ne peut pas être négatif.',
            'capacite_reservoir.numeric' => 'La capacité du réservoir doit être un nombre.',
            'capacite_reservoir.min' => 'La capacité du réservoir ne peut pas être négative.',
            'type_carburant.enum' => 'Le type de carburant sélectionné n\'est pas valide.',
            'etat.enum' => 'L\'état sélectionné n\'est pas valide.',
            'image_engin.image' => 'Le fichier doit être une image.',
            'image_engin.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'date_acquisition.date' => 'La date d\'acquisition doit être une date valide.',
            'type_engin_id.numeric' => 'L\'ID du type d\'engin doit être un nombre.',
            'type_engin_id.exists' => 'Le type d\'engin sélectionné n\'existe pas.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'designation' => 'désignation',
            'marque' => 'marque',
            'modele' => 'modèle',
            'numero_serie' => 'numéro de série',
            'compteur_h' => 'compteur en heures',
            'compteur_km' => 'compteur en kilomètres',
            'seuil_maintenance_h' => 'seuil de maintenance en heures',
            'seuil_maintenance_km' => 'seuil de maintenance en kilomètres',
            'capacite_reservoir' => 'capacité du réservoir',
            'type_carburant' => 'type de carburant',
            'etat' => 'état',
            'image_engin' => 'image de l\'engin',
            'date_acquisition' => 'date d\'acquisition',
            'type_engin_id' => 'type d\'engin',
        ];
    }
}
