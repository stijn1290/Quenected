<script setup>
import Submit from "@/Components/Submit.vue";
import {useForm} from "@inertiajs/vue3";
import Input from "@/Components/Input.vue";

defineProps({
    'task': Object,
    'comments': Array,
    'user': Number,
    'authUser': Object,
})
const newCommentForm = useForm({
    summary: null,
    team_id: null,
    user_id: null,
    task: null,
})

function newComment(teamId, user, task) {
    newCommentForm.user_id = user;
    newCommentForm.team_id = teamId;
    newCommentForm.task = task;
    newCommentForm.post('/comment/create');
}
</script>

<template>
    <div class="grid grid-cols-1 items-center bg-Silver p-6 rounded-xl shadow-2xl">
        <h2 class="text-D_Grey text-2xl font-semibold">Activity</h2>
        <form @submit.prevent="newComment(authUser.team.id, authUser.id, task.id)"
              class="w-full flex flex-row">
                <Input v-model="newCommentForm.summary"></Input>
            <Submit type="submit" value="Add commentary"></Submit>
        </form>
        <div class="flex flex-col gap-5 mt-4">
            <div class="flex flex-row items-center gap-1" v-for="comment in comments">
                <h1 class="font-bold">{{ comment.user.name }}:</h1>
                <p> {{ comment.description }}</p>
            </div>
        </div>
    </div>
</template>
