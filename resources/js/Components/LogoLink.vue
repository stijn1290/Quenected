<script setup>
defineProps({
    'link': String,
})
</script>

<template>
    <a :href="link" class="text-gray-700 sm:flex sm:flex-row flex flex-col gap-1 sm:gap-5 items-center hover:transform hover:scale-125 sm:text-lg font-bold text-xs" v-preload="link">
        <slot/>
    </a>
</template>
