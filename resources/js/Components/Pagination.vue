<template>
    <div class="flex gap-1 items-center">

        <Link 
            v-for="(link, index) in meta.links" 
            :key="index" 
            :href="link.url" 
            class="px-4 py-2 rounded-md"
            :class="{ 'bg-indigo-500 dark:bg-indigo-800 text-gray-300': link.active }" v-html="link.label" />
        <h3>Page {{ meta.current_page }}/{{ meta.last_page }}</h3>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3'
defineProps({
    meta: Object,
})
</script>