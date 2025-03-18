<script setup>
defineProps({
    'user': Object,
})
</script>

<template>
    <a class="flex flex-row items-center gap-5" :href="`/profile/${user.id}`">
        <img src="../../../public/anonymous-picture.png" class="rounded-full w-12 h-12">
        <h4 class="text-D_Grey font-semibold">{{ user.name }}</h4>
    </a>
</template>
