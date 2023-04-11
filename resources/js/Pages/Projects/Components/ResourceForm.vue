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
        <InputLabel value="Active"/>
        <Checkbox
            class="disabled:bg-gray-100 disabled:cursor-not-allowed"
            v-model="modelValue.active"
            :checked="modelValue.active"
        ></Checkbox>

        <InputError
            :message="modelValue.errors.active"
        >

        </InputError>
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
