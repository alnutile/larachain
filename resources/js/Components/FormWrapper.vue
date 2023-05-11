<template>
    <div class="sm:flex p-2 mx-auto w-full justify-center">
        <div class="border border-gray-200 mt-10 p-4 rounded-lg shadow-lg bg-gray-100">
           <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormWrapper"
}
</script>

<style scoped>

</style>
