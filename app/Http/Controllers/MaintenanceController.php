<?php

namespace App\Http\Controllers;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Resources\EnginResource;
use App\Http\Resources\MaintenanceResource;
use App\Http\Resources\UserResource;
use App\Models\Engin;
use App\Models\Maintenance;
use App\Models\User;
use App\Services\Maintenance\MaintenanceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = (new MaintenanceService)->getMaintenanceCounts();
        $maintenances = MaintenanceResource::collection(
            Maintenance::with(['engin.typeEngin', 'technicien'])->latest()->paginate(16)
        );

        return Inertia::render('maintenance/Index', [...$counts, 'maintenances' => $maintenances]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('maintenance/Create', [
            'maintenance_statut' => MaintenanceStatus::values(),
            'maintenance_type' => MaintenanceType::values(),
            'techniciens' => UserResource::collection(
                User::technicien()->get()
            ),
            'engins' => EnginResource::collection(
                Engin::with('typeEngin')->get()
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request)
    {
        auth()->user();
        $validated = $request->validated();
        Maintenance::query()->create($validated);

        return to_route('maintenances.index')->with('success', 'Maintenance créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
