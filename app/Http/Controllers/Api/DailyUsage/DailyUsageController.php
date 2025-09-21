<?php

namespace App\Http\Controllers\Api\DailyUsage;

use App\Http\Controllers\Controller;
use App\Models\DailyUsage;
use App\Responses\DailyUsageCollectionResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DailyUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DailyUsageCollectionResponse
    {
        $dailyusages = QueryBuilder::for(DailyUsage::class)
            ->allowedFilters([
                // Filtre sur colonne directe
                'is_returned',
                // Filtre sur relation opérateur
                AllowedFilter::callback('operateur', function ($query, $value) {
                    $query->whereHas('operateur', fn($q) => $q->where('name', 'like', "%{$value}%"));
                }),
                // Filtre sur relation engin
                AllowedFilter::callback('numero_serie', function ($query, $value) {
                    $query->whereHas('engin', fn($q) => $q->where('numero_serie', 'like', "%{$value}%"));
                }),
            ])
            ->with(['engin.typeEngin', 'operateur'])
            ->latest()
            ->paginate(5);

        return new DailyUsageCollectionResponse($dailyusages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'site_destination' => 'required|string|max:255',
            'observation_depart' => 'nullable|string|max:500',
            'operateur_id' => 'required|exists:users,id',
            'engin_id' => 'required|exists:engins,id',
            'date_usage' => 'required|date',
            'heure_sortie' => 'required|date_format:Y-m-d H:i:s',
            'compteur_h_sortie' => 'required|numeric',
            'compteur_km_sortie' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation échouée',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dailyUsage = DailyUsage::create([
            'site_destination' => $request->site_destination,
            'observation_depart' => $request->observation_depart,
            'operateur_id' => $request->operateur_id,
            'engin_id' => $request->engin_id,
            'date_usage' => $request->date_usage,
            'heure_sortie' => $request->heure_sortie,
            'compteur_h_sortie' => $request->compteur_h_sortie,
            'compteur_km_sortie' => $request->compteur_km_sortie,
            'is_returned' => false,
        ]);

        return response()->json([
            'message' => 'Sortie d’engin enregistrée avec succès',
            'data' => $dailyUsage,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyUsage $dailyUsage)
    {
        // Validation des champs de retour
        $validated = $request->validate([
            'heure_retour' => ['required', 'date', 'after:heure_sortie', 'date_format:Y-m-d H:i:s'],
            'compteur_h_retour' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($dailyUsage) {
                    if ($value < $dailyUsage->compteur_h_sortie) {
                        $fail("Le compteur d'heures retour doit être supérieur ou égal à {$dailyUsage->compteur_h_sortie}");
                    }
                },
            ],
            'compteur_km_retour' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($dailyUsage) {
                    if ($value < $dailyUsage->compteur_km_sortie) {
                        $fail("Le compteur km retour doit être supérieur ou égal à {$dailyUsage->compteur_km_sortie}");
                    }
                },
            ],
            'observation_retour' => ['nullable', 'string'],
            'carburant_rempli_l' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Update partiel avec PATCH
        $dailyUsage->update(array_merge($validated, [
            'is_returned' => true, // force le retour
        ]));

        // Retourner la ressource avec relations utiles
        return response()->json([
            'data' => $dailyUsage->load(['engin.typeEngin', 'operateur']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
