<template>
    <div class="col-span-6">
        <div class="col-span-6 sm:col-span-6 ">
            <div class="mb-2 text-gray-400">
                You can add mappings to grab the data you want (optional!)
            </div>

            <div class="bg-gray-100 p-2 border border-gray-900 rounded-lg mb-2">
                Map some of the data to be saved (or not). For example if the data comes in like this:

                <pre class="p-6 bg-gray-800 text-white rounded-md overflow-auto"><code>{
    payload:
    {
      committer: "foo bar",
      date: "2023-01-05",
      comment: "Foo bar", some_info: "Do not care"
    }
}</code>
</pre>
                You can then add 3 mappings below
                <ul class="list-disc ml-12">
                    <li>payload.committer</li>
                    <li>payload.date</li>
                    <li>payload.comment</li>
                </ul>

                This would result in:

                <pre class="p-6 bg-gray-800 text-white rounded-md overflow-auto"><code>{
   committer: "Foo bar",
   date: "2023-01-05",
   comment: "Foo bar"
}</code>
</pre>

                <div class="mt-2 flex justify-start">
                    It uses Laravel's <strong> <a
                    class="flex justify-start gap-2 items-center inline-block mr-2 ml-1"
                    href="https://laravel.com/docs/10.x/helpers#method-data-get" target="_blank">data_get<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg></a></strong> so anything you can do here just add as a line.
                </div>
            </div>
        </div>

        <div v-if="mappings.length === 0">
            No mappings add one if you want
        </div>
        <div class="text-gray-800 text-lg mt-2 mb-2 w-[400px] flex mt-4">Add a Mapping</div>
        <div class="flex justify-content-start gap-2">
            <button @click="addMapping">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
            <input
                type="text"
                class=""
                v-model="new_mapping" placeholder="item.data"/>
        </div>
        <div class="text-gray-800 text-lg mt-2 mb-2 w-[400px] flex mt-4">Existing mappings</div>
       <div class="">
           <div v-for="(mapping, index) in mappings" class="flex justify-start gap-2 border-gray-300 border rounded-md p-4 mb-4 bg-gray-100">
               <button @click="removeMapping(index)">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                       <path stroke-linecap="round" stroke-linejoin="round"
                             d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                   </svg>
               </button>
               {{ mapping }}
           </div>
       </div>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import {onMounted, ref} from "vue";

const emit = defineEmits(['update:modeValue', 'removedMapping', 'addedMapping']);

const props = defineProps({
    modelValue: Object
})

const mappings = ref([]);

onMounted(() => {
    mappings.value = props.modelValue.mappings;
})

const new_mapping = ref(null)

const addMapping = () => {
    mappings.value.push(new_mapping.value);
    emit('addedMapping', mappings.value)
    new_mapping.value = "";
}

const removeMapping = (mapping) => {
    mappings.value.splice(mapping, 1);
    emit('removedMapping', mappings.value)
}

</script>

<style scoped>

</style>
