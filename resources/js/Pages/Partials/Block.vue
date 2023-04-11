<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="flex items-center">
            <slot name="icon">

            </slot>
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                <slot name="title_link"></slot>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            <slot name="description"></slot>
        </p>

        <p class="mt-4 text-sm">
            <slot name="exit_link"></slot>
        </p>
    </div>
</template>
