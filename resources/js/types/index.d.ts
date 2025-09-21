import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    matricule: string;
    role: string;
    role_color: string;
    role_label: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface TypeEngin {
    id: number;
    nom: string;
}

export interface DailyUsage {
    id: number;
    date_usage: string;
    site_destination: string;
    observation_depart: string;
    observation_retour: string;
    heure_sortie: Date;
    heure_retour: string;
    compteur_h_sortie: number;
    compteur_km_sortie: number;
    compteur_h_retour: number;
    compteur_km_retour: number;
    is_returned: boolean;
    engin?: Engin | null;
    operateur?: {
        id: number;
        name: string;
    } | null;
}

export interface Maintenance {
    type: string;
    description: string;
    date_planifiee: string;
    statut: string;
    engin_id: number;
    technicien?: User;
    responsable?: User;
    incident?: Incident | null;
}

interface Engin {
    id: number;
    numero_serie: string;
    marque: string;
    modele: string;
    designation: string;
    etat: string;
    etat_label: string;
    etat_color: string;
    type_carburant_label: string;
    compteur_h: number;
    compteur_km: number;
    capacite_reservoir: number;
    date_acquisition: string;
    type_engin: TypeEngin | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
