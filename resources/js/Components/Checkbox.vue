<script setup>
defineProps({
    modelValue: String,
    'type': String,
    'name': String,
    'placeholder': String,
})

defineEmits(['update:modelValue'])
</script>

<template>
    <input :type="type" :name="name"
           :placeholder="placeholder"
           class="cursor-pointer
                           p-2 border border-gray-300 rounded-md file:border-s file:bg-white file:cursor-pointer file:hover:bg-blue-400"
           :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>
