<template>
    <div v-if="project.sources">
        <ul>
            <li v-for="source in project.sources" :key="source.id" class="mt-1 border border-gray-200 p-4 shadow hover:bg-gray-50 hover:cursor-pointer">
                <Link :href="route('sources.web_file.edit', {
                            project: project.id,
                            source: source.id
                        })">
                    <div class="text-sm">
                        {{ source.name }} <span class="text-xs text-gray-400">({{ source.id }})</span><span aria-hidden="true"> &rarr;</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{source.meta_data.url}}
                    </div>
                </Link>
                <div class="flex justify-end">
                    <SecondaryButton @click="run(source)">
                        <Spinner v-if="formRun.processing"/>
                        run</SecondaryButton>
                </div>
            </li>
        </ul>
    </div>
    <div v-else class="text-gray-400">👇Choose a Source below to get started</div>

</template>

<script setup>
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {onMounted} from "vue";

const toast = useToast();

const props = defineProps({
    project: Object
})


onMounted(() => {
    Echo.private(`projects.${props.project.id}`)
        .listen('.sourcesRun', (e) => {
            toast("Source Run Complete 🥂")
        });
})

const formRun = useForm({})

const emit = defineEmits(['runComplete'])

const run = (source) => {
    toast(`Running Source ${source.name}`)
    formRun.post(route('sources.web_file.run', {
        project: props.project.id,
        source: source.id
    }), {
        errorBag: "sourceWebFile",
        preserveScroll: true,
        onError: params => {
            toast.error("Error running job 🤦🏻‍")
        },
        onSuccess: params => {
            emit("runComplete")
            router.reload()
        }
    });
}
</script>

<style scoped>

</style>
