<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnginResource;
use App\Models\Engin;
use App\Models\MaintenanceAutomatique;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaintenanceAutomatiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Engin $engin)
    {
        return Inertia::render('MaintenanceAutomatique/Create', [
            'engin' => EnginResource::make($engin),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'engin_id' => ['required', 'exists:engins,id'],
            'type' => ['required', 'in:horaire,km'],
            'seuil' => ['required', 'numeric', 'min:1'],
            'dernier_compteur' => ['numeric', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $existing = MaintenanceAutomatique::where('engin_id', $validated['engin_id'])
            ->where('type', $validated['type'])
            ->first();
        if ($existing) {
            return redirect()->back()->withErrors(['type' => 'Une maintenance automatique de ce type existe déjà pour cet engin.']);
        }

        MaintenanceAutomatique::create($validated);

        return redirect()->back()->with('success', 'Maintenance automatique créée');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
