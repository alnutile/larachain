<template>
    <component :is=getIcon(icon) class="h-6 w-6 text-white" aria-hidden="true" />
</template>

<script>
import { resolveComponent } from "vue";
import {
    ArrowDownTrayIcon,
    ArrowsPointingInIcon,
    ArrowsRightLeftIcon,
    PhoneArrowUpRightIcon,
    ArrowUpTrayIcon,
    DocumentIcon,
    Bars4Icon,
    GlobeAltIcon,
    DocumentTextIcon,
    CalendarIcon,
    ChatBubbleLeftIcon, ClockIcon, MagnifyingGlassIcon, MegaphoneIcon, PhotoIcon, TableCellsIcon, ViewColumnsIcon
} from "@heroicons/vue/24/outline";

export default {
    name: "GetIcon",
    components: {
        Bars4Icon,
        DocumentIcon,
        GlobeAltIcon,
        PhoneArrowUpRightIcon,
        DocumentTextIcon,
        ArrowDownTrayIcon,
        resolveComponent,
        ChatBubbleLeftIcon,
        ArrowsRightLeftIcon,
        ArrowsPointingInIcon,
        CalendarIcon,
        ClockIcon,
        PhotoIcon,
        ArrowUpTrayIcon,
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
