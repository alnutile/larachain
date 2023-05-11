<template>
    <div>
        <h2 class="text-base font-semibold leading-6 text-gray-900 flex items-center">
            <ArrowsPointingInIcon class="w-5 h-5 text-gray-500"/>
            <div class="ml-2">Sources</div>
        </h2>
        <p class="mt-1 text-sm text-gray-500">You have not added a Source yet. Get started by adding a source of data, see options below</p>

        <div>
            <h3 class="text-gray-500 font-semibold">Sources related to this Project</h3>
            <div v-if="project.sources">
                <ul>
                    <li v-for="source in project.sources" :key="source.id" class="mt-1 border border-gray-200 p-4 shadow hover:bg-gray-50 hover:cursor-pointer">
                        <div class="text-sm">
                            {{ source.name }} <span aria-hidden="true"> &rarr;</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            {{source.meta_data.url}}
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else class="text-gray-400">👇Choose a Source below to get started</div>
        </div>

        <ul role="list" class="mt-6 grid grid-cols-1 gap-6 border-b border-t border-gray-200 py-6 sm:grid-cols-2">
            <li v-for="(item, itemIdx) in items" :key="itemIdx" class="flow-root">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50">
                    <div :class="[item.background, 'flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg']">
                        <ArrowDownTrayIcon v-if="item.icon === 'ArrowDownTrayIcon'" class="h-6 w-6 text-white"/>
                        <ClockIcon v-else class="h-6 w-6 text-white"/>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <Link :href="route(item.route, {
                                project: project.id
                            })" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true" />
                                <span>
                                    {{ item.name }}</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </Link>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ item.description }}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {
    Bars4Icon,
    ArrowDownTrayIcon,
    ArrowsPointingInIcon,
    CalendarIcon,
    ClockIcon,
    PhotoIcon,
    TableCellsIcon,
    ViewColumnsIcon,
} from '@heroicons/vue/24/outline'
import { Link } from "@inertiajs/vue3"

const props = defineProps({
    items: Array,
    project: Object
})
</script>
