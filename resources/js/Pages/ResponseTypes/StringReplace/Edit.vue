<template>
<AppLayout title="Source Web File">
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ details.title }}
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
                                       @removeSearchItem="removeSearchItem"
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
import ResourceForm from "./Partials/ResourceForm.vue";
import FormWrapper from "@/Components/FormWrapper.vue";
import FormSection from "@/Components/TypeFormSection.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Link } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
const toast = useToast();

const props = defineProps({
    details: Object,
    outbound: Object,
    response_type: Object
})

const form = useForm({
    meta_data: props.response_type.meta_data,
    prompt_token: props.response_type.prompt_token,
})

const removeSearchItem = (index) => {
    console.log(index);
    form.meta_data.search.splice(index, 1);
    form.meta_data.replace.splice(index, 1);
}

const submit = () => {
    form.put(route("response_types.string_replace.update", {
        outbound: props.outbound.id,
        response_type: props.response_type.id
    }), {
        preserveScroll: true,
        onError: params => {
            toast.error("Error saving updates check validation")
        }
    });
}
</script>

<style scoped>

</style>
