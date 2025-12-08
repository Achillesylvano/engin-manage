<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyUsageResource;
use App\Models\DailyUsage;
use App\Services\DailyUsage\DailyUsageStatService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailyUsageStat = (new DailyUsageStatService)->getDailyUsageStats();

        return Inertia::render('dailyusages/Index', array_merge([
            'daily_usages' => DailyUsageResource::collection(
                DailyUsage::with(['engin.typeEngin', 'operateur'])
                    ->latest()
                    ->paginate(5),
            ),
        ], $dailyUsageStat));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
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
