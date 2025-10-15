<?php

namespace App\Http\Controllers;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Resources\EnginResource;
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
        $maintenance = (new MaintenanceService)->getMaintenanceCounts();

        return Inertia::render('maintenance/Index', $maintenance);
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
        $user = auth()->user();
        $validated = $request->validated();
        Maintenance::create($validated);

        return redirect()->back()->with('success', 'La maintenance a été créé');
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
