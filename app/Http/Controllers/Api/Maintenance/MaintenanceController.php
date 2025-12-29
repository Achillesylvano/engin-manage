<?php

namespace App\Http\Controllers\Api\Maintenance;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\MaintenanceResource;

class MaintenanceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
          $maintenances = QueryBuilder::for(Maintenance::class)
            ->allowedFilters([
                'type',
                'statut',
                AllowedFilter::callback('numero_serie', function ($query, $value): void {
                    $query->whereHas('engin', fn ($q) =>
                        $q->where('numero_serie', 'like', "%{$value}%")
                    );
                }),
                AllowedFilter::callback('technicien', function ($query, $value): void {
                    $query->whereHas('technicien', fn ($q) =>
                        $q->where('name', 'like', "%{$value}%")
                    );
                }),
            ])
            ->with([
                'engin.typeEngin',
                'technicien',
                'responsable',
                'incident',
            ])
            ->latest()
            ->paginate(15);

        return MaintenanceResource::collection($maintenances);
    }
}
