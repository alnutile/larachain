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
            class="bg-gray-100 text-gray-800 px-2 py-1 ml-1 rounded ring
                            ring-1
                            ring-gray-200"
    >
        <slot />
    </button>
</template>
