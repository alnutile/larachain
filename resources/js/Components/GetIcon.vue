<template>
    <component :is=getIcon(icon) class="h-6 w-6 text-white" aria-hidden="true" />
</template>

<script>
import { resolveComponent } from "vue";
import {
    ArrowDownTrayIcon,
    ArrowsPointingInIcon,
    ArrowsRightLeftIcon,
    DocumentIcon,
    Bars4Icon,
    DocumentTextIcon,
    CalendarIcon,
    ChatBubbleLeftIcon, ClockIcon, MagnifyingGlassIcon, MegaphoneIcon, PhotoIcon, TableCellsIcon, ViewColumnsIcon
} from "@heroicons/vue/24/outline";

export default {
    name: "GetIcon",
    components: {
        Bars4Icon,
        DocumentIcon,
        DocumentTextIcon,
        ArrowDownTrayIcon,
        resolveComponent,
        ChatBubbleLeftIcon,
        ArrowsRightLeftIcon,
        ArrowsPointingInIcon,
        CalendarIcon,
        ClockIcon,
        PhotoIcon,
        TableCellsIcon,
        ViewColumnsIcon,
        MegaphoneIcon,
        MagnifyingGlassIcon
    },
    props: ['icon'],
    methods: {
        getIcon(icon){
            return resolveComponent(icon);
        }
    }
}
</script>

<style scoped>

</style>
