<template>
    <ul role="list" class="flex flex-col gap-4">
        <li class="min-w-[400px]"><h3>Below are a list of Response Types to Choose from</h3></li>

        <li v-for="(item, itemIdx) in response_types" :key="itemIdx" class="flow-root">
            <div class="relative -m-2 flex  items-center space-x-4 rounded-xl p-2 ">
                <div :class="[item.background, 'flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg']">
                    <GetIcon :icon="item.icon"/>
                </div>
                <div class="min-w-[400px]">
                    <h3 class="text-sm font-medium text-gray-900">
                        <div  class="focus:outline-none flex justify-between items-center">
                            <div class="absolute inset-0" aria-hidden="true" />
                            <div>
                              {{ item.title }}</div>
                            <Link
                                v-if="item.route"
                                :href="item.route"
                                aria-hidden="true"> &rarr;</Link>
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
import GetIcon from "@/Components/GetIcon.vue";


const props = defineProps({
    response_types: Object,
    outbound: Object
})







</script>

