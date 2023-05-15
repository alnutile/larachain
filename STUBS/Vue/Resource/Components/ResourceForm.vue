<template>
    <div class="mb-4 mt-4">
        <InputLabel value="Subject"/>
        <TextInput
            autofucus
            v-model="modelValue.subject"
        ></TextInput>
        <InputError
            :message="modelValue.errors.subject"
        ></InputError>
    </div>

    <div class="mb-4 mt-4">
        <InputLabel value="Message"/>
        <TextArea
            rows="10"
            v-model="modelValue.message"
        ></TextArea>
        <InputError
            :message="modelValue.errors.message"
        ></InputError>
    </div>



    <div class="mb-4">
        <InputLabel value="Active"/>
        <Checkbox
            class="disabled:bg-gray-100 disabled:cursor-not-allowed"
            v-model="modelValue.active"
            :checked="modelValue.active"
        ></Checkbox>

        <InputError
            :message="modelValue.errors.active"
        ></InputError>
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
