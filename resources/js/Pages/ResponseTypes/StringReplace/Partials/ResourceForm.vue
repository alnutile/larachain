<template>
    <div class="flex gap-3">
        <div>
            <InputLabel for="urls" >Search for</InputLabel>
            <div class="flex flex-col gap-2">
                <div class="mt-2 flex justify-start" v-for="(searchItem, searchIndex) in modelValue.meta_data['search']" :key="searchItem" >
                    <TextInput type="text" v-model="modelValue.meta_data['search'][searchIndex]"/>
                </div>
            </div>
            <div class="mt-2 flex justify-start">
                <TextInput v-model="newSearchItem" type="text" class="rounded-0"/>
                <button @click="addSearchItem" type="button" class="bg-red-500 p-2 ml-2">
                    <PlusIcon class="w-5 h-5 text-white"></PlusIcon>
                </button>
            </div>
            <InputError :message="modelValue.errors?.meta_data" class="mt-2" />
        </div>
        <div>
            <InputLabel for="urls" >Replace With</InputLabel>
            <div class="flex flex-col gap-2">
                <div class="mt-2 flex justify-start gap-2" v-for="(replaceIndex) in replace" :key="replaceIndex">
                    <TextInput type="text" v-model="modelValue.meta_data['replace'][replaceIndex]" />
                    <button @click="removeSearchItem(replaceIndex)" type="button" class="bg-red-500 p-2">
                        <MinusIcon class="w-5 h-5 text-white"></MinusIcon>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import JsonArea from '@/Components/JsonArea.vue';
import JsonEditorVue from 'json-editor-vue'
import {onMounted, ref, defineEmits} from "vue";
import { PlusIcon, MinusIcon } from "@heroicons/vue/24/solid"

const emit = defineEmits(['update:modeValue']);
const props = defineProps({
    modelValue: Object
})

const replace = ref([])
const newReplaceItem = ref("")
const newSearchItem = ref("")

const addSearchItem = () => {
    emit("update:modelValue.meta_data['search']", newSearchItem.value)
}

const removeSearchItem = (index) => {
    emit("removeSearchItem", index)
}

onMounted(() => {
    replace.value = props.modelValue.meta_data.replace;
})



</script>

<style scoped>

</style>
