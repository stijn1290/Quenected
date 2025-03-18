<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    'url': String,
    'profile': Boolean,
    'tasks': Array,
    'team': String,
    'user': Object,
    'teamUser': Boolean,
    'teamManager': Boolean,
})
</script>

<template>
    <AuthenticatedLayout>
    <h1 class="text-3xl font-bold mb-6">User:</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
        <div class="bg-Silver p-6 rounded-xl shadow-2xl flex flex-col items-center">
            <a class="mb-4">
                <img src="{{ url }}"
                     class="w-48 h-48 rounded-full object-cover border-gray-200"
                     alt="Profile picture" v-if="profile">
                <img src="../../../public/anonymous-picture.png"
                     class="w-48 h-48 rounded-full object-cover border-gray-200"
                     alt="Profile picture" v-else-if="!profile">
            </a>
            <h1 class="text-xl font-semibold">Name: {{ user.name }}</h1>
            <h1 class="text-lg">Team: {{ team }}</h1>
            <h1 class="text-lg" v-if="teamManager">Role: Team manager</h1>
            <h1 class="text-lg" v-if="teamUser">Role: Team member</h1>
        </div>
        <div class="bg-Silver p-6 rounded-xl shadow-2xl">
            <h1 class="text-xl font-semibold mb-4">Current Tasks: {{ tasks.length }}</h1>
            <ul class="space-y-2">
                <li class="flex items-center gap-2 text-lg" v-for="task in tasks">
                    <img src="../../../public/clipboards.png" alt="task icon" class="w-6 h-6">
                    {{ task.title }}
                </li>
            </ul>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
