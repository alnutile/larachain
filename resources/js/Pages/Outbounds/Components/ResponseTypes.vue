<template>
    <ul role="list" class="flex flex-col gap-4">
        <li v-for="(item, itemIdx) in activeResponseTypes" :key="itemIdx" class="flow-root">
            <div class="relative -m-2 flex  items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50">

                <div :class="[item.background, 'flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg']">
                    <component :is=item.icon class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <div class="min-w-[400px]">
                    <h3 class="text-sm font-medium text-gray-900">
                        <div  class="focus:outline-none flex justify-between items-center">
                            <div class="absolute inset-0" aria-hidden="true" />
                            <div>
                              {{ item.title }}</div>
                            <Link

                                v-if="item.route === 1" aria-hidden="true"> &rarr;</Link>
                        </div>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ item.description }}</p>
                </div>
            </div>
        </li>
    </ul>
</template>

<script setup>

import { useForm, Link } from "@inertiajs/vue3";
import {
    Bars4Icon,
    ArrowDownTrayIcon,
    ChatBubbleLeftIcon,
    ArrowsPointingInIcon,
    CalendarIcon,
    ClockIcon,
    PhotoIcon,
    TableCellsIcon,
    ViewColumnsIcon,
    MegaphoneIcon,
    MagnifyingGlassIcon
} from '@heroicons/vue/24/outline'

import {computed, onMounted} from "vue";
import collect from 'collect.js';

const props = defineProps({
    response_types: Object
})
const iconComponents = {
    Bars4Icon,
    ArrowDownTrayIcon,
    ChatBubbleLeftIcon,
    ArrowsPointingInIcon,
    CalendarIcon,
    ClockIcon,
    PhotoIcon,
    TableCellsIcon,
    ViewColumnsIcon,
    MegaphoneIcon,
    MagnifyingGlassIcon
};

const activeResponseTypes = computed(() => {
    return collect(props.response_types)
        .filter((value) => value.active === 1)
        .map((value) => {
            const iconComponent = iconComponents[value.icon];
            value.icon = iconComponent;
            return value;
        })
        .toArray();
});
</script>

