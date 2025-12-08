<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                Dashboard
                </Link>
                <template v-else>
                    <Link :href="route('login')"
                        class="inline-block mt-4 px-6 py-2 bg-green-700 text-white text-sm font-medium rounded-lg shadow hover:bg-green-800 transition">
                    Accéder à la plateforme
                    </Link>
                </template>
            </nav>
        </header>
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main
                class="flex w-full max-w-5xl min-h-[480px] flex-col-reverse items-stretch overflow-hidden rounded-2xl shadow-lg lg:flex-row transition-all duration-300 bg-white dark:bg-[#111]">
                <section class="flex flex-1 flex-col justify-center gap-6 p-8 lg:p-16 text-gray-700 dark:text-gray-200">
                    <header>
                        <h1 class="text-2xl lg:text-3xl font-bold text-green-700 dark:text-[#6de3a6] mb-3">
                            Système de Gestion des Engins Portuaires
                        </h1>
                        <p class="text-base leading-relaxed text-gray-600 dark:text-gray-400">
                            Plateforme intégrée de la <strong class="text-green-600 dark:text-[#8df5bd]">Société de
                                Manutention
                                des Marchandises Conventionnelles (SMMC)</strong>
                            assurant un suivi en temps réel des engins portuaires.
                        </p>
                    </header>
                </section>
                <section class="relative w-full lg:w-[420px] bg-[#e6f8ef] dark:bg-[#0a2a1a] overflow-hidden">
                    <img src="/welcome.jpg" alt="Engins portuaires modernes au port de Toamasina"
                        class="w-full h-full object-cover scale-105 hover:scale-110 transition-transform duration-700" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </section>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
