<script setup>
defineProps({
    'type': String,
    'name': String,
    'placeholder': String,
    'value': String,
})
</script>

<template>
    <input :type="type" :name="name"
           class="cursor-pointer w-full p-2 bg-red-600 text-white rounded-lg hover:bg-red-700" :value="value">
</template>
