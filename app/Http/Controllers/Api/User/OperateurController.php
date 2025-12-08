<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class OperateurController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \App\Http\Resources\UserCollection
    {
        $operateurs = QueryBuilder::for(User::operateur())
            ->allowedFilters(['matricule'])
            ->defaultSort('matricule')
            ->paginate(10);

        return new UserCollection($operateurs);
    }
}
