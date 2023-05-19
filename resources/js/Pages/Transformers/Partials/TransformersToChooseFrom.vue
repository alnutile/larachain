<template>
    <div class="p-2">
        <h2 class="text-base font-semibold leading-6 text-gray-900 flex items-center">
            <ArrowsRightLeftIcon class="w-5 h-5 text-gray-500"/>
            <div class="ml-2">Transformers</div>
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Once you have a source of data you can add Transformers 🤖 to modify the data. For example "Vectorize the data"
        </p>

        <div class="min-h-[150px]">
            <h3 class="text-gray-500 font-semibold">Transformers related to this Project</h3>
            <ExistingTransformers :project="project"/>
        </div>

        <ul role="list" class="mt-6 grid grid-cols-1 gap-6 border-b border-t border-gray-200 py-6 sm:grid-cols-2">
            <li v-for="(item, itemIdx) in items" :key="itemIdx" class="flow-root">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50">
                    <div :class="`flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg ${item.background}`">
                        <GetIcon :icon="item.icon"></GetIcon>
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
import GetIcon from "@/Components/GetIcon.vue";
import {
    Bars4Icon,
    ArrowDownTrayIcon,
    ArrowsRightLeftIcon,
    ArrowsPointingInIcon,
    DocumentIcon,
    ClockIcon,
    TableCellsIcon,
    ViewColumnsIcon,
} from '@heroicons/vue/24/outline'
import {Link, useForm} from "@inertiajs/vue3"
import {useToast} from "vue-toastification";
import ExistingTransformers from "./ExistingTransformers.vue";
const toast = useToast();

const props = defineProps({
    items: Array,
    project: Object
})

</script>
