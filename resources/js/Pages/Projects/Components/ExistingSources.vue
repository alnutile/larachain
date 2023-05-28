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
                    <Link :href="route('sources.web_file.edit', {
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
                        <SecondaryButton @click="run(element)">
                            <Spinner v-if="formRun.processing&& running === element.id"/>
                            run</SecondaryButton>
                    </div>
                </div>
            </div>
        </VueDraggableNext>
    </div>
    <div v-else class="text-gray-400">👇Choose a Source below to get started</div>

</template>

<script setup>
import { VueDraggableNext } from 'vue-draggable-next'
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {onMounted, ref} from "vue";
import { ArrowsPointingOutIcon, ArrowsRightLeftIcon} from "@heroicons/vue/24/solid"


const toast = useToast();

const running = ref()

const props = defineProps({
    project: Object
})

const sources = ref([])

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
