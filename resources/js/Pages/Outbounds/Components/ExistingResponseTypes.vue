<template>
    <div v-if="items.length > 0">
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
                    <div class="w-full">
                        <div class="text-sm">
                            Response Type {{element.type_formatted}}
                            <Link :href="route(`response_types.${element.type}.edit`, {
                            outbound: outbound.id,
                            response_type: element.id
                        })">
                                <span class="text-xs text-gray-400">({{ element.id }})</span><span aria-hidden="true"> &rarr;</span>
                            </Link>
                        </div>
                        <div class="text-xs text-gray-500">
                        </div>
                    </div>
                    <div class="justify-end flex w-full">
                        <DeleteButton
                            type="button"
                            @click="deleteResponseType(element)">
                            <TrashIcon class="w-4 h-4"/>
                        </DeleteButton>
                    </div>
                </div>
            </div>
        </VueDraggableNext>


    </div>
    <div v-else class="text-gray-400">👇Choose a response type below to get started</div>

</template>

<script setup>
import { VueDraggableNext } from 'vue-draggable-next'
import {useToast} from "vue-toastification";
import {Link, useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import { ArrowsPointingOutIcon, TrashIcon} from "@heroicons/vue/24/solid"
const toast = useToast();

const items = ref([])

const model = "\\App\\Models\\ResponseType"

const props = defineProps({
    outbound: Object
})

const form = useForm({})

const deleteResponseType = (response_types) => {
    form.delete(route('response_types.delete', {
        response_type: response_types.id
    }), {
        preserveScroll: false,
        preserveState: false,
    });
}
onMounted(() => {
    items.value = props.outbound.response_types;
})

const endDrag = (event) => {
    items.value.forEach((item, key) => {
        items.value[key].order = key;
    })
    toast("Updating sort order...")
    axios.post(route('sortable.sort', {
        project: props.outbound.project_id
    }), {
        items: items.value,
        model: model
    })
        .catch(error => {
            console.log(error)
            toast.error("Oops error with sorting")
        })
}



</script>

<style scoped>

</style>
