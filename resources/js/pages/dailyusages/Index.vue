<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type DailyUsage } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import Pagination from '@/components/Pagination.vue';
import DailyUsageCard from '@/components/DailyUsageCard.vue';
import { useEchoPublic } from "@laravel/echo-vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Mouvements',
        href: '/daily-usages',
    },
];

const props = defineProps<{
    daily_usages: {
        data: Array<DailyUsage>
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
    }
    sortie_du_jour: number,
    retour_du_jour: number,
    en_cours: number,
}>();

const showFilters = ref(false)

const form = useForm<{
    filter: {
        nom: string,
        marque: string,
        modele: string,
        numero_serie: string,
        type_engin_id?: number,
        etat: string,
        carburant: string,
    }
}>({
    filter: {
        nom: '',
        marque: '',
        modele: '',
        numero_serie: '',
        type_engin_id: undefined,
        etat: '',
        carburant: '',
    }
});

const dailyUsages = ref<Array<DailyUsage>>([...props.daily_usages.data]);

useEchoPublic<{ daily_usage: DailyUsage }>(`daily-usages`, [".daily.usage.created", ".daily.usage.updated"],
    (e: { daily_usage: DailyUsage }) => {
        const index = dailyUsages.value.findIndex(usage => usage.id === e.daily_usage.id);
        if (index !== -1) {
            dailyUsages.value[index] = e.daily_usage;
        } else {
            dailyUsages.value.unshift(e.daily_usage);
        }
        console.log(e);
    }
);


const submit = () => {
    // form.get(route('engins.index'), {
    //     preserveScroll: true,
    //     onFinish: () => form.reset("filter.type_engin_id", "filter.etat", "filter.carburant"),
    // });
};

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
                                Suivi des mouvements des engins
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Enregistrement des entrées et sorties des engins
                            </p>
                        </div>
                        <!-- <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                            <Link :href="route('maintenances.create')" class="btn-primary"> Programmer une maintenance
                            </Link>
                        </Button> -->
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                            <p class="text-sm font-medium text-gray-500">Sorties aujourd'hui</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.sortie_du_jour"></p>
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
                            <p class="text-sm font-medium text-gray-500">En service</p>
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
                            <p class="text-sm font-medium text-gray-500">Retours aujourd'hui</p>
                            <p class="text-xl font-semibold text-gray-900" v-text="props.retour_du_jour"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barre de recherche et filtres -->
            <form class="bg-white shadow rounded-lg p-4" @submit.prevent="submit">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Recherche -->
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.nom" id="nom" class="w-full" placeholder="Rechercher par nom..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.marque" id="marque" class="w-full"
                            placeholder="Rechercher par marque..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.modele" id="modele" class="w-full"
                            placeholder="Rechercher par modèle..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.numero_serie" id="numero" class="w-full"
                            placeholder="Rechercher par numéro de série..." />

                    </div>

                    <Button variant="secondary" size="sm">
                        <span class="text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </span>
                    </Button>
                    <Button type="button" variant="secondary" size="sm" @click.prevent="showFilters = !showFilters">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>

                        </span>
                        Filtres
                    </Button>
                </div>
                <!-- Filtres avancés -->
                <div v-if="showFilters" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <!-- <Select v-model="form.filter.type_engin_id">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Selectinner un type" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <template v-for="type in props.types_engin.data" :key="type.id">
                                        <SelectItem :value="type.id">
                                            {{ type.nom }}
                                        </SelectItem>
                                    </template>
</SelectGroup>
</SelectContent>
</Select> -->

                    </div>




                    <div class="flex items-end">
                        <Button variant="secondary" size="sm" class="w-full">
                            Effacer les filtres
                        </Button>
                    </div>
                </div>
            </form>

            <!-- Liste des engins-->

            <div>
                <div v-if="dailyUsages.length > 0" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <DailyUsageCard :usages="dailyUsages" />
                </div>

                <div v-else class="text-center py-12">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun engin trouvé</h3>
                </div>
                <div class="flex justify-center m-2">
                    <Pagination :meta="props.daily_usages.meta" :only="['daily_usages']" />
                </div>

            </div>


        </div>
    </AppLayout>
</template>