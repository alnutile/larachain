<template>
    <AppLayout title="[RESOURCE_PROPER]">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                [RESOURCE_PROPER]
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">

                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">[RESOURCE_PROPER]</h1>
                                <p class="mt-2 text-sm text-gray-700">
                                    Description Here
                                </p>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <Link
                                    :href="route('[RESOURCE_PLURAL_KEY].create')"
                                     class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                >Add [RESOURCE_PROPER]</Link>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Subject</th>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Active</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="[RESOURCE_SINGULAR_KEY] in [RESOURCE_PLURAL_KEY].data" :key="[RESOURCE_SINGULAR_KEY].id">
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ [RESOURCE_SINGULAR_KEY].id }}</td>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ [RESOURCE_SINGULAR_KEY].subject }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <Active :active="[RESOURCE_SINGULAR_KEY].active"/>
                                                </td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <Link :href="route('[RESOURCE_PLURAL_KEY].edit',
                                                    {[RESOURCE_SINGULAR_KEY]: [RESOURCE_SINGULAR_KEY].id})" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <SimplePaginate :meta="[RESOURCE_PLURAL_KEY]"></SimplePaginate>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Active from "@/Components/Active.vue";
import SimplePaginate from "@/Components/SimplePaginate.vue";
import {useToast} from "vue-toastification";
import { Link } from "@inertiajs/vue3"

export default {
    name: "Index",
    components: {
        SimplePaginate,
        AppLayout,
        Link,
        Active
    },
    mounted() {
        this.toast("[RESOURCE_PROPER] loaded");
    },
    props: ['[RESOURCE_PLURAL_KEY]'],
    data() {
        return {
            toast: useToast()
        }
    },
}
</script>

<style scoped>

</style>
