<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Engin, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { useEchoPublic } from "@laravel/echo-vue";


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface MaintenanceAutomatique {
    id: number;
    description: string;
    type: "horaire" | "km";
}

interface Alerte {
    id: number;
    engin: Engin;
    maintenance_automatique: MaintenanceAutomatique;
    compteur_declencheur: number;
    statut: "nouvelle" | "planifiee";
    created_human: string;
}

const props = defineProps<{
    incidents: Array<{
        id: number;
        description: string;
        niveau_gravite: string;
        date: string;
        engin?: {
            id: number;
            nom: string;
        } | null;
    }>;
    alert_maintenances: Array<Alerte>;
    maintenances: Array<{
        id: number;
        date_planifiee: string;
        statut: string;
        description: string;
        engin?: {
            id: number;
            nom: string;
        } | null;
        technicien?: {
            id: number;
            name: string;
        };
    }>;
    totalEngin: number;

    enginEnMaintenance: number;
    enginHorsService: number;
}>();

// Réactivité pour les alertes de maintenance
const alertMaintenances = ref<Array<Alerte>>([...props.alert_maintenances]);

const addNewAlert = (newAlert: Alerte) => {
    newAlert.created_human = 'À l\'instant';

    alertMaintenances.value.unshift(newAlert);

    if (alertMaintenances.value.length > 3) {
        alertMaintenances.value = alertMaintenances.value.slice(0, 3);
    }
    console.log('Nouvelle alerte de maintenance:', newAlert);
};

useEchoPublic("alert-maintenance-channel", ".alert.maintenance.created", (event: any) => {
    console.log("📡 ÉVÉNEMENT REÇU :", event);
    addNewAlert(event.alert_maintenance);
});

// const alertBorderClass = (severity: string) => {
//     const classes = {
//         critical: 'border-error-200 bg-error-50',
//         high: 'border-warning-200 bg-warning-50',
//         medium: 'border-warning-200 bg-warning-50',
//         low: 'border-gray-200 bg-gray-50'
//     };
//     return classes[severity as keyof typeof classes];
// };

// const alertIconClass = (severity: string) => {
//     const classes = {
//         critical: 'text-error-500',
//         high: 'text-warning-500',
//         medium: 'text-warning-500',
//         low: 'text-gray-500'
//     };
//     return classes[severity as keyof typeof classes];
// };
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div
                    class="relative p-6 rounded-2xl bg-white shadow-sm shadow-green-600 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-lg dark:bg-card ">
                    <div class="space-y-2">
                        <div
                            class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                            <span>Total Engins</span>
                        </div>

                        <div class="text-3xl dark:text-gray-100" v-text="totalEngin">
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-green-600">

                            <span>32k increase</span>

                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div
                    class="relative p-6 rounded-2xl bg-white shadow-sm shadow-green-600 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-lg dark:bg-card">
                    <div class="space-y-2">
                        <div
                            class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                            <span>Opérationnels</span>
                        </div>

                        <div class="text-3xl dark:text-gray-100">
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-green-600">

                            <span>32k increase</span>

                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div
                    class="relative p-6 rounded-2xl bg-white shadow-sm shadow-green-600 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-lg dark:bg-card">
                    <div class="space-y-2">
                        <div
                            class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                            <span>En Maintenance</span>
                        </div>

                        <div class="text-3xl dark:text-gray-100" v-text="enginEnMaintenance">

                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-red-600">

                            <span>3% decrease</span>

                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                </div>
                <div
                    class="relative p-6 rounded-2xl bg-white dark:bg-card shadow-sm shadow-green-600  transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="space-y-2">
                        <div
                            class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                            <span>En Panne</span>
                        </div>

                        <div class="text-3xl dark:text-gray-100" v-text="enginHorsService">
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-red-600">

                            <span>3% decrease</span>

                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- <div
                class="relative min-h-[100vh] flex-1 rounded-xl shadow-green-800 shadow-sm border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-white dark:bg-card">
               
            </div> -->
            <div class="grid grid-cols-1 relative min-h-[100vh] lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Alertes Urgentes</h3>
                    </div>
                    <div class="px-6 py-4">
                        <!-- <div v-if="urgentAlerts.length === 0" class="text-center py-8 text-gray-500">
        <CheckCircleIcon class="h-12 w-12 mx-auto mb-4 text-success-500" />
        <p>Aucune alerte urgente</p>
      </div> -->
                        <div class="space-y-4">
                            <div v-for="incident in props.incidents" :key="incident.id"
                                class="flex items-start space-x-3 p-4 rounded-lg border border-red-200 bg-red-50">
                                <div class="flex-shrink-0">
                                    <!-- <ExclamationTriangleIcon class="h-5 w-5 " /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>

                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ incident.engin?.nom }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ incident.description }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ incident.date }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <button class="btn btn-secondary text-xs">
                                        Acquitter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Alertes maintenances</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div v-for="alerte in alertMaintenances" :key="alerte.id"
                                class="flex items-start justify-between p-3 mb-2 rounded-md border border-gray-200 bg-white shadow-sm hover:bg-gray-50 transition animate-pulse">

                                <!-- Gauche -->
                                <div class="flex items-start gap-3 flex-1">
                                    <!-- Icône -->
                                    <div
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                                        </svg>
                                    </div>

                                    <!-- Texte -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Ligne titre + badge -->
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ alerte.engin?.designation }}
                                            </p>
                                            <span
                                                class="px-2 py-0.5 text-[10px] font-medium rounded bg-yellow-100 text-yellow-700 capitalize">
                                                {{ alerte.maintenance_automatique?.type }}
                                            </span>
                                        </div>

                                        <!-- Dernier compteur -->
                                        <p class="text-xs text-gray-600 mt-1">
                                            Seuil atteint :
                                            <span class="font-semibold text-gray-900">
                                                {{ alerte.maintenance_automatique?.type === 'horaire'
                                                    ? alerte.compteur_declencheur + ' h'
                                                    : alerte.compteur_declencheur + ' km' }}
                                            </span>
                                        </p>

                                        <!-- Message alerte -->
                                        <p class="text-xs text-red-600 mt-0.5">⚠️ Maintenance nécessaire</p>
                                    </div>
                                </div>

                                <!-- Droite -->
                                <div class="flex items-center gap-2 ml-3">
                                    <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                        {{ alerte.created_human }}
                                    </p>
                                    <Link href="#">
                                    <Button
                                        class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow-sm transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 
         0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Planifier
                                    </Button>

                                    </Link>
                                </div>
                            </div>








                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Maintenances Prochaines</h3>
                    </div>
                    <div class="px-6 py-4">
                        <!-- <div v-if="upcomingMaintenances.length === 0" class="text-center py-8 text-gray-500">
                            <CalendarIcon class="h-12 w-12 mx-auto mb-4 text-gray-400" />
                            <p>Aucune maintenance prévue cette semaine</p>
                        </div> -->
                        <div class="space-y-4">
                            <div v-for="equipment in props.maintenances" :key="equipment.id"
                                class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                                            </svg>

                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ equipment.engin?.nom }}</p>
                                        <p class="text-sm text-gray-500">{{ equipment.technicien?.name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ equipment.date_planifiee }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        jours
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
