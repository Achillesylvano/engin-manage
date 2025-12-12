<script setup lang="ts">
import { getStatusColorClasses } from '@/lib/utils';
import { Button } from "@/components/ui/button";
import { Link } from '@inertiajs/vue3'
import { Engin } from '@/types';


const props = defineProps<{
    engin: Engin
}>();
</script>
<template>
    <div
        class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg hover:scale-[1.02] transition-transform duration-300 border border-gray-200 overflow-hidden">
        <!-- En-tête de la carte -->
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-1 truncate">
                    {{ props.engin.designation }}
                </h3>
                <span :class="getStatusColorClasses(props.engin.etat_color)"
                    class="px-3 py-1 text-xs font-medium rounded-full">
                    {{ props.engin.etat_label }}
                </span>
            </div>
        </div>

        <!-- Informations de l'engin -->
        <div class="space-y-3 mb-6">
            <div class="grid grid-cols-1 gap-2">
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Marque :</span>
                    <span class="text-gray-900 font-semibold truncate">{{
                        props.engin.marque
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Type :</span>
                    <span class="text-gray-900 font-semibold truncate">{{
                        props.engin.type_engin?.nom
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Modèle :</span>
                    <span class="text-gray-900 truncate">{{ props.engin.modele }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">N° de série :</span>
                    <span class="text-gray-900 font-mono text-sm truncate">{{
                        props.engin.numero_serie
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Carburant :</span>
                    <span class="text-gray-900">{{ props.engin.type_carburant_label }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Heures d'utilisation :</span>
                    <span class="text-gray-900 font-semibold">{{
                        props.engin.compteur_h
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Kilométrage :</span>
                    <span class="text-gray-900 font-semibold">{{
                        props.engin.compteur_km
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Date d'acquisition :</span>
                    <span class="text-gray-900">{{
                        props.engin.date_acquisition
                        }}</span>
                </div>
                <div class="flex justify-between gap-x-2">
                    <span class="text-gray-600 font-medium">Capacité réservoir :</span>
                    <span class="text-gray-900 font-semibold">{{
                        props.engin.capacite_reservoir
                        }}</span>
                </div>
            </div>
        </div>

        <!-- Bouton Voir plus -->
        <div class="pt-4 border-t border-gray-200">
            <div class="flex gap-2">
                <Link :href="route('engins.show', props.engin.id)" class="flex-1">
                    <Button class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Voir plus
                    </Button>
                </Link>

                <Link href="#" class="flex-1">
                    <Button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 4h2a2 2 0 012 2v2l-6 6-4-4 6-6zM3 21h18" />
                        </svg>
                        Modifier
                    </Button>
                </Link>
            </div>
        </div>


    </div>
</template>