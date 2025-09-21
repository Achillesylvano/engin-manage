<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { User, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3'
import { getStatusColorClasses } from '@/lib/utils';
import Pagination from '@/components/Pagination.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Liste des utilisateur',
        href: '/users',
    },
];

const props = defineProps<{
    users: {
        data: Array<User>
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


const destroy = (id: number) => {
    if (confirm('Voulez vous vraiment supprimer cette user')) {
        router.delete(route('users.delete', id), {
            preserveScroll: true,
        });
    }
}
</script>
<template>

    <Head title="Liste des utilisateurs" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="flex justify-end m-6">
                    <Button>
                        <Link :href="route('users.create')" class="btn-primary">Nouveau utilisateur</Link>
                    </Button>
                </div>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>
                                Matricule
                            </TableHead>
                            <TableHead>
                                Nom
                            </TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Role</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-for="user in props.users.data" :key="user.id">
                            <TableRow>
                                <TableCell class="font-medium">
                                    {{ user.matricule }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ user.name }}
                                </TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell><span
                                        class="mr-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="getStatusColorClasses(user.role_color)">{{ user.role }}</span>
                                </TableCell>
                                <TableCell class="text-right space-x-2">
                                    <Button variant="outline" size="sm">
                                        <Link :href="route('users.edit', user.id)">Modifier</Link>
                                    </Button>
                                    <Button variant="destructive" size="sm" @click="destroy(user.id)">
                                        Supprimer
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
            <div class="flex justify-center m-2">
                <Pagination :meta="props.users.meta" :only="['users']" />
            </div>
        </div>
    </AppLayout>
</template>