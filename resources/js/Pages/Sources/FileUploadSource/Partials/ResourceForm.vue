<template>
    <div class="col-span-6 sm:col-span-6 ">
        <InputLabel for="Name" >Name</InputLabel>
        <TextInput
            class="p-2 border border-gray-300 w-full"
            type="text"
            placeholder="Web File About"
            v-model="modelValue.name"
        />
        <InputError :message="modelValue.errors.name" class="mt-2" />
    </div>
    <div class="col-span-6 sm:col-span-6 ">
        <InputLabel for="description" >Description</InputLabel>
        <TextArea
            class="p-2 border border-gray-300 w-full"
            placeholder="Brief bit of info info"
            v-model="modelValue.description"
        />
        <InputError :message="modelValue.errors.description" class="mt-2" />
    </div>
    <div class="col-span-6 sm:col-span-6 ">
        <InputLabel for="description" >Upload the file</InputLabel>
        <input type="file"
               @input="modelValue.file = $event.target.files[0]">
        <progress v-if="modelValue.progress" :value="modelValue.progress.percentage" max="100">
            {{ modelValue.progress.percentage }}%
        </progress>
        <InputError :message="modelValue.errors.file" class="mt-2" />
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';

const emit = defineEmits(['update:modeValue']);
const props = defineProps({
    modelValue: Object
})
</script>

<style scoped>

</style>
