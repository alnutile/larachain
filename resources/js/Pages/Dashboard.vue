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

                            <Block>
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 stroke-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </template>
                                <template #title_link>
                                    <a href="https://github.com/alnutile/larachain/wiki" target="_blank">Wiki</a>
                                </template>
                                <template #description>
                                    All the latest docs for you to learn the how and the why.
                                </template>
                                <template #exit_link>
                                    <a href="https://github.com/alnutile/larachain/wiki" target="_blank" class="inline-flex items-center font-semibold text-indigo-700">
                                        Wiki

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </template>
                            </Block>
                            <Block>
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 stroke-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                    </svg>

                                </template>
                                <template #title_link>
                                    <a href="https://github.com/users/alnutile/projects/2/views/1" target="_blank">Issue Board</a>
                                </template>
                                <template #description>
                                    See the planning and issues on GitHub. Help with any or submit some ideas and bugs.
                                </template>
                                <template #exit_link>
                                    <a href="https://github.com/users/alnutile/projects/2/views/1" target="_blank" class="inline-flex items-center font-semibold text-indigo-700">
                                        Issue Board
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </template>
                            </Block>
                            <Block>
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 stroke-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                    </svg>

                                </template>
                                <template #title_link>
                                    <a href="https://github.com/alnutile/larachain" target="_blank">GitHub Code</a>
                                </template>
                                <template #description>
                                    {{ usePage().props.app_name }} is Open-Source. You can download it, fix it, read the code, self host etc!
                                </template>
                                <template #exit_link>
                                    <a href="https://github.com/alnutile/larachain" target="_blank" class="inline-flex items-center font-semibold text-indigo-700">
                                        GitHub Code
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </template>
                            </Block>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
