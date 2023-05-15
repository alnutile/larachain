<script setup>
import JsonEditorVue from 'json-editor-vue'
import {onMounted, ref} from "vue";

const props = defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const meta_data = ref({})

onMounted(() => {
    meta_data.value = props.modelValue
})

</script>

<template>
    {{ meta_data }}
    <JsonEditorVue
        v-model="meta_data"
        v-bind="{/* local props & attrs */}"
    />
</template>
