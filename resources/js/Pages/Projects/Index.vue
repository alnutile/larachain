<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">

                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">Projects</h1>
                                <p class="mt-2 text-sm text-gray-700">
                                    These are projects related to your current {{ usePage().props.team_label }}
                                    <span class="font-semibold">{{ usePage().props.auth.user.current_team.name}}</span>
                                </p>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <Link
                                    :href="route('projects.create')"
                                     class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                >Add Project</Link>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="grid grid-cols-2">
                                            <div v-for="project in projects.data" :key="project.id" class="overflow-hidden shadow-lg ring-1 ring-black ring-opacity-5 md:rounded-lg ">
                                                <div class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900 text-xl p-2">Project: {{ project.name }}</div>
                                                <div class="p-2">
                                                    <div class="text-sm text-gray-500 flex flex-col text-left justify-start">
                                                        <div class="font-semibold">Source(s):</div>
                                                        <div v-for="source in project.sources">- {{source.name}}: {{ source.type_formatted}}</div>
                                                    </div>
                                                    <div class="text-sm text-gray-500 flex flex-col text-left justify-start">
                                                        <div class="font-semibold">Outbound(s):</div>
                                                        <div v-for="outbound in project.outbounds">- {{ outbound.type_formatted}}</div>
                                                    </div>
                                                    <div class="whitespace-nowrap text-sm text-gray-500 flex justify-start items-center">
                                                        <span class="font-semibold">Active:</span>
                                                        <Active :active="project.active"/>
                                                    </div>
                                                </div>
                                                <div class="
                                                flex gap-4 justify-end items-center
                                                relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <PrimaryButtonLink :href="route('projects.show',
                                                    {project: project.id})" >View</PrimaryButtonLink>
                                                    <Link :href="route('projects.edit',
                                                    {project: project.id})" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                                </div>
                                            </div>
                                    </div>
                                    <SimplePaginate :meta="projects"></SimplePaginate>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Active from "@/Components/Active.vue";
import SimplePaginate from "@/Components/SimplePaginate.vue";
import { Link,usePage } from "@inertiajs/vue3"
import {useToast} from "vue-toastification";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
const toast = useToast();

const props = defineProps({
    projects: Object
})
</script>

<style scoped>

</style>
