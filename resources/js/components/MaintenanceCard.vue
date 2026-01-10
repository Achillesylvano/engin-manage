<script lang="ts" setup>
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import type { Maintenance } from '@/types';

const props = defineProps<{ maintenance: Maintenance }>();
function getStatusClass(statut: string): string {
    switch (statut) {
        case 'planifiee':
            return 'status-planifiee';
        case 'en cours':
            return 'status-en-cours';
        case 'terminee':
            return 'status-terminee';
        case 'annulee':
            return 'status-annulee';
        default:
            return '';
    }
}

function getTypeClass(type: string): string {
    return type === 'préventive' ? 'type-preventive' : 'type-corrective';
}

function formatStatut(statut: string): string {
    switch (statut) {
        case 'planifiee':
            return 'Planifiée';
        case 'en cours':
            return 'En cours';
        case 'terminee':
            return 'Terminée';
        case 'annulee':
            return 'Annulée';
        default:
            return statut;
    }
}
</script>

<template>
    <Card class="glass-card hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
        <CardHeader class="pb-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="sw-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>

                    </div>
                    <div>
                        <h3 class="font-semibold text-foreground">{{ props.maintenance.engin?.designation }}</h3>
                        <p class="text-xs text-muted-foreground font-mono">{{ props.maintenance.engin?.numero_serie }}
                        </p>
                    </div>
                </div>
                <span class="font-mono text-xs text-muted-foreground">
                    #{{ props.maintenance.id }}
                </span>
            </div>
        </CardHeader>

        <CardContent class="space-y-4">
            <p class="text-sm text-foreground/80 line-clamp-2">{{ props.maintenance.description }}</p>

            <div class="flex flex-wrap gap-2">
                <span :class="['status-badge', getTypeClass(props.maintenance.type)]">
                    {{ props.maintenance.type.charAt(0).toUpperCase() + props.maintenance.type.slice(1) }}
                </span>
                <span :class="['status-badge', getStatusClass(props.maintenance.statut)]">
                    {{ formatStatut(props.maintenance.statut) }}
                </span>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-border/50">
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 text-muted-foreground">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>

                    <span class="text-foreground">{{ props.maintenance.date_planifiee }}</span>
                </div>

                <div v-if="props.maintenance.technicien" class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-primary/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </div>
                    <span class="text-xs text-muted-foreground">{{ props.maintenance.technicien.name }}</span>
                </div>
                <span v-else class="text-xs text-muted-foreground italic">Non assigné</span>
            </div>
        </CardContent>
    </Card>

</template>