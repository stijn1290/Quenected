<script setup>

import Submit from "@/Components/Submit.vue";
import Input from "@/Components/Input.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";

defineProps({
    'teamManagers': Array,
})
const newProject = useForm({
    name: null,
    user: null,
})
const {props} = usePage();
const auth = props.auth;
const teleport = ref(false);
</script>

<template>
    <Submit v-on:click="teleport = true" :value="'New Project'" :type="''" :name="'teleport'">+</Submit>
    <teleport to="body" v-if="teleport">
        <div class="fixed inset-0 bg-Silver bg-opacity-50 "></div>
        <form class="fixed top-64 left-96 right-96 bottom-52 bg-Silver rounded-2xl p-7 shadow-2xl inset-0"
              @submit.prevent="newProject.post('/project/create')">
            <div class="flex flex-row items-center gap-2">
                <img src="../../../public/remove.png" width="50" height="5" class="cursor-pointer" @click="teleport = false">
                <h4 class="font-bold text-2xl text-D_Grey">New Project</h4>
            </div>
            <Input type="text" name="name" placeholder="Project name" v-model="newProject.name"></Input>
            <h1 v-if="!auth.normalUser">Project manager:</h1>
            <select class="w-full mb-4 p-2 border border-gray-300 rounded-md" name="user" v-model="newProject.user"
                    v-if="!auth.normalUser">
                <option v-for="teamManager in teamManagers">{{ teamManager.name }}</option>
            </select>
            <Submit type="submit" value="Create"></Submit>
        </form>
    </teleport>
</template>

<style scoped>

</style>
