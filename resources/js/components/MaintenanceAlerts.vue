<script setup lang="ts">
import { ref } from 'vue'

interface Alert {
    id: number
    equipmentName: string
    type: 'hours' | 'km'
    currentValue: number
    threshold: number
    model: string
    serialNumber: string
    location: string
    lastMaintenance: string
    urgency: 'high' | 'medium' | 'low'
}

const alerts = ref<Alert[]>([
    {
        id: 1,
        equipmentName: 'Excavatrice CAT 320D',
        type: 'hours',
        currentValue: 2850,
        threshold: 2500,
        model: 'CAT 320D',
        serialNumber: 'CAT123456',
        location: 'Chantier Nord',
        lastMaintenance: '15/02/2024',
        urgency: 'high'
    },
    {
        id: 2,
        equipmentName: 'Camion Renault Premium',
        type: 'km',
        currentValue: 185000,
        threshold: 180000,
        model: 'Premium 460',
        serialNumber: 'REN789012',
        location: 'Dépôt Central',
        lastMaintenance: '28/01/2024',
        urgency: 'medium'
    },
    {
        id: 3,
        equipmentName: 'Chargeuse Volvo L60H',
        type: 'hours',
        currentValue: 4200,
        threshold: 4000,
        model: 'L60H',
        serialNumber: 'VOL345678',
        location: 'Carrière Sud',
        lastMaintenance: '10/01/2024',
        urgency: 'high'
    },
    {
        id: 4,
        equipmentName: 'Bulldozer Komatsu D65',
        type: 'hours',
        currentValue: 1580,
        threshold: 1500,
        model: 'D65EX-18',
        serialNumber: 'KOM901234',
        location: 'Chantier Est',
        lastMaintenance: '20/02/2024',
        urgency: 'low'
    },
    {
        id: 5,
        equipmentName: 'Grue Liebherr LTM 1055',
        type: 'hours',
        currentValue: 3100,
        threshold: 3000,
        model: 'LTM 1055-3.2',
        serialNumber: 'LIE567890',
        location: 'Chantier Centre',
        lastMaintenance: '05/02/2024',
        urgency: 'medium'
    }
])

const planMaintenance = (alert: Alert) => {
    console.log(`Planification de maintenance pour ${alert.equipmentName}`)
    // Ici vous pouvez ajouter la logique pour ouvrir un modal ou naviguer vers une page de planification
}

const getUrgencyColor = (urgency: string) => {
    switch (urgency) {
        case 'high':
            return 'border-l-danger-500 bg-danger-50'
        case 'medium':
            return 'border-l-warning-500 bg-warning-50'
        case 'low':
            return 'border-l-primary-500 bg-primary-50'
        default:
            return 'border-l-gray-500 bg-gray-50'
    }
}

const getUrgencyBadge = (urgency: string) => {
    switch (urgency) {
        case 'high':
            return 'bg-danger-500 text-white'
        case 'medium':
            return 'bg-warning-500 text-white'
        case 'low':
            return 'bg-primary-500 text-white'
        default:
            return 'bg-gray-500 text-white'
    }
}

const getUrgencyText = (urgency: string) => {
    switch (urgency) {
        case 'high':
            return 'URGENT'
        case 'medium':
            return 'MODÉRÉ'
        case 'low':
            return 'FAIBLE'
        default:
            return 'NORMAL'
    }
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- En-tête -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Alertes de Maintenance</h1>
                <p class="text-gray-600">Équipements nécessitant une maintenance préventive</p>
                <div class="mt-4 flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-danger-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Urgent</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-warning-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Modéré</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-primary-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Faible</span>
                    </div>
                </div>
            </div>

            <!-- Liste des alertes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div v-for="alert in alerts" :key="alert.id" :class="[
                    'bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 border-l-4 overflow-hidden',
                    getUrgencyColor(alert.urgency)
                ]">
                    <!-- Badge d'urgence -->
                    <div class="px-6 pt-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-1">
                                    {{ alert.equipmentName }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ alert.model }}</p>
                            </div>
                            <span :class="[
                                'px-3 py-1 text-xs font-semibold rounded-full',
                                getUrgencyBadge(alert.urgency)
                            ]">
                                {{ getUrgencyText(alert.urgency) }}
                            </span>
                        </div>
                    </div>

                    <!-- Message d'alerte -->
                    <div class="px-6 pb-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <p class="text-yellow-800 text-sm font-medium">
                                    Seuil de {{ alert.type === 'hours' ? 'compteur horaire' : 'kilométrage' }} atteint !
                                </p>
                            </div>
                            <p class="text-yellow-700 text-sm mt-1">
                                Une maintenance préventive doit être planifiée immédiatement.
                            </p>
                        </div>

                        <!-- Informations détaillées -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="space-y-2">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        {{ alert.type === 'hours' ? 'Heures actuelles' : 'Kilométrage actuel' }}
                                    </span>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ alert.currentValue.toLocaleString() }}{{ alert.type === 'hours' ? 'h' : ' km'
                                        }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Seuil</span>
                                    <p class="text-sm text-gray-700">
                                        {{ alert.threshold.toLocaleString() }}{{ alert.type === 'hours' ? 'h' : ' km' }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">N° de
                                        série</span>
                                    <p class="text-sm text-gray-700">{{ alert.serialNumber }}</p>
                                </div>
                                <div>
                                    <span
                                        class="text-xs font-medium text-gray-500 uppercase tracking-wide">Localisation</span>
                                    <p class="text-sm text-gray-700">{{ alert.location }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dernière maintenance -->
                        <div class="mb-4">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Dernière
                                maintenance</span>
                            <p class="text-sm text-gray-700">{{ alert.lastMaintenance }}</p>
                        </div>

                        <!-- Bouton de planification -->
                        <button @click="planMaintenance(alert)"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Planifier une maintenance
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Résumé des alertes</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-danger-50 rounded-lg">
                        <div class="text-2xl font-bold text-danger-600">
                            {{alerts.filter(a => a.urgency === 'high').length}}
                        </div>
                        <div class="text-sm text-danger-700">Urgentes</div>
                    </div>
                    <div class="text-center p-4 bg-warning-50 rounded-lg">
                        <div class="text-2xl font-bold text-warning-600">
                            {{alerts.filter(a => a.urgency === 'medium').length}}
                        </div>
                        <div class="text-sm text-warning-700">Modérées</div>
                    </div>
                    <div class="text-center p-4 bg-primary-50 rounded-lg">
                        <div class="text-2xl font-bold text-primary-600">
                            {{alerts.filter(a => a.urgency === 'low').length}}
                        </div>
                        <div class="text-sm text-primary-700">Faibles</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-600">{{ alerts.length }}</div>
                        <div class="text-sm text-gray-700">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Animations personnalisées */
.hover\\:shadow-lg:hover {
    transform: translateY(-2px);
}

/* Scrollbar personnalisée si nécessaire */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>