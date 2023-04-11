<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Project
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                    <SectionTitle>
                        <template #title>
                            Viewing Project #{{ project.id }}
                        </template>

                    </SectionTitle>

                    Content Here...
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue"
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

export default {
    name: "Show",
    components: {
        SectionTitle,
        AppLayout
    },
    props: ['project'],
    data() {
        return {
            toast: useToast()
        }
    }
}
</script>

<style scoped>

</style>
