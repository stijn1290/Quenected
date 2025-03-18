<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    teams: Array,
})
</script>

<template>
    <AuthenticatedLayout>
    <h1 class="text-4xl font-bold mb-4 text-D_Grey">Teams:</h1>
    <div class="grid grid-cols-1 gap-10">
        <div class="bg-Silver rounded-3xl p-10 shadow-2xl" v-for="team in teams">
            <h1 class="text-2xl font-bold text-D_Grey">Name: {{team.name }}</h1>
            <h1 class="text-2xl font-bold mb-3 mt-3 text-D_Grey">Users: {{ team.users.length }}</h1>
            <div class="grid grid-cols-6 gap-5 bg-green rounded-2xl p-4">
                <h1 class="text-xl font-semibold text-white" v-for="user in team.users">{{ user.name }}</h1>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
