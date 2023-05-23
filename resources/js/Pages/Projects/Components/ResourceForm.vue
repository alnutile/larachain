<template>
<div class="flex flex-col gap-4">
        <InputLabel value="Name"/>
        <TextInput
            autofucus
            type="text"
            v-model="modelValue.name"
        ></TextInput>
        <InputError
            :message="modelValue.errors.name"
        ></InputError>
        <div class="border border-gray-200 rounded rounded-md p-4 shadow">
            <InputLabel value="Active"/>
            <Checkbox
                class="disabled:bg-gray-100 disabled:cursor-not-allowed"
                v-model="modelValue.active"
                :checked="modelValue.active"
            ></Checkbox>
        </div>

        <div class="border border-gray-200 rounded rounded-md p-4 shadow">
            <InputLabel value="Share on Web"/>
            <Checkbox
                class="disabled:bg-gray-100 disabled:cursor-not-allowed"
                v-model="modelValue.web_page"
                :checked="modelValue.web_page"
            ></Checkbox>
            <InputError
                :message="modelValue.errors.web_page"
            />
            <div class="text-gray-500">This will allow you to share as a public or private read only web page</div>

            <div v-if="modelValue.web_page">
                <InputLabel value="Private"/>
                <Checkbox
                    class="disabled:bg-gray-100 disabled:cursor-not-allowed"
                    v-model="modelValue.private"
                    :checked="modelValue.private"
                ></Checkbox>
                <InputError
                    :message="modelValue.errors.web_page"
                />
                <div class="text-gray-500">Do you want to secure with a password?</div>
                <div v-if="modelValue.private">
                    <InputLabel value="Password"/>
                    <TextInput
                        type="text"
                        v-model="modelValue.password"
                    ></TextInput>
                    <InputError
                        :message="modelValue.errors.password"
                    ></InputError>
                </div>
            </div>
        </div>
</div>
</template>

<script>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Select from "@/Components/Select.vue";

export default {
    name: "ResourceForm",
    components: {
        Select,
        InputLabel,
        Checkbox,
        TextArea,
        InputError,
        TextInput
    },
    props: ["modelValue"],
    emits: ['update:modelValue']
}
</script>

<style scoped>

</style>
