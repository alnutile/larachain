<template>
    <div v-if="project.outbounds">
        <ul>
            <li v-for="outbound in project.outbounds" :key="outbound.id"
                class="mt-1 border border-gray-200 p-4 shadow hover:bg-gray-50 hover:cursor-pointer justify-between flex">
                <Link
                    class="w-full"
                    :href="route(`outbounds.${outbound.type}.show`, {
                            project: project.id,
                            outbound: outbound.id
                        })">
                    <div class="text-sm">
                        Outbound {{outbound.type_formatted}} <span class="text-xs text-gray-400">({{ outbound.id }})</span><span aria-hidden="true"> &rarr;</span>
                    </div>
                    <div class="text-xs text-gray-500">

                    </div>
                </Link>
                <div class="justify-end flex w-full h-6">
                    <DeleteButton
                        type="button"
                        @click="deleteOutbound(outbound)">
                        <TrashIcon class="w-4 h-4"/>
                    </DeleteButton>
                </div>
            </li>
        </ul>
    </div>
    <div v-else class="text-gray-400">👇Choose a outbound below to get started</div>

</template>

<script setup>
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {onMounted, ref} from "vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import { ArrowsPointingOutIcon, TrashIcon} from "@heroicons/vue/24/solid"
const toast = useToast();

const props = defineProps({
    project: Object
})
const form = useForm({})

const deleteOutbound = (outbound) => {
    form.delete(route('outbounds.delete', {
        outbound: outbound.id
    }), {
        preserveScroll: false,
        preserveState: false,
    });
}

</script>

<style scoped>

</style>
