<template>
    <div class="p-2">
        <h2 class="text-base font-semibold leading-6 text-gray-900 flex items-center">
            <ArrowUpRightIcon class="w-5 h-5 text-gray-500"/>
            <div class="ml-2">Outbounds</div>
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Now to get to your data! You can use the Chat box above if you enable the "ChatUI Outbound" or you can add others like "API"
        </p>

        <div class="min-h-[150px]">
            <h3 class="text-gray-500 font-semibold">Outbounds related to this Project</h3>
            <ExistingOutbounds :project="project"/>
        </div>

        <ul role="list" class="mt-6 grid grid-cols-1 gap-6 border-b border-t border-gray-200 py-6 sm:grid-cols-2">
            <li v-for="(item, itemIdx) in items" :key="itemIdx" class="flow-root">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50">
                    <div :class="`flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg ${item.background}`">
                        <PhoneIcon v-if="item.icon === 'PhoneIcon'" class="bg-green-500 h-6 w-6 text-white"/>
                        <ChatBubbleLeftIcon v-if="item.icon === 'ChatBubbleLeftIcon'" class="bg-sky-500 h-6 w-6 text-white"/>
                        <ArrowsRightLeftIcon v-if="item.icon === 'ArrowsRightLeftIcon'" class="bg-red-700 h-6 w-6 text-white"/>
                        <ArrowDownTrayIcon v-if="item.icon === 'ArrowDownTrayIcon'" class="h-6 w-6 text-white"/>
                        <DocumentIcon v-if="item.icon === 'DocumentIcon'" class="bg-blue-500 h-6 w-6 text-white"/>
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
    PhoneIcon,
    ArrowDownTrayIcon,
    ArrowUpRightIcon,
    ChatBubbleLeftIcon,
    ArrowsRightLeftIcon,
    ArrowsPointingInIcon,
    DocumentIcon,
    ClockIcon,
    TableCellsIcon,
    ViewColumnsIcon,
} from '@heroicons/vue/24/outline'
import {Link, useForm} from "@inertiajs/vue3"
import {useToast} from "vue-toastification";
import ExistingOutbounds from "./ExistingOutbounds.vue";
const toast = useToast();

const props = defineProps({
    items: Array,
    project: Object
})

</script>
