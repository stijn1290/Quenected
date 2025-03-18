<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Submit from "@/Components/Submit.vue";
import Input from "@/Components/Input.vue";
import {useForm} from "@inertiajs/vue3";
import DeleteSubmit from "@/Components/DeleteSubmit.vue";
defineProps({
    'normalUser': Boolean,
    'user': Object,
})
function deleteTasks(user)
{
    destroy.user_id = user;
    destroy.delete('/settings/delete-tasks');
}
function deleteUser(user)
{
    destroy.user_id = user;
    destroy.delete('/settings/delete-user');
}
const destroy = useForm({
    user_id: null,
})
const updateImage = useForm({
    file: null,
    type: "afterSetup",
})
const updatePassword = useForm({
    current: null,
    newPassword: null,
})
const updateEmail = useForm({
    newEmail: null,
})
const updateName = useForm({
    newName: null,
})
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="flex items-center text-3xl font-bold mb-6">
            <img src="../../../public/setting.png" alt="Settings Icon" class="w-12 h-12 mr-4">
            Settings
        </h1>
        <div class="flex flex-row gap-4">
            <form @submit.prevent="deleteTasks(user.id)" class="w-full">
                <DeleteSubmit :type="'submit'" :value="'Delete All Tasks'"></DeleteSubmit>
            </form>
            <form @submit.prevent="deleteUser(user.id)" method="post" class="w-full">
                <DeleteSubmit :type="'submit'" :value="'Delete Account'"></DeleteSubmit>
            </form>
            <form v-if="normalUser">
                <Submit :type="'submit'" :name="'submit'" :value="'Change plan to Q-nect plus'"></Submit>
            </form>
        </div>
        <div class="grid grid-cols-2 gap-6">
            <form @submit.prevent="updateImage.post('/settings/update-profile')"
                  class="bg-Silver p-6 rounded-xl shadow-2xl w-full">
                <h2 class="text-2xl font-bold mb-4">Change Profile Picture:</h2>
                <Input type="file" name="file" value="" v-model="updateImage.file"></Input>
                <Submit type="submit" value="Change"></Submit>
            </form>
            <form class="bg-Silver p-6 rounded-xl shadow-2xl w-full" @submit.prevent="updatePassword.patch('/settings/change-password')">
                <h2 class="text-2xl font-bold mb-4">Change Password:</h2>
                <Input type="password" name="current" placeholder="Current password" v-model="updatePassword.current"></Input>
                <Input type="password" name="newPassword" placeholder="New password" v-model="updatePassword.newPassword"></Input>
                <Submit :type="'submit'" :name="'submit'" :value="'Change'"></Submit>
            </form>
            <form class="bg-Silver p-6 rounded-xl shadow-2xl w-full" @submit.prevent="updateEmail.patch('/settings/change-email')">
                <h2 class="text-2xl font-bold mb-4">Change email:</h2>
                <Input type="name" name="newEmail" placeholder="New E-mailAddress" v-model="updateEmail.newEmail"></Input>
                <Submit type="submit" name="submit" value="Change"></Submit>
            </form>
            <form class="bg-Silver p-6 rounded-xl shadow-2xl w-full" @submit.prevent="updateName.patch('/settings/change-name')">
                <h2 class="text-2xl font-bold mb-4">Change Username:</h2>
                <Input type="name" name="newName" placeholder="New username" v-model="updateName.newName"></Input>
                <Submit type="submit" name="submit" value="Change"></Submit>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
