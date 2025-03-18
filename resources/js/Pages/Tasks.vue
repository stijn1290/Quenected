<script setup>
import Input from "@/Components/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Submit from "@/Components/Submit.vue";
import Task from "@/Components/Task.vue";
import CreateTask from "@/Components/CreateTask.vue";
import {useForm} from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";

defineProps({
    completedTasks: Array,
    inProgressTasks: Array,
    toDoTasks: Array,
    user: Object,
    tags: Array,
    projects: Array,
    users: Array,
    activeProject: Object,
});
const search = useForm({
    project: null,
    keyword: null,
    status: null,
})
function searchInProject(project)
{
    search.project = project;
    search.get('/tasks/search');
}
</script>

<template>
    <AuthenticatedLayout>
        <form @submit.prevent="searchInProject(activeProject.id)"
              class="flex flex-col lg:w-full lg:items-center gap-2 mb-4 ">
            <div class="flex sm:flex-row gap-3 flex-col">
                <h2 class="text-4xl text-D_Grey font-extrabold" v-if="activeProject">{{ activeProject.name }}</h2>
                <div class="rounded-xl shadow-2xl bg-Silver flex flex-row gap-3 p-3 items-center">
                    <h2 class="text-gray-500 ">Status: </h2>
                    <label for="status">Todo</label>
                    <Checkbox type="checkbox" name="status" value="To do"
                              class="cursor-pointer p-2 border border-gray-300 rounded-md file:border-s file:bg-white file:cursor-pointer file:hover:bg-blue-400"
                              v-model="search.status"></Checkbox>
                    <label for="status">InProgress</label>
                    <Checkbox type="checkbox" name="status" value="In progress"
                              class="cursor-pointer p-2 border border-gray-300 rounded-md file:border-s file:bg-white file:cursor-pointer file:hover:bg-blue-400"
                              v-model="search.status"></Checkbox>
                    <label for="status">Completed</label>
                    <Checkbox type="checkbox" name="status" value="Completed"
                              class="cursor-pointer p-2 border border-gray-300 rounded-md file:border-s file:bg-white file:cursor-pointer file:hover:bg-blue-400"
                              v-model="search.status"></Checkbox>
                </div>
            </div>
            <Input type="text" name="keyword" placeholder="Search a task"
                   class="w-full p-2 border border-gray-300 rounded-md" v-model="search.keyword"></Input>
            <Submit :type="'submit'" name="submit" value="Search..."></Submit>
        </form>
        <CreateTask :users="users" :projects="projects" :authUser="user"></CreateTask>
        <div class="lg:grid 2xl:grid-cols-3 lg:gap-8 flex flex-col">
            <div class="box-content">
                <h1 class="flex items-center gap-2">
                    <img src="../../../public/toDo.png" alt="to do icon" class="w-12 h-12">
                    <span class="text-4xl font-bold text-D_Grey">To do</span>
                </h1>
                <div class="grid grid-cols-2 gap-4 mt-5 items-center" id="not done">
                    <Task :taskTitle="task.title" :taskDeadline="task.deadline" :tag="false" :user="task.user"
                          :data="task.id" v-for="task in toDoTasks" :task="task"></Task>
                    <p class="text-gray-500 mt-2" v-if="toDoTasks.length === 0">None</p>
                    <p class="text-gray-500 mt-2" v-if="toDoTasks = null">None</p>
                </div>
            </div>
            <div class="box-content">
                <h1 class="flex items-center gap-2">
                    <img src="../../../public/workInProgress.png" alt="checked icon" class="w-12 h-12">
                    <span class="text-4xl font-bold text-D_Grey ">In progress</span>
                </h1>
                <div class="grid grid-cols-2 gap-4 mt-5 items-center" id="in progress">
                    <Task :taskTitle="task.title" :taskDeadline="task.deadline" :tag="false" :user="task.user"
                          :data="task.id" v-for="task in inProgressTasks" :task="task"></Task>
                    <p class="text-gray-500 mt-2" v-if="inProgressTasks.length === 0">None</p>
                    <p class="text-gray-500 mt-2" v-if="toDoTasks = null">None</p>
                </div>
            </div>
            <div class="box-content">
                <h1 class="flex items-center gap-2">
                    <img src="../../../public/checkMark.png" alt="checked icon" class="w-12 h-12">
                    <span class="text-4xl font-bold text-D_Grey">Completed</span>
                </h1>
                <div class="grid grid-cols-2 gap-4 mt-5 items-center" id="completed">
                    <Task :taskTitle="task.title" :taskDeadline="task.deadline" :tag="false" :user="task.user"
                          :data="task.id" v-for="task in completedTasks" :task="task"></Task>
                    <p class="text-gray-500 mt-2" v-if="completedTasks.length === 0">None</p>
                    <p class="text-gray-500 mt-2" v-if="completedTasks = null">None</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
