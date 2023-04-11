<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Block from '@/Pages/Partials/Block.vue';
import { usePage, Link } from "@inertiajs/vue3";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                                Welcome to {{ usePage().props.app_name }}
                            </h1>

                            <p class="mt-6 text-gray-500 leading-relaxed">
                                Built on Laravel it will provide a foundation to building systems around OpenAI API/ChatGPT.
                            </p>
                        </div>

                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

                            <Block>
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 stroke-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>

                                </template>
                                <template #title_link>
                                    <Link :href="route('projects.index')">Projects</Link>
                                </template>
                                <template #description>
                                    Here are your Projects. You can create one to then start importing or sending your data to
                                    {{ usePage().props.app_name }}.
                                </template>
                                <template #exit_link>
                                    <Link :href="route('projects.index')" class="inline-flex items-center font-semibold text-indigo-700">
                                        Projects
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                                        </svg>
                                    </Link>
                                </template>
                            </Block>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
