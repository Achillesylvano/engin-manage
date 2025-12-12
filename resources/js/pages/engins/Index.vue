<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Engin, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import { ref } from 'vue'

import Pagination from '@/components/Pagination.vue';
import EnginCard from '@/components/EnginCard.vue';
import EnginTable from '@/components/EnginTable.vue';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Liste des engins',
        href: '/engins',
    },
];

const props = defineProps<{
    engins: {
        data: Array<Engin>
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
    },
    types_engin:
    {
        data: Array<{
            id: number,
            nom: string,
        }>
    },
    etats: Record<string, string>;
    carburants: Record<string, string>;
}>();

const form = useForm<{
    filter: {
        designation: string,
        marque: string,
        modele: string,
        numero_serie: string,
        type_engin_id?: number,
        etat: string,
        carburant: string,
    }
}>({
    filter: {
        designation: '',
        marque: '',
        modele: '',
        numero_serie: '',
        type_engin_id: undefined,
        etat: '',
        carburant: '',
    }
});

const showFilters = ref(false)


const submit = () => {
    form.get(route('engins.index'), {
        preserveScroll: true,
        onFinish: () => form.reset("filter.type_engin_id", "filter.etat", "filter.carburant"),
    });
};

</script>
<template>

    <Head title="Engin" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Gestion des engins
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">

                            </p>
                        </div>
                        <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                            <Link :href="route('engins.create')" class="btn-primary"> Nouveau engin</Link>
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Barre de recherche et filtres -->
            <form class="bg-white shadow rounded-lg p-4" @submit.prevent="submit">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Recherche -->
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.designation" id="designation" class="pl-10 w-full"
                            placeholder="Rechercher par nom..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.marque" id="marque" class="pl-10 w-full"
                            placeholder="Rechercher par marque..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.modele" id="modele" class="pl-10 w-full"
                            placeholder="Rechercher par modèle..." />

                    </div>
                    <div class="flex-1 relative">
                        <Input v-model="form.filter.numero_serie" id="numero" class="pl-10 w-full"
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
                        <Select v-model="form.filter.type_engin_id">
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
                        </Select>

                    </div>

                    <div>
                        <Select v-model="form.filter.etat">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Selectinner un statut" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <template v-for="(label, value) in props.etats" :key="value">
                                        <SelectItem :value="value">
                                            {{ label }}
                                        </SelectItem>
                                    </template>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                    </div>
                    <div>
                        <Select v-model="form.filter.carburant">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Type de carburant" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <template v-for="(label, value) in props.carburants" :key="value">
                                        <SelectItem :value="value">
                                            {{ label }}
                                        </SelectItem>
                                    </template>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                    </div>

                    <div class="flex items-end">
                        <Button variant="secondary" size="sm" class="w-full">
                            Effacer les filtres
                        </Button>
                    </div>
                </div>
            </form>

            <div>
                <Tabs default-value="card" class="w-full">
                    <TabsList>
                        <TabsTrigger value="card">
                            Vue carte
                        </TabsTrigger>
                        <TabsTrigger value="table">
                            Vue tableau
                        </TabsTrigger>
                    </TabsList>
                    <TabsContent value="card">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                            <template v-if="props.engins.data.length > 0">
                                <EnginCard v-for="engin in props.engins.data" :key="engin.id" :engin="engin" />
                            </template>
                            <template v-else>
                                <div class="glass-card col-span-full rounded-lg p-12 text-center animate-fade-in"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-12 h-12 text-muted-foreground mx-auto mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>

                                    <h3 class="text-lg font-medium text-foreground mb-2">Aucun engin trouvé.</h3>
                                    <p class="text-muted-foreground">Modifiez vos filtres pour voir plus de résultats.
                                    </p>
                                </div>
                            </template>
                        </div>
                    </TabsContent>
                    <TabsContent value="table">
                        <EnginTable :engins="props.engins.data" />
                    </TabsContent>
                </Tabs>
            </div>
            <div class="col-span-full flex justify-center m-2">
                <Pagination :meta="props.engins.meta" :only="['engins']" />
            </div>
        </div>
    </AppLayout>
</template>