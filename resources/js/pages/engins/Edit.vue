<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/engins/Layout.vue';
import { Engin, type BreadcrumbItem } from '@/types';
import { LoaderCircle } from 'lucide-vue-next';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

const props = defineProps<{
    engin: Engin,
    types_engin:
    {
        data: Array<{
            id: number,
            nom: string,
        }>
    };
    etats: Record<string, string>;
    type_carburants: Record<string, string>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Modifier un Engin',
        href: `/engins/${props.engin.id}/edit`,
    },
];

const form = useForm({
    designation: props.engin.designation,
    type_engin_id: props.engin.type_engin?.id,
    marque: props.engin.marque,
    modele: props.engin.modele,
    numero_serie: props.engin.numero_serie,
    compteur_h: props.engin.compteur_h,
    compteur_km: props.engin.compteur_km,
    etat: props.engin.etat,
    type_carburant: props.engin.type_carburant,
    date_acquisition: props.engin.date_acquisition,
    capacite_reservoir: props.engin.capacite_reservoir,
});

const submit = () => {
    form.put(route('engins.update', props.engin.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Modifier l'engin" />

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
                                    <Input id="designation" class="mt-1 block w-full" v-model="form.designation"
                                        required autocomplete="designation" placeholder="Désignation" />
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
                                    <Input id="capacite_reservoir" class="mt-1 block w-full"
                                        v-model="form.capacite_reservoir" required placeholder="0,00" />
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
                                <div class="col-span-2 flex items-center gap-4">
                                    <Button type="submit" tabindex="5" :disabled="form.processing">
                                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                        Save
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
