<?php

namespace App\Http\Controllers\Api\Engin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnginCollection;
use App\Models\Engin;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class EnginDisponibleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $engins = QueryBuilder::for(Engin::disponibles())->allowedFilters(['designation', 'numero_serie'])
            ->defaultSort('numero_serie')
            ->with(['latestDailyUsage', 'typeEngin'])
            ->paginate(15);

        return new EnginCollection($engins);
    }
}
