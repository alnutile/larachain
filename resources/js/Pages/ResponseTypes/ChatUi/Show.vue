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
                                    <template #form_description>
                                        <h3 class="text-xl text-gray-900 mb-4">Response Types</h3>
                                        <div class="mt-2">
                                            To configure the prompt, you can use the results of the question or search to create a system message that sets the context for the chat interaction. You can use the token `{context}` to represent the content that will be replaced.

                                            For example, let's say you're building a helpful historian chatbot. You can configure the prompt as follows:

                                            <pre class="mt-4 mb-4 text-sm prose bg-slate-800 text-gray-100 p-2 overflow-auto"><code>As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.
Context: {context}
###
                                            </code></pre>
                                        </div>
                                    </template>
                                    <template #form>
                                        <div class="flex flex-col gap-4 col-span-6">
                                            <InputLabel value="Prompt"/>
                                            <TextArea
                                                rows="15"
                                                autofucus
                                                v-model="form.prompt_text"
                                            ></TextArea>
                                            <InputError
                                                :message="form.errors.prompt_text"
                                            ></InputError>
                                        </div>
                                    </template>

                                    <template #actions>
                                        <div class="flex justify-end gap-4">
                                            <SecondaryButtonLink
                                                :href="route(`outbounds.${outbound.type}.show`, {
                                            outbound: outbound.id,
                                            project: outbound.project_id
                                        })"
                                            >
                                                Back to Outbound
                                            </SecondaryButtonLink>
                                            <PrimaryButton
                                                @click="submit"
                                                type="submit"

                                            >Save</PrimaryButton>
                                        </div>
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
import FormSection from "@/Components/TypeFormSection.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Link } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
const toast = useToast();
import SecondaryButtonLink from "@/Components/SecondaryButtonLink.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Select from "@/Components/Select.vue";
import collect from "collect.js";

const props = defineProps({
    outbound: Object,
    details: Object,
    response_type: Object
})

const form = useForm({
    prompt_token: props.response_type.prompt_token,
    prompt_text: props.response_type.prompt_token.system
})

const submit = () => {
    form.put(route('response_types.chat_ui.update', {
        'outbound': props.outbound.id,
        'response_type': props.response_type.id
    }), {
        onError: params => {
            toast.error("Error saving updates sorry")
        }
    })
}



</script>

<style scoped>

</style>
