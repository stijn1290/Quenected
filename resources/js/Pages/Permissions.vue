<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Submit from "@/Components/Submit.vue";
import {useForm} from "@inertiajs/vue3";
import DeleteSubmit from "@/Components/DeleteSubmit.vue";

defineProps({
    'user': Object,
    'role': String,
    'roles': Array,
    'teams': Array,
    'permissions': Array,
})
const permissionForm = useForm({
    submitValue: null,
    permissionName: null,
    userId: null,
})
const roleForm = useForm({
    newRole: null,
    userId: null,
})
function changePermission(permissionName, submitValue, user) {
    permissionForm.permissionName = permissionName;
    permissionForm.submitValue = submitValue;
    permissionForm.userId = user;
    permissionForm.patch('/admin/users/permissions/changePermission');
}
function changeRole(user) {
    roleForm.userId = user;
    roleForm.patch('/admin/changeRole');
}
</script>

<template>
    <AuthenticatedLayout>
        <h2 class="text-4xl font-bold text-D_Grey mb-5">{{ user.name }}</h2>
        <div class="grid grid-cols-3 gap-5 mb-4">
            <div class="bg-Silver rounded-2xl p-10 shadow-2xl">
                <h1 class="text-2xl font-bold text-D_Grey">Current role:</h1>
                <h1 class="text-xl text-D_Grey">{{ role }}</h1>
            </div>
            <div class="bg-Silver rounded-2xl p-10 shadow-2xl">
                <h1 class="text-2xl font-bold text-D_Grey">Change role:</h1>
                <form @submit.prevent="changeRole(user.id)">
                    <select class="w-full mb-4 p-2 border border-gray-300 rounded-md" name="newRole" v-model="roleForm.newRole">
                        <option v-for="role in roles">{{ role.name }}</option>
                    </select>
                    <Submit type="submit" value="Change"></Submit>
                </form>
            </div>
            <div class="bg-Silver rounded-2xl p-10 shadow-2xl">
                <h1 class="text-2xl font-bold text-D_Grey">Current team:</h1>
                <h1 class="text-xl text-D_Grey">{{ user.team.name }}</h1>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-D_Grey">Permissions:</h1>
        <h3 class="text-red-600">You cannot revoke a permission that belongs to the current role consider changing the role
            if you still want to change that specific permission</h3>
        <div class="grid grid-cols-4 gap-5">
            <div class="bg-Silver rounded-xl p-5 shadow-2xl" v-for="permission in permissions">
                <h1 class="text-D_Grey font-bold">{{ permission.name }}</h1>
                <div class="flex flex-row gap-5">
                    <form @submit.prevent="changePermission(permission.name, 'YES', user.id)" class="w-full">
                        <Submit type="submit" value="YES" name="submit"></Submit>
                    </form>
                    <form @submit.prevent="changePermission(permission.name, 'NO', user.id)" class="w-full">
                        <DeleteSubmit type="submit" value="NO" name="submit"></DeleteSubmit>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
