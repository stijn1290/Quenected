<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Submit from "@/Components/Submit.vue";
import Profile from "@/Components/Profile.vue";
import {useForm} from "@inertiajs/vue3";

defineProps({
    'team': Object,
    'teamMembers': Array,
    'teamTasks': Array,
    'roles': Array,
    'teamManagers': Array,
})
const changeRole = useForm({
    role: null,
    userName: null,
})
function copyToClipboard(link) {
    navigator.clipboard.writeText(link);
    window.alert("The link is copied");
}
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="flex items-center gap-2 text-3xl font-bold text-D_Grey">
            <img src="../../../public/team.png" class="w-8 h-8">
            {{ team.name }}
        </h1>
        <div class="mb-5">
            <div class="flex flex-col gap-6 mt-4 text-D_Grey">
                <div class="flex items-center flex-col bg-Silver p-5 rounded-2xl shadow-2xl">
                    <h1 class="font-bold text-xl mb-4">Team manager(s):</h1>
                    <div class="grid 2xl:grid-cols-5 gap-10 grid-cols-2">
                        <Profile v-for="user in teamManagers" :user="user"></Profile>
                    </div>
                </div>
                <div class=" bg-Silver p-5 rounded-2xl w-full shadow-2xl text-D_Grey">
                    <h1 class="font-bold text-xl mb-4">Team members: </h1>
                    <div class="grid 2xl:grid-cols-4 gap-3 grid-cols-2">
                        <Profile v-for="user in teamMembers" :user="user"></Profile>
                        <button class="bg-green p-5 rounded-2xl w-full shadow-2xl text-white text-center"
                                @click="copyToClipboard(`localhost:8000/join/${team.id}`)">Invite other members
                        </button>
                    </div>
                </div>
                <div class="bg-Silver p-5 rounded-2xl w-full shadow-2xl text-D_Grey">
                    <h1 class="font-bold text-xl mb-4">Change roles:</h1>
                    <div class="flex flex-col ">
                        <h1>Make:</h1>
                        <form method="POST" @submit.prevent="changeRole.post('/user/changeTeamRole')">
                            <select class="w-full p-2 mb-4 border border-gray-300 rounded-md" name="userName" v-model="changeRole.userName">
                                <option v-for="user in teamMembers">{{ user.name }}</option>
                                <option v-for="user in teamManagers">{{ user.name }}</option>
                            </select>
                            <h1>An:</h1>
                            <select class="w-full p-2 mb-4 border border-gray-300 rounded-md" name="role" v-model="changeRole.role">
                                <option v-for="role in roles">{{ role.name }}</option>
                            </select>
                            <Submit :type="'submit'" :value="'Change role'"></Submit>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
