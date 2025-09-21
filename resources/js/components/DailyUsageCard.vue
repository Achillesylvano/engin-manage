<script setup lang="ts">
import { formatDateTime, cardClasses } from '@/lib/utils';
import { type DailyUsage } from '@/types';

const props = defineProps<{
    usages: Array<DailyUsage>
}>();
</script>

<template>
    <template v-for="daily_usage in props.usages" :key="daily_usage.id">
        <div :class="cardClasses(daily_usage.is_returned)" class="rounded-lg shadow-sm p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ daily_usage.engin?.designation }}</h3>
                    <p class="text-sm text-gray-900">{{ daily_usage.engin?.type_engin?.nom }}</p>
                </div>
                <div>
                    <span v-if="daily_usage.is_returned" class="badge-returned">Retour</span>
                    <span v-else class="badge-out">Sorti</span>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 mr-3 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Destination:</span>
                    <span class="ml-2 text-gray-600">{{ daily_usage.site_destination }}</span>
                </div>
                <div class="flex items-center text-sm ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="h-4 w-4 mr-3 text-gray-800" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="font-medium text-gray-900">Opérateur:</span>
                    <span class="ml-2 text-gray-600">{{ daily_usage.operateur?.name }}</span>
                </div>
                <div class="flex items-center text-sm ">
                    <!-- <CalendarDaysIcon class="" /> -->
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 mr-3 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                    </span>
                    <span class="font-medium text-gray-900">Sortie:</span>
                    <span class="ml-2 text-gray-600" v-text="formatDateTime(daily_usage.heure_sortie)"></span>
                </div>
                <div v-if="daily_usage.heure_retour" class="flex items-center text-sm">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 mr-3 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Retour:</span>
                    <span class="ml-2 text-gray-600" v-text="formatDateTime(daily_usage.heure_retour)"></span>
                </div>

                <div class="flex items-center text-sm ">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 mr-3 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Compteur d’heure(sortie):</span>
                    <span class="ml-2 text-gray-600"> {{ daily_usage.compteur_h_sortie }} h</span>
                </div>
                <div v-if="daily_usage.compteur_h_retour" class="flex items-center text-sm ">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 mr-3 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Compteur d’heure(retour):</span>
                    <span class="ml-2 text-gray-600"> {{ daily_usage.compteur_h_retour }} h</span>
                </div>
                <div class="flex items-center text-sm ">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="h-4 w-4 mr-3 text-gray-800" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                            <path fill-rule="evenodd"
                                d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Compteur km(sortie):</span>
                    <span class="ml-2 text-gray-600"> {{ daily_usage.compteur_km_sortie }} km</span>
                </div>
                <div v-if="daily_usage.compteur_km_retour" class="flex items-center text-sm ">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="h-4 w-4 mr-3 text-gray-800" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                            <path fill-rule="evenodd"
                                d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Compteur km(retour):</span>
                    <span class="ml-2 text-gray-600"> {{ daily_usage.compteur_km_retour }} km</span>
                </div>
                <div v-if="daily_usage.is_returned" class="flex items-center text-sm ">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="h-4 w-4 mr-3 text-gray-800" viewBox="0 0 16 16">
                            <path
                                d="M3 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5z" />
                            <path
                                d="M1 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v8a2 2 0 0 1 2 2v.5a.5.5 0 0 0 1 0V8h-.5a.5.5 0 0 1-.5-.5V4.375a.5.5 0 0 1 .5-.5h1.495c-.011-.476-.053-.894-.201-1.222a.97.97 0 0 0-.394-.458c-.184-.11-.464-.195-.9-.195a.5.5 0 0 1 0-1q.846-.002 1.412.336c.383.228.634.551.794.907.295.655.294 1.465.294 2.081v3.175a.5.5 0 0 1-.5.501H15v4.5a1.5 1.5 0 0 1-3 0V12a1 1 0 0 0-1-1v4h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1zm9 0a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v13h8z" />
                        </svg>
                    </span>
                    <span class="font-medium text-gray-900">Carburant ajouté (L):</span>
                    <span class="ml-2 text-gray-600"> 20 L</span>
                </div>
            </div>
        </div>
    </template>
</template>
