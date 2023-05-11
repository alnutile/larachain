<template>
    <div v-if="project.transformers">
        <ul>
            <li v-for="transformer in project.transformers" :key="transformer.id" class="mt-1 border border-gray-200 p-4 shadow hover:bg-gray-50 hover:cursor-pointer">
                <Link :href="route('transformers.embed_transformer.edit', {
                            project: project.id,
                            transformer: transformer.id
                        })">
                    <div class="text-sm">
                        Transformer {{transformer.type_formatted}} <span class="text-xs text-gray-400">({{ transformer.id }})</span><span aria-hidden="true"> &rarr;</span>
                    </div>
                    <div class="text-xs text-gray-500">

                    </div>
                </Link>
                <div class="flex justify-end">
                    <SecondaryButton @click="run(transformer)">
                        <Spinner v-if="formRun.processing"/>
                        run</SecondaryButton>
                </div>
            </li>
        </ul>
    </div>
    <div v-else class="text-gray-400">👇Choose a Transformer below to get started</div>

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
        .listen('.transformersRun', (e) => {
            toast("Transformer Run Complete 🥂")
        });
})

const formRun = useForm({})

const emit = defineEmits(['runComplete'])

const run = (transformer) => {
    toast(`Running Transformer ${transformer.name}`)
    formRun.post(route('transformers.embed_transformer.run', {
        project: props.project.id,
        transformer: transformer.id
    }), {
        errorBag: "transformerEmbedTransformer",
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
