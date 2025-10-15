<script lang="ts" setup>
import { AlertMaintenance } from '@/types';
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button';


const props = defineProps<{ alertMaintenances: AlertMaintenance[] }>();
</script>
<template>
    <div v-for="alerte in props.alertMaintenances" :key="alerte.id"
        class="flex items-start justify-between p-3 mb-2 rounded-md border border-gray-200 bg-white shadow-sm hover:bg-gray-50 transition">
        <div class="flex items-start gap-3 flex-1">
            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ alerte.engin?.designation }}
                    </p>
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded bg-yellow-100 text-yellow-700 capitalize">
                        {{ alerte.maintenance_automatique?.type }}
                    </span>
                </div>
                <p class="text-xs text-gray-600 mt-1">Numéro série : <span class="font-semibold text-gray-900">
                        {{ alerte.engin.numero_serie }}
                    </span>
                </p>
                <p class="text-xs text-gray-600 mt-1">
                    Seuil atteint :
                    <span class="font-semibold text-gray-900">
                        {{ alerte.maintenance_automatique?.type === 'horaire'
                            ? alerte.compteur_declencheur + ' h'
                            : alerte.compteur_declencheur + ' km' }}
                    </span>
                </p>
                <p class="text-xs text-red-600 mt-0.5">⚠️ Maintenance nécessaire</p>
            </div>
        </div>
        <div class="flex items-center gap-2 ml-3">
            <p class="text-[10px] text-gray-400 whitespace-nowrap">
                {{ alerte.created_human }}
            </p>
            <Link :href="route('maintenances.auto.create', alerte.id)">
            <Button
                class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow-sm transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 
         0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Planifier
            </Button>

            </Link>
        </div>
    </div>
</template>