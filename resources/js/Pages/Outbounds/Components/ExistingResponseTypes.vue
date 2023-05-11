<template>
    <div v-if="outbound.response_types.length > 0">
        <ul>
            <li v-for="response_type in outbound.response_types" :key="outbound.id" class="mt-1 border border-gray-200 p-4 shadow hover:bg-gray-50 hover:cursor-pointer">
                <div>
                    <div class="text-sm">
                        Response Type {{response_type.type_formatted}}
                        <Link :href="route(`response_types.${response_type.type}.edit`, {
                            outbound: outbound.id,
                            response_type: response_type.id
                        })">
                            <span class="text-xs text-gray-400">({{ response_type.id }})</span><span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </div>
                    <div class="text-xs text-gray-500">
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div v-else class="text-gray-400">👇Choose a response type below to get started</div>

</template>

<script setup>
import {useToast} from "vue-toastification";
import {useForm, Link, router} from "@inertiajs/vue3";
import Spinner from "@/Components/Spinner.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {onMounted, ref} from "vue";

const toast = useToast();

const props = defineProps({
    outbound: Object
})


</script>

<style scoped>

</style>
