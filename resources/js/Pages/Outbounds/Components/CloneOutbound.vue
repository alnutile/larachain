<template>
    <button @click="showModal = true" class="underline">
        👉clone existing outbound?</button>
    <DialogModal
    :show="showModal"
    :closeable=true
    >
        <template #title>
            Close Existing Outbound Response Types for Project {{ project.name }}
        </template>
        <template #content>
            <div v-for="outbound in outbounds" :key="outbound.id" class="flex gap-4 justify-start items-center">
                <div
                    class="flex justify-between gap-4 mt-4 items-center"
                    v-if="outbound.id != currentOutbound.id">
                    <div
                        class="text-gray-900 text-lg"
                    >{{ outbound.type_formatted }} {{ outbound.id }}</div>
                    <button
                        type="button"
                        :disabled="form.processing"
                        class="flex justify-between items-center rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        @click="choose(outbound)">
                        clone <div
                        aria-hidden="true"> &rarr;</div>
                    </button>
                </div>
            </div>
        </template>
        <template #footer>
            <SecondaryButton type="button" @click="showModal = false">Cancel</SecondaryButton>
        </template>
    </DialogModal>
</template>

<script setup>
import DialogModal from "@/Components/DialogModal.vue"
import {nextTick, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import {router, useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
const toast = useToast();

const props = defineProps({
    project: Object,
    currentOutbound: Object
})

const outbounds = ref([])
const showModal = ref(false)

onMounted(() => {
    getOutbounds();
})

const form = useForm({
    to: props.currentOutbound.id,
    from: null
});

const choose = (outbound) => {
    form.from = outbound.id
    form.post(route("outbounds.clone.response_types"), {
        preserveState: false,
        preserveScroll: false,
        onFinish: () => {
            showModal.value = false;
            router.reload();
        }
    })
}

const getOutbounds = () => {
    axios.get(route("projects.outbounds", {
        project: props.project.id
    }))
        .then(data => {
            console.log(data)
            outbounds.value = data.data;
            nextTick();
        })
        .catch(error => {
            toast.error("Error getting outbounds 🤦🏻‍")
        })
}
</script>

<style scoped>

</style>
