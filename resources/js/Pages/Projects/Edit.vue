<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Project
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                    <SectionTitle>
                        <template #title>
                            Edit Project #{{ project.id }}
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
import ResourceForm from "@/Pages/Projects/Components/ResourceForm.vue";
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

export default {
    name: "Edit",
    components: {
        SectionTitle,
        ResourceForm,
        AppLayout
    },
    props: ['project'],
    methods: {
        submit() {
            this.form.put(route("projects.update", {
                project: this.project.id
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
                subject: this.project.subject,
            })
        }
    }
}
</script>

<style scoped>

</style>
