<?php

namespace Database\Seeders;

use App\Models\DailyUsage;
use App\Models\Engin;
use App\Models\Incident;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Intervention;
use App\Models\Maintenance;
use App\Models\TypeEngin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin fixe
        User::factory()->create([
            'matricule' => 'SMMC-0000',
            'name' => 'Achille',
            'email' => 'achille@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Utilisateurs par rôle
        $techniciens = User::factory(10)->create(['role' => 'technicien']);
        $responsables = User::factory(10)->create(['role' => 'responsable_flotte']);
        $operateurs = User::factory(10)->create(['role' => 'operateur']);
        $agentsSuivi = User::factory(10)->create(['role' => 'agent_suivi']);

        // Types d'engins via factory (assure-toi que la factory utilise unique() sur les noms)
        TypeEngin::factory(5)->create();
        $types = TypeEngin::all();

        // Engins liés aux types créés
        $engins = Engin::factory(50)->create([
            'type_engin_id' => fn () => $types->random()->id,
        ]);

        // Daily usages
        $dailyUsages = DailyUsage::factory(50)->make()->each(function ($dailyUsage) use ($engins, $operateurs, $agentsSuivi) {
            $dailyUsage->engin_id = $engins->random()->id;
            $dailyUsage->operateur_id = $operateurs->random()->id;
            $dailyUsage->agent_suivi_id = $agentsSuivi->random()->id;
            $dailyUsage->save();
        });

        // Incidents
        $incidents = Incident::factory(15)->make()->each(function ($incident) use ($engins, $dailyUsages, $operateurs) {
            $incident->engin_id = $engins->random()->id;
            $incident->daily_usage_id = $dailyUsages->random()->id;
            $incident->operateur_id = $operateurs->random()->id;
            $incident->save();
        });

        // Maintenances
        $maintenances = Maintenance::factory(20)->make()->each(function ($maintenance) use ($engins, $techniciens, $responsables, $incidents) {
            $maintenance->engin_id = $engins->random()->id;
            $maintenance->technicien_id = $techniciens->random()->id;
            $maintenance->responsable_id = $responsables->random()->id;
            $maintenance->incident_id = $incidents->random()->id;
            $maintenance->save();
        });

        // Interventions
        Intervention::factory(20)->make()->each(function ($intervention) use ($maintenances) {
            $intervention->maintenance_id = $maintenances->random()->id;
            $intervention->save();
        });
    }
}
