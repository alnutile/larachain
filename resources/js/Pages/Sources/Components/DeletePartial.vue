<template>

    <form @submit.prevent="deleteSource">

        <PrimaryButton
            :disabled="form.processing"
        type="submit"
        >
            <Spinner v-if="form.processing"/>
            Yes I want to delete source</PrimaryButton>

    </form>

</template>

<script setup>
import Spinner from "@/Components/Spinner.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const emit = defineEmits(['sourceDeleted']);

const props = defineProps({
    source: Object
})

const form = useForm({});

const deleteSource = () => {
    form.delete(route('sources.delete', {
        source: props.source.id
    }), {
        preserveScroll: false,
        onSuccess: params => {
            emit("sourceDeleted")
        }
    });
}
</script>

<style scoped>

</style>
