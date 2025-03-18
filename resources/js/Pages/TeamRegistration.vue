<script setup>
import {useForm} from "@inertiajs/vue3";
import Input from "@/Components/Input.vue";
import Submit from "@/Components/Submit.vue";

defineProps({
    'authenticated': Boolean,
    'team': Object,
})
const form = useForm({
    name: null,
    email: null,
    password: null,
    team_id: null,
})
function registration(team_id)
{
    form.team_id = team_id;
    form.post('/register/store');
}
</script>

<template>
    <div class="grid sm:grid-cols-[0.4fr_1.5fr] max-h-screen max-w-screen grid-cols-1" v-if="!authenticated">
        <div
            class="bg-white flex flex-col justify-center items-center text-black pr-7 pl-7 gap-5 shadow-2xl h-screen">
            <h2 class="text-4xl font-bold text-green">You are invited to use Q-nect by team: {{ team.name }}</h2>
        </div>
        <form @submit.prevent="registration(team.id)"
              class="bg-white flex flex-col justify-center items-center text-black pr-7 pl-7 gap-5 shadow-2xl h-screen">
            <img src="../../../public/qnect.png" class="w-40 h-40">
            <h1 class="text-4xl font-bold">Register</h1>
            <Input type="text" name="name" placeholder="Fill in your username" v-model="form.name"></Input>
            <Input type="email" name="email" placeholder="Fill in your e-mail address" v-model="form.email"></Input>
            <Input type="password" name="password" placeholder="Fill in your password" v-model="form.password"></Input>
            <Input type="hidden" name="team_id" v-model="form.team_id"></Input>
            <Submit type="submit" name="submit" value="Register"></Submit>
        </form>
    </div>
    <div class="bg-Silver flex flex-col justify-center items-center text-black pr-7 pl-7 gap-5 shadow-2xl h-screen" v-else>
        <h2>You have succesfully joined team: {{ team.name }} you can now use the functions of q-nect teams</h2>
        <a href="http://localhost:8000/userStatistics" class="cursor-pointer p-2 bg-green text-white rounded-lg hover:bg-green-700">Start now</a>
    </div>
</template>
