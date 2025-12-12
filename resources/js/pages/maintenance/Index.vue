<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import MaintenanceCard from '@/components/MaintenanceCard.vue';
import type { Maintenance } from '@/types';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Maintenance',
        href: '/maintenances',
    },
];

const props = defineProps<{
    en_retard: number,
    en_cours: number,
    a_venir: number,
    terminee: number,
    maintenances: {
        data: Maintenance[];
        meta: {
            current_page: number
            last_page: number
            total: number
            per_page: number
            links: Array<{
                url: string | null
                label: string
                active: boolean
            }>
        }

    };
}>();
</script>
<template>

    <Head title="Maintenance" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Gestion des maintenances
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Suivi et planification des maintenances de votre flotte
                            </p>
                        </div>
                        <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                            <Link :href="route('maintenances.create')" class="btn-primary"> Programmer une maintenance
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">À venir</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.a_venir"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="h-5 w-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>


                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">En retard</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.en_retard"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 text-yellow-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>


                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">En cours</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.en_cours"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>


                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Terminée</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.terminee"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--Maintenance list-->
            <div>
                <div v-if="props.maintenances.data.length === 0"
                    class="glass-card rounded-lg p-12 text-center animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12 text-muted-foreground mx-auto mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>

                    <h3 class="text-lg font-medium text-foreground mb-2">Aucune maintenance trouvée</h3>
                    <p class="text-muted-foreground">Modifiez vos filtres pour voir plus de résultats.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 animate-slide-up">
                    <MaintenanceCard v-for="(m, index) in props.maintenances.data" :key="m.id" :maintenance="m"
                        :style="{ animationDelay: `${index * 50}ms` }" />
                </div>
            </div>
            <div class="col-span-full flex justify-center m-2">
                <Pagination :meta="props.maintenances.meta" :only="['maintenances']" />
            </div>
        </div>
    </AppLayout>
</template>