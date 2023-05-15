<template>
    <div class="flex gap-3">
        <div>
            <InputLabel for="urls" >Search for</InputLabel>
            <div class="flex flex-col gap-2">
                <div class="mt-2 flex justify-start" v-for="(searchItem, index) in modelValue.meta_data['search']" >
                    <TextInput type="text" v-model="modelValue.meta_data['search'][index]" :tabindex="index"/>
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
                <div class="mt-2 flex justify-start gap-2" v-for="(index) in replace" >
                    <TextInput type="text" v-model="modelValue.meta_data['replace'][index]" />
                    <button @click="removeSearchItem(index)" type="button" class="bg-red-500 p-2">
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

const search = ref([])
const replace = ref([])
const newSearchItem = ref("")
const newReplaceItem = ref("")

const addSearchItem = () => {
    emit("update:modelValue.meta_data['search']", newSearchItem.value)
    search.value.push(newSearchItem.value)
    replace.value.push("REPLACE_WITH")
    newSearchItem.value = "";
}

const removeSearchItem = (index) => {
    emit("removeSearchItem", index)

}

onMounted(() => {
    search.value = props.modelValue.meta_data.search;
    replace.value = props.modelValue.meta_data.replace;
})



</script>

<style scoped>

</style>
