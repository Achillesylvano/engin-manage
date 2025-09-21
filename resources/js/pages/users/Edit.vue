<script setup lang="ts">
import { Head, useForm, } from '@inertiajs/vue3';

// import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/engins/Layout.vue';
import { User, type BreadcrumbItem } from '@/types';
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
        title: 'Modifier un utilisateur',
        href: '/users/edit',
    },
];

const props = defineProps<{
    user: User;
    users_role: Record<string, string>;
}>();
console.log(props.user);
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    matricule: props.user.matricule,
    password_confirmation: '',
    role: props.user.role,
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
                            <CardTitle>Information de base</CardTitle>
                            <CardDescription>Détail généraux de l'engin</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid gap-2">
                                    <Label for="name">Name</Label>
                                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                                        v-model="form.name" placeholder="Full name" />
                                    <InputError :message="form.errors.name" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="email">Email address</Label>
                                    <Input id="email" type="email" required :tabindex="2" autocomplete="email"
                                        v-model="form.email" placeholder="email@example.com" />
                                    <InputError :message="form.errors.email" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="role">Rôle</Label>
                                    <Select v-model="form.role">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Selectinner un rôle" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <template v-for="(label, value) in props.users_role" :key="value">
                                                    <SelectItem :value="value">
                                                        {{ label }}
                                                    </SelectItem>
                                                </template>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError class="mt-2" :message="form.errors.role" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="matricule">Matricule</Label>
                                    <Input id="matricule" required :tabindex="2" autocomplete="matricule"
                                        v-model="form.matricule" placeholder="SMMC-####" />
                                    <InputError :message="form.errors.matricule" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <Card class="mt-4">
                        <CardHeader>
                            <CardTitle>Mot de passe</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid gap-2">
                                    <Label for="password">Password</Label>
                                    <Input id="password" type="password" required :tabindex="3"
                                        autocomplete="new-password" v-model="form.password" placeholder="Password" />
                                    <InputError :message="form.errors.password" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="password_confirmation">Confirm password</Label>
                                    <Input id="password_confirmation" type="password" required :tabindex="4"
                                        autocomplete="new-password" v-model="form.password_confirmation"
                                        placeholder="Confirm password" />
                                    <InputError :message="form.errors.password_confirmation" />
                                </div>
                                <div class="col-span-2 flex items-center gap-4">
                                    <Button type="submit" tabindex="5" :disabled="form.processing">
                                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                        Enregistrer
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
