<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                    <SectionTitle>
                        <template #title>
                            Create Project
                        </template>

                    </SectionTitle>
                    <div class="max-w-2xl  border-gray-300 border rounded-lg p-5">
                        <form @submit.prevent="submit">
                            <ResourceForm
                                v-model="form">
                            </ResourceForm>
                            <div class="flex justify-end">
                                <PrimaryButton
                                               type="submit"
                                >Save</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue"
import ResourceForm from "@/Pages/Projects/Components/ResourceForm.vue";
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Edit",
    components: {
        PrimaryButton,
        SectionTitle,
        ResourceForm,
        AppLayout
    },
    props: ['project'],
    methods: {
        submit() {
            this.form.post(route("projects.create"), {
                onStart: params => {
                    this.toast.info("Creating...")
                },
                onError: params => {
                    this.toast.error("Error with create")
                }
            })
        }
    },
    data() {
        return {
            toast: useToast(),
            form: useForm({
                name: this.project.name,
                active: this.project.active
            })
        }
    }
}
</script>

<style scoped>

</style>
