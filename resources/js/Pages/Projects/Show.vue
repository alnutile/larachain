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
                    <div class="flex justify-between mx-auto items-center w-full">
                        <div class="text-gray-500 font-bold">
                            Viewing: Project #{{ project.id }}
                        </div>
                        <div>
                            <Active :active="project.active"/>
                        </div>



                    </div>

                    <div class="mt-10">
                        <div class="flex justify-center items-center gap-4">
                            <div class="w-full">
                                <InputLabel>Search your data and chat to an AI</InputLabel>
                                <div>
                                    <TextInput
                                        class="w-[400px]"
                                        type="text" placeholder="Ask the AI about data related to your Project"></TextInput>
                                    <PrimaryButton>Ask</PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="grid grid-cols-3 gap-4 mt-12 justify-items-center" v-if="false">
                        <div class="text-lg font-semibold">
                            <div>Related Source</div>
                            <div>
                                <SecondaryButton>add</SecondaryButton>
                            </div>
                        </div>
                        <div class="text-lg font-semibold">
                            <div>Related Actions</div>
                            <SecondaryButton>add</SecondaryButton>
                        </div>
                        <div class="text-lg font-semibold">
                            <div>Related Retrieval Option</div>
                            <SecondaryButton>add</SecondaryButton>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue"
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import Active from "@/Components/Active.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const toast = useToast();

const props = defineProps({
    project: Object,
})
</script>

<style scoped>

</style>
