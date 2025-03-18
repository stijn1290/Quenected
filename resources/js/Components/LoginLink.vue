<script setup>
defineProps({
    'link': String,
    'text': String,
})
</script>

<template>
    <a :href="link" class="text-D_Grey no-underline self-center">{{ text }}</a>
</template>
