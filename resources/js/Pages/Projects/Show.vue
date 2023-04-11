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
                    <div class="flex justify-between mx-auto items-center w-full">
                        <div class="text-gray-500 font-bold">
                            Viewing: Project #{{ project.id }}
                        </div>
                        <div>
                            <Active :active="project.active"/>
                        </div>
                    </div>
                    <div>
                        This is where you can build your connections. You can take a <span class="font-bold">Source</span>, add some <span class="font-bold">Actions</span> then <span class="font-bold">Retrieve</span> it.
                    </div>
                    <div>
                        For example, so you have a site with historical data. Let's say it has no api so you need to send the data to us.
                        Then you choose a "Source" call "Push" and it will give you and API and format to push the data to.
                        Then you can create and "Action" in this example "Embed" to convert it using OpenAI API Embedding.
                        Lastly you choose a "Retrieve" to create an API to get your data. It is here you can add "Prompt"
                        a prefix and suffix to assist the api in giving a great answer like
                    </div>
                    <div class="italic text-gray-500 p-4">
                        "You are a historian and
                        are going to reply to the question _______ with suggestions of other possible interests. Please limit the options to the data we are
                        giving you with this question."
                    </div>
                    <div>
                        The api create for this project will then return the results for you to use on your site or on ours.
                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-4 justify-items-center">
                        <div class="text-lg font-semibold">
                            <div>Related Source</div>
                            <div>
                                <SecondaryButton>add</SecondaryButton>
                            </div>
                        </div>
                        <div class="text-lg font-semibold">
                            <div>Related Actions</div>
                            <SecondaryButton>add</SecondaryButton>
                        </div>
                        <div class="text-lg font-semibold">
                            <div>Related Retrieval Option</div>
                            <SecondaryButton>add</SecondaryButton>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue"
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import Active from "@/Components/Active.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    name: "Show",
    components: {
        SecondaryButton,
        Active,
        SectionTitle,
        AppLayout
    },
    props: ['project'],
    data() {
        return {
            toast: useToast()
        }
    }
}
</script>

<style scoped>

</style>
