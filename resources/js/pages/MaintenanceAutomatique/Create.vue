-- Active: 1752564748939@@127.0.0.1@3306
<script setup lang="ts">
import { Head, useForm, } from '@inertiajs/vue3';

// import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/engins/Layout.vue';
import { Engin, type BreadcrumbItem } from '@/types';
import { LoaderCircle } from 'lucide-vue-next';
import { Textarea } from '@/components/ui/textarea'
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Programmer une maintenance',
        href: '/maintenances/create',
    },
];

const props = defineProps<{
    engin: Engin
}>();


const formHoraire = useForm<{
    engin_id: number,
    type: string,
    description: string,
    dernier_compteur: number,
    seuil: number,
}>({
    engin_id: props.engin.id,
    type: 'horaire',
    description: '',
    dernier_compteur: props.engin.compteur_h,
    seuil: 0,
});

const formKm = useForm<{
    engin_id: number,
    type: string,
    description: string,
    dernier_compteur: number,
    seuil: number,
}>({
    engin_id: props.engin.id,
    type: 'km',
    description: '',
    dernier_compteur: props.engin.compteur_km,
    seuil: 0,
});

const submitHoraire = () => {
    formHoraire.post(route('maintenance-automatiques.store'));
};
const submitKm = () => {
    formKm.post(route('maintenance-automatiques.store'));
};



</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Maintenance automatique
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Programmer la maintenance selon le seuil de l’engin
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="$page.props.flash.success"
                class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300 text-center">
                {{ $page.props.flash.success }}
            </div>

            <Tabs default-value="horaire">
                <TabsList class="grid w-full grid-cols-2">
                    <TabsTrigger value="horaire" class="flex items-center gap-2">
                        Horaire
                    </TabsTrigger>
                    <TabsTrigger value="km" class="flex items-center gap-2">
                        Kilométrique
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="horaire">

                    <div class="flex flex-col space-y-6 w-full">
                        <form id="form-horaire" @submit.prevent="submitHoraire">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Maintenance basée sur le compteur horaire</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="grid gap-2">
                                            <Label for="compteur_heures">Seuil compteur (heures)</Label>
                                            <Input id="compteur_heures" class="mt-1 block w-full"
                                                v-model="formHoraire.seuil" required placeholder="0,00" />
                                            <InputError class="mt-2" :message="formHoraire.errors.seuil" />
                                        </div>
                                        <div class="grid gap-2">
                                            <Label for="compteur_heures">Compteur actuel (heures)</Label>
                                            <Input disabled id="compteur_heures" class="mt-1 block w-full"
                                                v-model="formHoraire.dernier_compteur" required />
                                            <InputError class="mt-2" :message="formHoraire.errors.dernier_compteur" />
                                        </div>
                                        <div class="col-span-full flex flex-col gap-2">
                                            <Label for="description">Description</Label>
                                            <Textarea id="description" placeholder="Description de la maintenance"
                                                v-model="formHoraire.description" />
                                            <InputError class="mt-2" :message="formHoraire.errors.description" />
                                        </div>
                                        <div class="col-span-full flex flex-col gap-2">
                                            <InputError class="mt-2" :message="formHoraire.errors.type" />
                                        </div>
                                        <div class="col-span-2 flex items-center gap-4">
                                            <Button type="submit" tabindex="5" :disabled="formHoraire.processing">
                                                <LoaderCircle v-if="formHoraire.processing"
                                                    class="h-4 w-4 animate-spin" />
                                                Save
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </form>
                    </div>
                </TabsContent>
                <TabsContent value="km">
                    <div class="flex flex-col space-y-6 w-full">
                        <form id="form-km" @submit.prevent="submitKm">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Maintenance basée sur le compteur horaire</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="grid gap-2">
                                            <Label for="compteur_heures">Seuil compteur (km)</Label>
                                            <Input id="compteur_heures" class="mt-1 block w-full" v-model="formKm.seuil"
                                                required />
                                            <InputError class="mt-2" :message="formKm.errors.seuil" />
                                        </div>
                                        <div class="grid gap-2">
                                            <Label for="compteur_heures">Compteur actuel (km)</Label>
                                            <Input disabled id="compteur_heures" class="mt-1 block w-full"
                                                v-model="formKm.dernier_compteur" required />
                                            <InputError class="mt-2" :message="formKm.errors.dernier_compteur" />
                                        </div>
                                        <div class="col-span-full flex flex-col gap-2">
                                            <Label for="description">Description</Label>
                                            <Textarea id="description" placeholder="Description de la maintenance"
                                                v-model="formKm.description" />
                                            <InputError class="mt-2" :message="formKm.errors.description" />
                                        </div>
                                        <div class="col-span-full flex flex-col gap-2">
                                            <InputError class="mt-2" :message="formKm.errors.type" />
                                        </div>
                                        <div class="col-span-2 flex items-center gap-4">
                                            <Button type="submit" tabindex="5" :disabled="formKm.processing">
                                                <LoaderCircle v-if="formKm.processing" class="h-4 w-4 animate-spin" />
                                                Save
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </form>
                    </div>
                </TabsContent>
            </Tabs>
        </SettingsLayout>
    </AppLayout>
</template>
