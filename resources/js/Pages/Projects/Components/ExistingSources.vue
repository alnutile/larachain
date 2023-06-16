<template>
    <div v-if="sources">

        <VueDraggableNext class="dragArea list-group w-full" :list="sources" @change="endDrag">
            <div
                class="list-group-item m-1 rounded-md bg-white"
                v-for="element in sources"
                :key="element.id"
            >
                <div  class="flex justify-start items-center gap-2 bg-white border-gray-200 border p-2 m-1 shadow-sm">
                    <div class="draggable" :key="element.id">
                        <ArrowsPointingOutIcon class="w-4 h-4 text-gray-400 hover:cursor-grab"/>
                    </div>
                    <Link :href="route('sources.' + element.type + '.edit', {
                            project: project.id,
                            source: element.id
                        })">
                        <div class="text-sm">
                            {{ element.name }} <span class="text-xs text-gray-400">({{ element.id }})</span><span aria-hidden="true"> &rarr;</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            {{element.meta_data.url}}
                        </div>
                        <div class="mt-2 flex justify-start items-center text-xs text-gray-400 font-bold italic">
                            Type:{{element.type_formatted}}
                        </div>
                    </Link>
                    <div class="flex justify-end">
                        <RunButton
                            type="button"
                            @click="run(element)">
                            <Spinner
                                class="mr-0"
                                v-if="formRun.processing&& running === element.id"/>
                            <PlayIcon v-else class="w-4 h-4"/></RunButton>
                        <DeleteButton
                            type="button"
                            @click="setSourceToDelete(element)">
                            <TrashIcon class="w-4 h-4"/>
                        </DeleteButton>
                    </div>
                </div>
            </div>
        </VueDraggableNext>
    </div>
    <div v-else class="text-gray-400">👇Choose a Source below to get started</div>

    <DialogModal
        closeable
        :show="showDeleteModal"
        @close="showDeleteModal = false">
        <template #title>
            <div class="flex justify-start gap-4">
                Delete Source {{ sourceModel.name }}
            </div>
        </template>

        <template #content>
                <div class="p-4 text-lg">
                    This will delete all the related documents as well.
                </div>
                <div class="flex justify-end gap-4">
                    <DeletePartial
                        :source="sourceModel"
                                  @sourceDeleted="deleteComplete"/>
                    <SecondaryButton
                        type="button"
                        @click="showDeleteModal = false">
                        Cancel
                    </SecondaryButton>
                </div>
        </template>
    </DialogModal>


</template>

<script setup>
import { VueDraggableNext } from 'vue-draggable-next'
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import RunButton from "@/Components/RunButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import {nextTick, onMounted, ref} from "vue";
import { ArrowsPointingOutIcon, ArrowsRightLeftIcon, TrashIcon, PlayIcon} from "@heroicons/vue/24/solid"
import DialogModal from "@/Components/DialogModal.vue";
import DeletePartial from "@/Pages/Sources/Components/DeletePartial.vue";


const toast = useToast();

const running = ref()

const props = defineProps({
    project: Object
})

const sources = ref([])

const sourceModel = ref({})

const showDeleteModal = ref(false)

const deleteComplete = () => {
    showDeleteModal.value = false;
    router.visit(route("projects.show", {
        project: props.project.id
    }),{
        only: ['project']
    });
    nextTick();
}

const setSourceToDelete = (source) => {
    sourceModel.value = source;
    showDeleteModal.value = true;
}

onMounted(() => {
    sources.value = props.project.sources;
})

const endDrag = (event) => {
    sources.value.forEach((item, key) => {
       sources.value[key].order = key;
    })
    toast("Updating sort order...")
    axios.post(route('sortable.sort', {
        project: props.project.id
    }), {
        items: sources.value,
        model: "\\App\\Models\\Source"
    })
        .catch(error => {
            console.log(error)
            toast.error("Oops error with sorting")
        })
}

const options = ref({

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
    running.value = source.id;
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
