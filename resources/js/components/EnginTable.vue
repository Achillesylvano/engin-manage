<script setup lang="ts">
import { getStatusColorClasses } from '@/lib/utils';


type TypeEngin = {
    id: number;
    nom: string;
};
const props = defineProps<{
    engins: Array<{
        id: number
        numero_serie: string
        marque: string
        etat: string
        etat_color: string
        type_carburant_label: string
        compteur_h: number
        compteur_km: number
        capacite_reservoir: number
        date_acquisition: string
        modele: string
        type_engin: TypeEngin | null;
        designation: string;
        etat_label: string;
    }>
}>();
</script>
<template>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-primary">
        <thead class="bg-primary">
          <tr>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nom</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Marque/Modèle</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Type</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">N° Série</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Carburant</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Utilisation</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Acquisition</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Réservoir</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-primary-100">
          <tr 
            v-for="(engin, index) in props.engins" 
            :key="engin.id"
            :class="index % 2 === 0 ? 'bg-white' : 'bg-primary-25'"
            class="hover:bg-primary-50 transition-colors duration-150"
          >
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-semibold text-primary-800">{{ engin.designation }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-gray-900 font-medium">{{ engin.marque }}</div>
              <div class="text-gray-500 text-sm">{{ engin.modele }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                {{ engin.type_engin?.nom}}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-gray-900 font-mono text-sm">{{ engin.numero_serie }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-gray-900">{{ engin.type_carburant_label }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm">
                <div class="text-gray-900 font-semibold">{{ engin.compteur_h }}</div>
                <div class="text-gray-500">{{ engin.compteur_km }}</div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-gray-900">{{ engin.date_acquisition }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-gray-900 font-semibold">{{ engin.capacite_reservoir }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <button 
                @click="false"
                class="btn-primary text-sm"
              >
                Voir plus
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>