<template>
<AppLayout title="Source Web File">
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Web File
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
                                    <div class="col-span-6 sm:col-span-6 ">
                                        <InputLabel for="Name" >Name</InputLabel>
                                        <TextInput
                                            class="p-2 border border-gray-300 w-full"
                                            type="text"
                                            placeholder="Web File About"
                                            v-model="form.name"
                                        />
                                        <InputError :message="form.errors.name" class="mt-2" />
                                    </div>
                                    <div class="col-span-6 sm:col-span-6 ">
                                        <InputLabel for="urls" >URL</InputLabel>
                                        <TextInput
                                            class="p-2 border border-gray-300 w-full"
                                            type="text"
                                            placeholder="https://somepublicpdf.com/foo.pdf"
                                            v-model="form.url"
                                        />
                                        <InputError :message="form.errors.url" class="mt-2" />
                                    </div>
                                    <div class="col-span-6 sm:col-span-6 ">
                                        <InputLabel for="description" >Description</InputLabel>
                                        <TextArea
                                            class="p-2 border border-gray-300 w-full"
                                            placeholder="Brief bit of info info"
                                            v-model="form.description"
                                        />
                                        <InputError :message="form.errors.description" class="mt-2" />
                                    </div>
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
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
const toast = useToast();

const props = defineProps({
    details: Object,
    project: Object
})

const form = useForm({
    url: "",
    description: "Some info",
    name: "Web File"
})

const submit = () => {
    form.post(route("sources.web_file.store", {
        project: props.project.id
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
