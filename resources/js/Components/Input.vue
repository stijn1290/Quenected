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
           class="w-full mb-4 p-2 border border-gray-300 rounded-md" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>
