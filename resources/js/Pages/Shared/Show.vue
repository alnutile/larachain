<template>
    <GuestLayout title="Project">
        <template #header>
            <h2 class="flex justify-start items-center font-semibold text-xl text-gray-800 leading-tight mb-2">
                    Search: {{ project.data.name }}
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-2 sm:max-w-7xl ">
                <div class="bg-white min-h-screen overflow-hidden shadow-xl sm:rounded-lg p-2 sm:p-5">
                    <div>
                        <div class="flex justify-between sm:justify-center items-center gap-4">
                            <form @submit.prevent="submit" class="w-full flex mx-auto">
                            <div class="w-full flex mx-auto flex-col">
                                <InputLabel class="text-gray-500 ml-1 mb-1">Search your data and chat to an AI</InputLabel>
                                <div class="flex justify-start gap-2">
                                    <TextInput
                                        v-model="form.question"
                                        class="h-16 w-full"
                                        type="text" placeholder="What was the most common tag in 1920s"></TextInput>

                                    <PrimaryButton :disabled="form.processing || form.question.length === 0"
                                                   class="disabled:opacity-50">
                                        <svg v-if="form.processing"
                                             class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Ask
                                    </PrimaryButton>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div class="max-w-7xl mt-8 bg-slate-800 text-gray-200 p-4 overflow-auto flex-col  mx-auto text-xl">
                        <div v-if="response.length === 0" class="text-xl text-gray-400">
                            Responses will show here
                        </div>
                        <div v-else v-for="(message, index) in response" :key="index" class="flex items-center gap-4 w-full">
                            <div v-if="message.type === 'system'" class="flex w-full justify-start mb-1 mt-2 inline-block">
                                <div>
                                    {{ message.content }}
                                </div>
                            </div>
                            <div v-else class="flex w-full justify-end mt-1 mb-1">
                                <div class="bg-blue-500 text-white rounded-md px-4 py-2 inline-block">
                                    {{ message.content }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const toast = useToast();
import pickBy from 'lodash/pickBy'
import {computed, onMounted, ref} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
const props = defineProps({
    project: Object,
    outbound_types: Array,
    source_types: Array,
    transformer_types: Array,
})

const form = useForm({
    question: ""
})

const response = ref([]);

onMounted(() => {
    Echo.private(`shared.${props.project.id}`)
        .listen('.chat', (e) => {
            response.value.push({
                type: "system",
                content: e.response
            })
        });
})

const submit = () => {
    form.processing = true;
    toast("This might take a moment")

    axios.post(route('shared.chat', {
        project: props.project.data.id
    }), pickBy(form))
        .then(data => {
            form.processing = false;
            form.question = "";
        })
        .catch(error => {
            console.log(error)
            toast.error("Sorry try again shortly")
            form.processing = false;
        })
}



</script>

<style scoped>

</style>
