<template>
    <div v-if="project.transformers">
        <VueDraggableNext class="dragArea list-group w-full" :list="items" @change="endDrag">
            <div
                class="list-group-item m-1 rounded-md bg-white"
                v-for="element in items"
                :key="element.id"
            >
                <div  class="flex justify-start items-center gap-2 bg-white border-gray-200 border p-2 m-1 shadow-sm">
                    <div class="draggable" :key="element.id">
                        <ArrowsPointingOutIcon class="w-4 h-4 text-gray-400 hover:cursor-grab"/>
                    </div>
                    <Link :href="route(`transformers.${element.type}.edit`, {
                            project: project.id,
                            transformer: element.id
                        })">
                        <div class="text-sm">
                            Transformer {{element.type_formatted}} <span class="text-xs text-gray-400">({{ element.id }})</span><span aria-hidden="true"> &rarr;</span>
                        </div>
                        <div class="text-xs text-gray-500">
                        </div>
                    </Link>
                    <div class="flex justify-end w-full">

                        <RunButton
                            type="button"
                            @click="run(element)">
                            <Spinner
                                class="mr-0"
                                v-if="formRun.processing&& running === element.id"/>
                            <PlayIcon v-else class="w-4 h-4"/></RunButton>

                        <DeleteButton
                            type="button"
                            @click="deleteTransformer(element)">
                            <TrashIcon class="w-4 h-4"/>
                        </DeleteButton>

                    </div>
                </div>
            </div>
        </VueDraggableNext>

    </div>
    <div v-else class="text-gray-400">👇Choose a Transformer below to get started</div>


</template>

<script setup>
import { VueDraggableNext } from 'vue-draggable-next'
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {nextTick, onMounted, ref} from "vue";
import DeletePartial from "@/Pages/Sources/Components/DeletePartial.vue";
import DialogModal from "@/Components/DialogModal.vue";
import RunButton from "@/Components/RunButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";


import { ArrowsPointingOutIcon, PlayIcon, TrashIcon} from "@heroicons/vue/24/solid"
const toast = useToast();

const props = defineProps({
    project: Object
})

const form = useForm({});

const items = ref([])

const model = "\\App\\Models\\Transformer"

onMounted(() => {
    items.value = props.project.transformers;
})


const deleteTransformer = (transformers) => {
    form.delete(route('transformers.delete', {
        transformer: transformers.id
    }), {
        preserveScroll: false,
        preserveState: false,
    });

}

const endDrag = (event) => {
    items.value.forEach((item, key) => {
        items.value[key].order = key;
    })
    toast("Updating sort order...")
    axios.post(route('sortable.sort', {
        project: props.project.id
    }), {
        items: items.value,
        model: model
    })
        .catch(error => {
            console.log(error)
            toast.error("Oops error with sorting")
        })
}


onMounted(() => {
    Echo.private(`projects.${props.project.id}`)
        .listen('.transformersRun', (e) => {
            toast("Transformer Run Complete 🥂")
        });
})

const formRun = useForm({})

const running = ref()

const emit = defineEmits(['runComplete'])

const run = (transformer) => {
    running.value = transformer.id;
    toast(`Running Transformer ${transformer.type_formatted}`)
    formRun.post(route(`transformers.${transformer.type}.run`, {
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
