<script setup lang="ts">
import { Head, useForm, } from '@inertiajs/vue3';

// import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/engins/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { LoaderCircle } from 'lucide-vue-next';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Créer un Engin',
        href: '/engins/create',
    },
];

const props = defineProps<{
    types_engin:
    {
        data: Array<{
            id: number,
            nom: string,
        }>
    },
    etats: Record<string, string>;
    type_carburants: Record<string, string>;
}>();

const form = useForm<{
    designation: string;
    marque: string;
    modele: string;
    numero_serie: string;
    compteur_h: string;
    compteur_km: string;
    seuil_maintenance_h: string;
    seuil_maintenance_km: string;
    capacite_reservoir: string;
    type_carburant: string;
    etat: string;
    image_engin?: File | null;
    date_acquisition: string;
    type_engin_id: number | null;
}>({
    designation: '',
    marque: '',
    modele: '',
    numero_serie: '',
    compteur_h: '',
    compteur_km: '',
    seuil_maintenance_h: '',
    seuil_maintenance_km: '',
    capacite_reservoir: '',
    type_carburant: '',
    etat: '',
    image_engin: null,
    date_acquisition: '',
    type_engin_id: null,
});




const submit = () => {
    form.post(route('engins.store'));
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6 w-full">
                <form @submit.prevent="submit">
                    <Card>
                        <CardHeader>
                            <CardTitle>Information de base</CardTitle>
                            <CardDescription>Détail généraux de l'engin</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid gap-2">
                                    <Label for="designation">Désignation</Label>
                                    <Input id="designation" class="mt-1 block w-full" v-model="form.designation" required
                                        autocomplete="designation" placeholder="Désignation" />
                                    <InputError class="mt-2" :message="form.errors.designation" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="marque">Marque</Label>
                                    <Input id="marque" class="mt-1 block w-full" v-model="form.marque" required
                                        autocomplete="marque" />
                                    <InputError class="mt-2" :message="form.errors.marque" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="modele">Modèle</Label>
                                    <Input id="modele" class="mt-1 block w-full" v-model="form.modele" required
                                        autocomplete="modele" />
                                    <InputError class="mt-2" :message="form.errors.modele" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="numero_serie">N° Serie</Label>
                                    <Input id="numero_serie" class="mt-1 block w-full" v-model="form.numero_serie"
                                        required autocomplete="numero_serie" placeholder="00-000-00" />
                                    <InputError class="mt-2" :message="form.errors.numero_serie" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="type">Type</Label>
                                    <Select v-model="form.type_engin_id">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Sélectionner un type" />
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
                                    <InputError class="mt-2" :message="form.errors.type_engin_id" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="etat">Etat</Label>
                                    <Select v-model="form.etat">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Sélectionner un état" />
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
                                    <InputError class="mt-2" :message="form.errors.etat" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="type_carburant">Type de carburant</Label>
                                    <Select v-model="form.type_carburant">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Sélectionner un type de carburant" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <template v-for="(label, value) in props.type_carburants" :key="value">
                                                    <SelectItem :value="value">
                                                        {{ label }}
                                                    </SelectItem>
                                                </template>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError class="mt-2" :message="form.errors.type_carburant" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="date_aquisition">Date d'acquisition</Label>
                                    <Input id="date_aquisition" type="date" class="mt-1 block w-full"
                                        v-model="form.date_acquisition" required autocomplete="date_aquisition" />
                                    <InputError class="mt-2" :message="form.errors.date_acquisition" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="capacite_reservoir">Capacité du reservoir (L)</Label>
                                    <Input id="capacite_reservoir" class="mt-1 block w-full" v-model="form.capacite_reservoir"
                                        required placeholder="0,00" />
                                    <InputError class="mt-2" :message="form.errors.capacite_reservoir" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="mt-4">
                        <CardHeader>
                            <CardTitle>Compteurs et maintenance</CardTitle>
                            <CardDescription>Heures d'utilisation et seuil de maintenance</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid gap-2">
                                    <Label for="compteur_heures">Compteur heures</Label>
                                    <Input id="compteur_heures" class="mt-1 block w-full" v-model="form.compteur_h"
                                        required placeholder="0,00" />
                                    <InputError class="mt-2" :message="form.errors.compteur_h" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="compteur_kilometres">Compteur kilomètres</Label>
                                    <Input id="compteur_kilometres" class="mt-1 block w-full" v-model="form.compteur_km"
                                        required placeholder="0,00" />
                                    <InputError class="mt-2" :message="form.errors.compteur_km" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="seuil_maintenance_h">Seuil maintenance (heures)</Label>
                                    <Input id="seuil_maintenance_h" class="mt-1 block w-full"
                                        v-model="form.seuil_maintenance_h" required placeholder="0,00" />
                                    <InputError class="mt-2" :message="form.errors.seuil_maintenance_h" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="seuil_maintenance_km">Seuil maintenance (km)</Label>
                                    <Input id="seuil_maintenance_km" class="mt-1 block w-full"
                                        v-model="form.seuil_maintenance_km" required placeholder="0,00" />
                                    <InputError class="mt-2" :message="form.errors.seuil_maintenance_km" />
                                </div>
                                <div class="col-span-2 flex items-center gap-4">
                                    <Button type="submit" tabindex="5" :disabled="form.processing">
                                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                        Save
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <!-- <HeadingSmall title="Engin" description="Creer un nouveaun engin" />-->
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
