<template>
    <AppLayout title="transformer Web File">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Web Site Document
            </h2>
            <div>
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <FormWrapper @submitted="submit">
                        <div>
                            <div class="max-w-7xl mx-auto sm:py-10 sm:px-6 lg:px-8">
                                <FormSection>
                                    <template #title>
                                        {{ details.title }}
                                    </template>
                                    <template #description>
                                        {{ details.description }}
                                    </template>

                                    <template #form>
                                        <ResourceForm
                                            @removedMapping="updateMappings"
                                            @addedMapping="updateMappings"
                                            v-model="form"/>
                                    </template>

                                    <template #actions>
                                        <PrimaryButton @click="submit">Save</PrimaryButton>
                                    </template>

                                </FormSection>
                            </div>
                        </div>
                    </FormWrapper>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormWrapper from "@/Components/FormWrapper.vue";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import ResourceForm from "./Partials/ResourceForm.vue";
const toast = useToast();

const props = defineProps({
    transformer: Object,
    details: Object
})

const updateMappings = (mappings) => {
    form.mappings = mappings;
}

const form = useForm({
    mappings: props.transformer.meta_data?.mappings ?? []
})

const submit = () => {
    form.put(route("transformers.json_transformer.update", {
        project: props.transformer.project_id,
        transformer: props.transformer.id
    }), {
        preserveScroll: true,
        onError: params => {
            toast.error("Check validation")
        }
    });
}
</script>

<style scoped>

</style>
