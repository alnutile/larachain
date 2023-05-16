<template>
    <div class="flex gap-3">
        <div class="flex flex-col gap-4 col-span-6">
            <InputLabel value="Token Limit"/>
            <TextInput
                type="number"
                autofucus
                v-model="modelValue.meta_data.token_limit"
            ></TextInput>
            <InputError
                :message="modelValue.errors.meta_data"
            ></InputError>
        </div>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {onMounted, ref, defineEmits} from "vue";

const emit = defineEmits(['update:modeValue']);
const props = defineProps({
    modelValue: Object
})




</script>

<style scoped>

</style>
