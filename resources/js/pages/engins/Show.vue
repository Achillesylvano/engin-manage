<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { DailyUsage, Engin, Maintenance, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Separator } from '@/components/ui/separator'
import Pagination from '@/components/Pagination.vue';
import InputError from '@/components/InputError.vue';
// import { Badge } from '@/components/ui/badge'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Liste des engins',
        href: '/engins',
    },
];

const props = defineProps<{
    filters: {
        maint_start_date?: string,
        maint_end_date?: string,
        usage_start_date?: string,
        usage_end_date?: string
    },
    engin: Engin,
    maintenances: {
        data: Array<Maintenance>
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
}>();

const form = useForm<{
    maint_start_date?: string,
    maint_end_date?: string,
    usage_start_date?: string,
    usage_end_date?: string
}>({
    maint_start_date: props.filters.maint_start_date || '',
    maint_end_date: props.filters.maint_end_date || '',
    usage_start_date: props.filters.usage_start_date || '',
    usage_end_date: props.filters.usage_end_date || ''
})

const submitFilters = () => {
    form.get(route('engins.show', props.engin.id), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
}

const resetFilters = () => {
    form.maint_start_date = '';
    form.maint_end_date = '';
    form.usage_start_date = '';
    form.usage_end_date = '';
    submitFilters();
};

const downloadPdf = () => {
    const params = new URLSearchParams({
        maint_start_date: form.maint_start_date || '',
        maint_end_date: form.maint_end_date || ''
    }).toString();

    window.open(
        route('engins.pdf', props.engin.id) + '?' + params,
        '_blank'  // ouvre dans un nouvel onglet
    );
};





// const submit = () => {
//     form.get(route('engins.index'), {
//         preserveScroll: true,
//         onFinish: () => form.reset("filter.type_engin_id", "filter.etat", "filter.carburant"),
//     });
// };

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

                        <Link :href="route('maintenance-automatiques.create', props.engin.id)">
                        <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Programmer la maintenance
                        </Button>
                        </Link>
                    </div>
                </div>
            </div>

            <Tabs default-value="general" class="w-full">
                <TabsList class="grid w-full grid-cols-3">
                    <TabsTrigger value="general" class="flex items-center gap-2">
                        Information Générale
                    </TabsTrigger>
                    <TabsTrigger value="maintenance" class="flex items-center gap-2">
                        Historique de Maintenance
                    </TabsTrigger>
                    <TabsTrigger value="daily_usage" class="flex items-center gap-2">
                        Historique d'Usage Journalier
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="general" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2">
                                    <Settings class="h-5 w-5" />
                                    Informations Techniques
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Type</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.type_engin?.nom"></p>
                                    </div>
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Marque</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.marque"></p>
                                    </div>
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Modèle</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.modele"></p>
                                    </div>
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">N° Série</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.numero_serie"></p>
                                    </div>

                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Capacité du
                                            réservoir</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.capacite_reservoir"></p>
                                    </div>
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Date
                                            d'acquisition</Label>
                                        <p class="text-sm font-semibold" v-text="props.engin.date_acquisition"></p>
                                    </div>

                                </div>
                                <Separator />
                                <div class="flex items-center gap-2">
                                    <MapPin class="h-4 w-4 text-primary" />
                                    <span class="text-sm font-medium">Position actuelle: {enginData.position}</span>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2">

                                    Maintenance
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-3">
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Dernière
                                            Maintenance</Label>
                                        <p class="text-sm font-semibold text-green-600">
                                            {enginData.derniereMaintenance}</p>
                                    </div>
                                    <div>
                                        <Label class="text-sm font-medium text-muted-foreground">Prochaine
                                            Maintenance</Label>
                                        <p class="text-sm font-semibold text-orange-600">
                                            {enginData.prochaineMaintenance}</p>
                                    </div>
                                </div>
                                <Separator />
                                <div>
                                    <Label class="text-sm font-medium text-muted-foreground">Date
                                        d'acquisition</Label>
                                    <p class="text-sm font-semibold">{enginData.dateAcquisition}</p>
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="lg:col-span-2">
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2">
                                    <Gauge class="h-5 w-5" />
                                    Informations Compteurs
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="text-center p-4 bg-accent rounded-lg">
                                        <p class="text-2xl font-bold text-primary" v-text="props.engin.compteur_h"></p>
                                        <p class="text-sm text-muted-foreground">Heures de fonctionnement</p>
                                    </div>
                                    <div class="text-center p-4 bg-accent rounded-lg">
                                        <p class="text-2xl font-bold text-primary" v-text="props.engin.compteur_km"></p>
                                        <p class="text-sm text-muted-foreground">Km parcourue</p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </TabsContent>
                <TabsContent value="maintenance">
                    <Card>
                        <CardHeader>
                            <CardTitle>Historique de Maintenance</CardTitle>
                            <CardDescription>
                                Consultez l'historique complet des interventions de maintenance
                            </CardDescription>
                        </CardHeader>
                        <CardContent>

                            <div>
                                <form class="flex items-center gap-4 mb-6" @submit.prevent="submitFilters">
                                    <div class="flex items-center gap-2">
                                        <Label for="maint_start_date">Du:</Label>
                                        <Input id="maint_start_date" type="date" v-model="form.maint_start_date" />
                                        <InputError :message="form.errors.maint_start_date" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <Label for="maint_end_date">Au:</Label>
                                        <Input id="maint_end_date" type="date" v-model="form.maint_end_date" />
                                        <InputError :message="form.errors.maint_end_date" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <Button variant="secondary" size="sm">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                                </svg>
                                            </span>
                                            Filtres
                                        </Button>
                                        <Button variant="secondary" size="sm" @click.prevent="resetFilters">
                                            Réinitialiser
                                        </Button>
                                    </div>
                                </form>
                                <Button class="ml-auto" @click="downloadPdf">
                                    Exporter
                                </Button>
                            </div>


                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Date planifiée</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Description</TableHead>
                                        <TableHead>Technicien</TableHead>
                                        <TableHead>Statut</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <template v-for="maintenance in props.maintenances.data" :key="maintenance.id">
                                        <TableRow>
                                            <TableCell>{{ maintenance.date_planifiee }}</TableCell>
                                            <TableCell>
                                                <Badge>
                                                    {{ maintenance.type }}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>{{ maintenance.description }}</TableCell>
                                            <TableCell>{{ maintenance.technicien?.name }}</TableCell>
                                            <TableCell>
                                                <Badge>{{ maintenance.statut }}</Badge>
                                            </TableCell>
                                        </TableRow>
                                    </template>
                                </TableBody>
                            </Table>
                            <div class="flex items-center m-2">
                                <Pagination :meta="props.maintenances.meta" page-name="maintenances_page"
                                    :route-params="{ engin: props.engin.id }" :only="['maintenances']" />
                            </div>
                        </CardContent>
                    </Card>
                </TabsContent>
                <TabsContent value="daily_usage">
                    <Card>
                        <CardHeader>
                            <CardTitle>Historique d'Usage Journalier</CardTitle>
                            <CardDescription>
                                Consultez l'utilisation quotidienne de l'engin
                            </CardDescription>
                        </CardHeader>
                        <CardContent>

                            <div>
                                <form class="flex items-center gap-4 mb-6" @submit.prevent="submitFilters">
                                    <div class="flex items-center gap-2">
                                        <Label for="usage_start_date">Du:</Label>
                                        <Input id="usage_start_date" type="date" v-model="form.usage_start_date" />
                                        <InputError :message="form.errors.usage_start_date" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <Label for="usage_end_date">Au:</Label>
                                        <Input id="usage_end_date" type="date" v-model="form.usage_end_date" />
                                        <InputError :message="form.errors.usage_end_date" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <Button variant="secondary" size="sm">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                                </svg>
                                            </span>
                                            Filtres
                                        </Button>
                                        <Button variant="secondary" size="sm" @click.prevent="resetFilters">
                                            Réinitialiser
                                        </Button>
                                    </div>
                                </form>
                                <Button class="ml-auto" @click="downloadPdf">
                                    Exporter
                                </Button>
                            </div>


                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Date</TableHead>
                                        <TableHead>Heures d'utilisation</TableHead>
                                        <TableHead>Nombre de cycles</TableHead>
                                        <TableHead>Opérateur</TableHead>
                                        <TableHead>Zone</TableHead>
                                        <TableHead>Engin</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>

                                    <template v-for="usage in props.daily_usages.data" :key="usage.id">
                                        <TableRow>
                                            <TableCell>{{ usage.date_usage }}</TableCell>
                                            <TableCell>{usage.heuresUtilisation}h</TableCell>
                                            <TableCell>{usage.nombreCycles}</TableCell>
                                            <TableCell>{{ usage.operateur?.name }}</TableCell>
                                            <TableCell>{{ usage.site_destination }}</TableCell>
                                            <TableCell>{{ usage.engin?.numero_serie }}</TableCell>
                                        </TableRow>
                                    </template>

                                </TableBody>
                            </Table>
                            <div class="flex items-center m-2">
                                <Pagination :meta="props.daily_usages.meta" page-name="daily_usages_page"
                                    :route-params="{ engin: props.engin.id }" :only="['daily_usages']" />
                            </div>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>




        </div>
    </AppLayout>
</template>