<template>
    <AppLayout title="[RESOURCE_PROPER]">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit [RESOURCE_PROPER]
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                    <SectionTitle>
                        <template #title>
                            Edit [RESOURCE_PROPER] #{{ [RESOURCE_SINGULAR_KEY].id }}
                        </template>

                    </SectionTitle>

                    <form @submit.prevent="submit">
                        <ResourceForm
                        v-model="form">
                        </ResourceForm>
                        <div>
                            <button class="btn"
                            type="submit"
                            >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue"
import ResourceForm from "@/Pages/[RESOURCE_PROPER_PLURAL]/Components/ResourceForm.vue";
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

export default {
    name: "Edit",
    components: {
        SectionTitle,
        ResourceForm,
        AppLayout
    },
    props: ['[RESOURCE_SINGULAR_KEY]'],
    methods: {
        submit() {
            this.form.put(route("[RESOURCE_PLURAL_KEY].update", {
                [RESOURCE_SINGULAR_KEY]: this.[RESOURCE_SINGULAR_KEY].id
            }), {
                onStart: params => {
                    this.toast.info("Updating...")
                },
                onSuccess: params => {
                    this.toast("Update Complete")
                },
                onError: params => {
                    this.toast.error("Error with update")
                }
            })
        }
    },
    data() {
        return {
            toast: useToast(),
            form: useForm({
                subject: this.[RESOURCE_SINGULAR_KEY].subject,
            })
        }
    }
}
</script>

<style scoped>

</style>
