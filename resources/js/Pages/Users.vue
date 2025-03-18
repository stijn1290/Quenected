<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
function changePermissions(user) {
    permissionForm.user_id = user;
    permissionForm.get('/admin/users/permissions');
}
const permissionForm = useForm({
    user_id: null
});
defineProps({
    users: Array,
})

</script>

<template>
    <AuthenticatedLayout>
    <h1 class="font-bold text-4xl">Users: </h1>
    <div class="grid grid-cols-2 gap-10">
        <div class="flex flex-col bg-Silver rounded-3xl p-10 shadow-2xl" v-for="user in users">
            <h1>Name: {{user.name }}</h1>
            <h1>Email: {{ user.email }}</h1>
            <form @submit.prevent="changePermissions(user.id)" class="cursor-pointer w-full py-2 bg-green text-white rounded-lg hover:bg-green-700">
                <button type="submit" class="cursor-pointer w-full bg-green text-white rounded-lg hover:bg-green-700">Change permissions</button>
            </form>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
