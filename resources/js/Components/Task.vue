<script setup>
import Profile from "@/Components/Profile.vue";
import {useForm} from "@inertiajs/vue3";
import FullTask from "@/Pages/FullTask.vue";

function fullTask(task) {
    taskFunction.task = task;
    taskFunction.get('/task/fullTask');
}

const taskFunction = useForm({
    task: null,
    instance: "taskPage",
})
const editTitle = useForm({
    title: null,
    id: null,
})
function editTitleResponse(title, id) {
    editTitle.title = title;
    editTitle.id = id;
    editTitle.patch("/tasks/edit/title");
}

defineProps({
    'tag': Boolean,
    'taskTitle': String,
    'taskDeadline': String,
    'data': Number,
    'user': Object,
    'task': Object,
});
</script>

<template>
    <div class="flex flex-col items-center gap-4 p-6 rounded-xl shadow-2xl bg-Silver cursor-pointer hover:bg-white"
         :data-task-id="data" v-if="!tag">
        <h1 class="font-extrabold text-xl text-D_Grey" contenteditable spellcheck="false"
            @blur="editTitleResponse($event.target.innerText, task.id)">{{ taskTitle }}</h1>
        <Profile :user="user"></Profile>
        <div class="flex flex-row items-center">
            <p class="text-D_Grey">Deadline: <b>{{ taskDeadline }}</b></p>
            <button class="cursor-pointer p-2 bg-gray-500 text-white rounded-lg hover:bg-green"
                    @click="fullTask(task.id)">
                More
            </button>
        </div>
    </div>
</template>
