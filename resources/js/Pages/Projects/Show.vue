<template>
    <AppLayout title="Project">
        <template #header>

            <HeaderArea :project="project"/>

        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-2 sm:max-w-7xl">
                <div class="bg-white min-h-screen overflow-hidden shadow-xl sm:rounded-lg p-2 sm:p-5">
                    <div>
                        <div class="flex justify-between sm:justify-center items-center gap-4">
                            <form @submit.prevent="submit" class="w-full flex mx-auto">
                                <div class="w-full flex mx-auto flex-col">
                                    <InputLabel class="text-gray-500 ml-1 mb-1">
                                        <div class="flex justify-start items-center">
                                            <MagnifyingGlassIcon class="w-4 h-4 mr-2"/>
                                            <span>Search your data and chat to an AI</span>
                                        </div>
                                    </InputLabel>
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
                                    <div><button @click="refresh" class="underlines text-gray-500 italic" type="button">clear history</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-if="project?.sources.length > 1" class="flex justify-center gap-4">
                        <div v-if="project?.sources.length > 1" class="flex justify-center text-gray-500 text-md mb-2">Limit context to one more more sources</div>
                        <div class="flex gap-2 justify-center">
                            <button
                                @click="toggleFilter(source)"
                                v-for="source in project?.sources" :key="source.id"
                                :class="{ 'opacity-100' : sourceFilters.has(source.id), 'opacity-50' : !sourceFilters.has(source.id) }"
                                type="button" class="
                                inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{source.name}}
                                <CheckCircleIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                            </button>
                        </div>
                    </div>

                    <div class="max-w-7xl mt-8 bg-slate-800 text-gray-200 p-4 overflow-auto flex-col  mx-auto text-xl min-h-[200px] ring ring-slate-600">
                        <div v-if="response.length === 0" class="text-xl text-gray-400">
                            Responses will show here
                        </div>
                        <span v-else v-for="(message, index) in response" :key="index" class="flex items-center gap-4 w-full">
                            <span v-if="message.type === 'system'" class="flex w-full justify-start mb-1 mt-2">
                                    {{ message.content }}
                            </span>
                            <span v-else class="flex w-full justify-end mt-1 mb-1 ">
                                <span class="bg-blue-500 text-white rounded-md px-4 py-2 inline-block">
                                    {{ message.content }}
                                </span>
                            </span>
                        </span>
                    </div>

                    <div v-if="settings"
                         class="bg-gradient-to-r from-white to-gray-50 grid grid-cols-1 sm:grid-cols-3 gap-2 mt-12 justify-items-center divide-x rounded border-gray-200 border shadow-lg p-4">
                        <SourcesToChooseFrom
                            :items="source_types"
                            :project="project"/>
                        <TransformersToChooseFrom
                            :items="transformer_types"
                            :project="project"/>
                        <OutboundsToChooseFrom
                            :items="outbound_types"
                            :project="project"/>
                    </div>
                </div>
            </div>
        </div>



    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link, usePage } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const toast = useToast();
import pickBy from 'lodash/pickBy'
import { MagnifyingGlassIcon} from "@heroicons/vue/24/outline";
import {computed, onMounted, ref} from "vue";
import SourcesToChooseFrom from "./Components/SourcesToChooseFrom.vue";
import TransformersToChooseFrom from "@/Pages/Transformers/Partials/TransformersToChooseFrom.vue";
import OutboundsToChooseFrom from "@/Pages/Outbounds/Partials/OutboundsToChooseFrom.vue";
import HeaderArea from "./Components/HeaderArea.vue";
import { CheckCircleIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    project: Object,
    outbound_types: Object,
    source_types: Object,
    transformer_types: Object,
})

const settings = ref(true);

const form = useForm({
    question: "",
    filters: []
})

const response = ref([]);

const sourceFilters = ref(new Set())

onMounted(() => {
    Echo.private(`projects.${props.project.id}`)
        .listen('.chat', (e) => {
            response.value.push({
                type: "system",
                content: e.response
            })
        });
})

const toggleFilter = (source) => {
    console.log(source)
        if(sourceFilters.value.has(source.id)) {
            sourceFilters.value.delete(source.id)
        } else {
            sourceFilters.value.add(source.id)
        }
}

const submit = () => {
    form.processing = true;
    form.filters = {
        sources: [...sourceFilters.value]
    }
    toast("This might take a moment")
    response.value.push({
        type: "user",
        content: form.question
    })
    axios.post(route('projects.chat', {
        project: props.project.id
    }), pickBy(form))
        .then(data => {
            toast("Results should appear soon...")
            form.processing = false;
            form.question = "";
        })
        .catch(error => {
            console.log(error)
            toast.error("Sorry try again shortly")
            form.processing = false;
        })
}

const refresh = () => {
    form.processing = true;
    axios.delete(route("projects.messages.delete", {
        project: props.project.id
    }))
        .then(data => {
            toast("history cleared")
            response.value = [];
            form.processing = false;
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
