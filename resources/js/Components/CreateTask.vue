<script setup>
import Input from "@/Components/Input.vue";
import Submit from "@/Components/Submit.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

defineProps({
    'users': Array,
    'authUser': Object,
    'projects': Array,
})
const task = useForm({
    'title': null,
    'description': null,
    'deadline': null,
    'project': null,
    'user': null,
    'status': "not done"
})
const teleport = ref(false);
</script>

<template>
    <div class="flex flex-row items-center gap-3 self-start mb-4 cursor-pointer" v-on:click="teleport = true">
        <h1 class="text-5xl text-green hover:text-D_Grey">+</h1>
        <h2 class="text-gray-500 mt-1 hover:text-green">New task</h2>
    </div>
    <teleport to="body" v-if="teleport">
        <div class="fixed inset-0 bg-Silver bg-opacity-50 "></div>
        <form @submit.prevent="task.post('/task/create')"
              class="fixed top-24 left-96 right-96 bg-Silver rounded-2xl p-7 shadow-2xl inset-0 h-fit">
            <div class="flex flex-row items-center gap-2">
                <img src="../../../public/remove.png" width="50" height="5" class="cursor-pointer" @click="teleport = false">
                <h4 class="font-bold text-2xl">Create Task</h4>
            </div>
            <Input type="hidden" value="afterSetup" name="type"></Input>
            <h4 class="self-start">Title:</h4>
            <Input type="text" placeholder="title" name="title" required v-model="task.title"></Input>
            <h4 class="self-start">Description:</h4>
            <Input type="text" placeholder="description" name="description" required v-model="task.description"></Input>
            <Input type="hidden" name="status" v-model="task.status"></Input>
            <!--            @if($authUser->hasRole('teamManager'))-->
            <h4 class="self-start">User:</h4>
            <select name="user" class="w-full p-2 border border-gray-300 rounded-md mb-4" v-model="task.user">
                <option v-for="user in users">{{ user.name }}</option>
            </select>
            <!--            @else-->
            <!--            <x-input type="hidden" name="user_id" value="{{ $authUser->id }}"></x-input>-->
            <!--            @endif-->
            <h4 class="self-start">Deadline:</h4>
            <Input type="date" name="deadline" min="2024-10-01" max="2026-12-31" v-model="task.deadline"></Input>
            <h4 class="self-start">Project:</h4>
            <select name="project" class="w-full p-2 border border-gray-300 rounded-md mb-4" v-model="task.project">
                <option v-for="project in projects">{{ project.name }}</option>
            </select>
            <Submit :type="'submit'" :value="'Create'"></Submit>
        </form>
    </teleport>
</template>
