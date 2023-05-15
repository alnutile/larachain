<script setup>
import { onMounted, ref } from 'vue';
defineProps({
    modelValue: String,
    rows: {
        default: 4,
        type: Number
    }
});
defineEmits(['update:modelValue']);
</script>

<template>

    <textarea :rows="rows"
              :value="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        {{ modelValue }}
    </textarea>

</template>
