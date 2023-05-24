<template>
    <h2 class="flex justify-start items-center font-semibold text-xl text-gray-800 leading-tight mb-2">
        Project: <span class="text-gray-500">{{ project.name }}</span>
        <Link :href="route('projects.edit', {
                    project: project.id
                })">
            <PencilIcon class="w-3 h-3 ml-2 "/>
        </Link>
    </h2>
    <div class="flex justify-start items-center gap-4">
        <div class="flex justify-start items-center gap-2">Active: <Active :active="project.active"/></div>
        <div
            v-if="usePage().props.features.share"
            class="flex justify-start items-center gap-2">Share on Web: <Active :active="project.web_page"/></div>
        <div class="flex justify-start items-center gap-2">Document Count:
            <span class="text-gray-500">{{ project.documents_count }}</span>
        </div>
        <div v-if="project.web_page && usePage().props.features.share" class="flex justify-start items-center gap-2">Web URL:
            <a :href="project.slug_formatted" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>

        <div
            v-if="project.private && project.web_page && usePage().props.feature_flags?.private_web" class="flex justify-start items-center gap-2 ">
            <div
                @click="hidePassword = !hidePassword"
                class="underline hover:cursor-pointer">
                Password Protected:
            </div>
            <span v-if="hidePassword" class="text-gray-500">
                        🔐
                    </span>
            <span v-else class="text-gray-400">{{ project.meta_data?.password }}</span>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import { PencilIcon} from "@heroicons/vue/24/solid"
import { usePage, Link, Head } from "@inertiajs/vue3";
import Active from "@/Components/Active.vue";

const props = defineProps({
    project: Object,
})

const hidePassword = ref(true)
</script>

<style scoped>

</style>
