<?php

namespace App\Http\Controllers;

use App\Actions\Engins\CreateEnginAction;
use App\Actions\Engins\DeleteEnginAction;
use App\Actions\Engins\UpdateEnginAction;
use App\Enums\EnginCarburant;
use App\Enums\EnginStatus;
use App\Http\Requests\EnginDataFilterRequest;
use App\Http\Requests\StoreEnginRequest;
use App\Http\Requests\UpdateEnginRequest;
use App\Http\Resources\DailyUsageResource;
use App\Http\Resources\EnginResource;
use App\Http\Resources\MaintenanceResource;
use App\Http\Resources\TypeEnginResource;
use App\Models\Engin;
use App\Models\TypeEngin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class EnginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $engins = QueryBuilder::for(Engin::class)->allowedFilters(['designation', 'modele', 'marque', 'numero_serie', 'type_engin_id', 'etat', 'carburant'])
            ->with('typeEngin')
            ->defaultSort('marque')
            ->paginate(16);

        return Inertia::render('engins/Index', [
            'engins' => EnginResource::collection(
                $engins,
            ),
            'types_engin' => TypeEnginResource::collection(
                TypeEngin::all(),
            ),
            'etats' => EnginStatus::values(),
            'carburants' => EnginCarburant::values(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('engins/Create', [
            'types_engin' => TypeEnginResource::collection(
                TypeEngin::all(),
            ),
            'etats' => EnginStatus::values(),
            'type_carburants' => EnginCarburant::values(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnginRequest $request, CreateEnginAction $action)
    {
        $validated = $request->validated();
        $action->execute($validated);

        return to_route('engins.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Engin $engin, EnginDataFilterRequest $request)
    {
        $engin->load(['typeEngin']);
        $maintenances = $this->getFilteredMaintenances($engin, $request)
            ->paginate(10, ['*'], 'maintenances_page');

        $dailyUsages = $this->getFilteredDailyUsages($engin, $request)
            ->paginate(10, ['*'], 'daily_usages_page');

        return Inertia::render('engins/Show', [
            'engin' => EnginResource::make($engin),
            'maintenances' => MaintenanceResource::collection($maintenances),
            'daily_usages' => DailyUsageResource::collection($dailyUsages),
            'filters' => $request->only([
                'maint_start_date',
                'maint_end_date',
                'usage_start_date',
                'usage_end_date',
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Engin $engin)
    {
        $engin->load('typeEngin');

        return Inertia::render('engins/Edit', [
            'engin' => EnginResource::make($engin),
            'types_engin' => TypeEnginResource::collection(
                TypeEngin::all(),
            ),
            'etats' => EnginStatus::values(),
            'type_carburants' => EnginCarburant::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnginRequest $request, Engin $engin, UpdateEnginAction $action)
    {
        $action->execute($engin, $request->validated());

        return to_route('engins.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Engin $engin, DeleteEnginAction $action)
    {
        $action->execute($engin);

        return redirect()->route('dashboard');
    }

    private function getFilteredMaintenances(Engin $engin, EnginDataFilterRequest $request)
    {
        return $engin->maintenances()
            ->filterByDateRange('date_planifiee', $request->get('maint_start_date'), $request->get('maint_end_date'))
            ->with(['technicien', 'responsable', 'incident'])
            ->orderBy('date_planifiee', 'desc');
    }

    public function getFilteredDailyUsages(Engin $engin, EnginDataFilterRequest $request)
    {
        return $engin->dailyUsages()
            ->filterByDateRange('date_usage', $request->get('usage_start_date'), $request->get('usage_end_date'))
            ->with(['engin', 'operateur'])
            ->orderBy('date_usage', 'desc');
    }

    public function generatePdf(Engin $engin, EnginDataFilterRequest $request)
    {
        $engin->load(['typeEngin']);

        $maintenances = $this->getFilteredMaintenances($engin, $request);

        $pdf = Pdf::loadView('pdf.maintenances', [
            'engin' => $engin,
            'maintenances' => $maintenances->get(),
            'start_date' => $request->get('maint_start_date'),
            'end_date' => $request->get('maint_end_date'),
        ]);

        return $pdf->stream("maintenance_{$engin->id}.pdf");
    }
}
