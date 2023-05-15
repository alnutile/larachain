<template>
    <div class=" -mb-1 w-full">
        <nav
            class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
            aria-label="Pagination">
            <div class="hidden sm:block">
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from }}</span>
                    to
                    <span class="font-medium">{{ meta.to }}</span>
                    of
                    <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>
            <div class="flex flex-1 justify-between sm:justify-end">
                <Link
                    v-if="!meta.prev_page_url"
                    class="
                                        opacity-50 hover:cursor-not-allowed
                                        relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Previous
                </Link>
                <Link
                    v-else="meta.prev_page_url"
                    :href="meta.prev_page_url"
                    class="
                                        relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Previous
                </Link>

                <Link
                    v-if="!meta.next_page_url"
                    class="
                                        opacity-50 hover:cursor-not-allowed
                                        relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Next
                </Link>
                <Link v-else
                      :href="meta.next_page_url"
                      class="
                                       hover:cursor-pointer
                                       relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Next
                </Link>
            </div>
        </nav>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    name: "SimplePaginate",
  components: {
    Link,
  },
  props: {
    meta: {}
  },
}
</script>
