<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\AlertMaintenance;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreateMaintenanceFromAutomatiqueController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AlertMaintenance $alertMaintenance)
    {
        return Inertia::render('maintenance/CreateFromAutomatique', [
            'alertMaintenance' => $alertMaintenance->load('maintenanceAutomatique', 'engin'),
            'techniciens' => UserResource::collection(
                User::technicien()->get()
            ),
        ]);
    }
}
