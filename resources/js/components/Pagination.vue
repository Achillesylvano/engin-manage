<script setup lang="ts">
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination'

import { router } from '@inertiajs/vue3'

const props = defineProps<{
    meta: {
        current_page: number
        last_page: number
        total: number
        per_page: number
    }
    only?: string[]
    pageName?: string // nom du paramètre de pagination (par défaut: "page")
    routeParams?: Record<string, any> // paramètres dynamiques de la route (ex: { engin: 5 })
}>()

const emit = defineEmits(['change'])

const goToPage = (page: number) => {
    if (page < 1 || page > props.meta.last_page) return

    const param = props.pageName ?? 'page'

    router.get(
        route(route().current()!, {
            ...(props.routeParams ?? {}), // injecte paramètres dynamiques
            [param]: page, // injecte paramètre de pagination
        }),
        {},
        {
            preserveState: true,
            preserveScroll: false,
            only: props.only ?? [],
        }
    )

    emit('change', page)
}
</script>

<template>
    <Pagination :items-per-page="props.meta.per_page" :total="props.meta.total" :default-page="props.meta.current_page">
        <PaginationContent v-slot="{ items }">
            <PaginationPrevious :disabled="props.meta.current_page === 1"
                @click="goToPage(props.meta.current_page - 1)" />

            <template v-for="(item, index) in items" :key="index">
                <PaginationItem v-if="item.type === 'page'" :value="item.value"
                    :is-active="item.value === props.meta.current_page" @click="goToPage(item.value)">
                    {{ item.value }}
                </PaginationItem>
            </template>

            <PaginationEllipsis :index="4" />

            <PaginationNext :disabled="props.meta.current_page === props.meta.last_page"
                @click="goToPage(props.meta.current_page + 1)" />
        </PaginationContent>
    </Pagination>
</template>
