<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type"
            class="bg-red-500 text-gray-200 px-2 ml-1 py-1 rounded ring
                            ring-1
                            ring-red-200"
    >
        <slot />
    </button>
</template>
