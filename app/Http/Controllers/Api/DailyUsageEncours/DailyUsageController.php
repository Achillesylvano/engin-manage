<?php

namespace App\Http\Controllers\Api\DailyUsageEncours;

use App\Http\Resources\DailyUsageCollection;
use App\Models\DailyUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class DailyUsageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $dailyusages = QueryBuilder::for(DailyUsage::enCours())
            ->allowedFilters([
                AllowedFilter::callback('operateur', function ($query, $value): void {
                    $query->whereHas('operateur', fn($q) => $q->where('name', 'like', "%{$value}%"));
                }),
                // Filtre sur relation engin
                AllowedFilter::callback('numero_serie', function ($query, $value): void {
                    $query->whereHas('engin', fn($q) => $q->where('numero_serie', 'like', "%{$value}%"));
                }),
            ])
            ->with(['engin.typeEngin', 'operateur'])
            ->latest()
            ->paginate(3);

        return new DailyUsageCollection($dailyusages);
    }
}
