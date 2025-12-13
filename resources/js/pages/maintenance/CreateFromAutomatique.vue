<script setup lang="ts">
import { Head, useForm, } from '@inertiajs/vue3';

// import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/engins/Layout.vue';
import { AlertMaintenance, User, type BreadcrumbItem } from '@/types';
import { LoaderCircle } from 'lucide-vue-next';
import { Textarea } from '@/components/ui/textarea'

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
    CardHeader,
    CardTitle,
} from '@/components/ui/card'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Planifier une maintenance',
        href: '/maintenances/create',
    },
];

const props = defineProps<{
    alertMaintenance: AlertMaintenance,
    techniciens: {
        data: Array<User>
    }
}>();

const form = useForm<{
    type: string;
    description: string;
    date_planifiee: string;
    statut: string;
    engin_id: number;
    technicien_id?: number;
    incident_id?: number;
    alert_maintenance_id?: number
    maintenance_automatique_id?: number

}>({
    type: 'préventive',
    description: props.alertMaintenance.maintenance_automatique.description,
    date_planifiee: '',
    statut: 'planifiee',
    engin_id: props.alertMaintenance.engin_id,
    technicien_id: undefined,
    incident_id: undefined,
    alert_maintenance_id: props.alertMaintenance.id,
    maintenance_automatique_id: props.alertMaintenance.maintenance_automatique_id
});

const submit = () => {
    form.post(route('maintenances.store'), {
        preserveScroll: true,
    });
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
                            <CardTitle>Détail de la maintenance</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid gap-2">
                                    <Label for="nom">Type de maintenance</Label>
                                    <Input id="designation" class="mt-1 block w-full" v-model="form.type" required
                                        autocomplete="designation" placeholder="Désignation" />
                                    <InputError class="mt-2" :message="form.errors.type" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="nom">Statut</Label>
                                    <Input id="designation" class="mt-1 block w-full" v-model="form.statut" required
                                        autocomplete="designation" placeholder="Désignation" />
                                    <InputError class="mt-2" :message="form.errors.statut" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="date_aquisition">Date Planifiée</Label>
                                    <Input id="date_aquisition" type="date" class="mt-1 block w-full"
                                        v-model="form.date_planifiee" required autocomplete="date_aquisition" />
                                    <InputError class="mt-2" :message="form.errors.date_planifiee" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="type">Technicien</Label>
                                    <Select v-model="form.technicien_id">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Selectinner un technicien" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <template v-for="technicien in props.techniciens.data"
                                                    :key="technicien.id">
                                                    <SelectItem :value="technicien.id">
                                                        {{ technicien.name }}
                                                    </SelectItem>
                                                </template>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError class="mt-2" :message="form.errors.technicien_id" />
                                </div>
                                <div class="col-span-full flex flex-col gap-2">
                                    <Label for="description">Description</Label>
                                    <Textarea id="description" placeholder="Description de la maintenance"
                                        v-model="form.description" />
                                    <InputError class="mt-2" :message="form.errors.description" />
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
