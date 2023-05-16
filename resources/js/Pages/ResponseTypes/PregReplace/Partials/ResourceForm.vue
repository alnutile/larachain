<template>
    <div class="col-span-6 sm:col-span-6 ">
        <InputLabel for="urls" >Preg Patter</InputLabel>
        <TextInput
            class="p-2 border border-gray-300 w-full"
            type="text"
            placeholder="/\./"
            v-model="modelValue.meta_data.preg_replace_pattern"
        />
        <div class="text-xs mb-1 text-gray-600">This will be the pattern:</div>
        <pre><code class="text-gray-100 bg-slate-800 px-1 py-1 mt-1">/\./</code></pre>
        <InputError :message="modelValue.errors?.meta_data" class="mt-2" />
    </div>
    <div class="col-span-6 sm:col-span-6 ">
        <InputLabel for="urls" >Replacement</InputLabel>
        <TextInput
            class="p-2 border border-gray-300 w-full"
            type="text"
            placeholder="''"
            v-model="modelValue.meta_data.preg_replace_replacement"
        />
        <div class="text-xs mb-1 text-gray-600">This will be the replacement:</div>
        <InputError :message="modelValue.errors?.meta_data" class="mt-2" />
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
