<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Submit from "@/Components/Submit.vue";
import Input from "@/Components/Input.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import DeleteSubmit from "@/Components/DeleteSubmit.vue";
import Profile from "@/Components/Profile.vue";
import CreateTask from "@/Components/CreateTask.vue";
import CreateProject from "@/Components/CreateProject.vue";

defineProps({
    'projects': Array,
    'teamManagers': Array,
    'users': Array,
    'team_id': Number,
    'user': Object,
})
const search = useForm({
    project: null,
    keyword: null,
    status: null,
})
const projectdelete = useForm({
    project: null,
})
const submitProject = (projectName) => {
    search.project = projectName;
    search.get(`/tasks/project`);
};
const deleteProject = (project) => {
    projectdelete.project = project;
    projectdelete.delete(`/project/delete`);
}
const {props} = usePage();
const auth = props.auth;
</script>

<template>
    <AuthenticatedLayout>
        <div class="grid grid-cols-[0.9fr_0.1fr] w-full justify-between">
            <h2 class="flex flex-row gap-5 font-bold text-2xl text-D_Grey items-center w-full mb-4">Projects:</h2>
            <CreateProject :teamManagers="teamManagers"></CreateProject>
        </div>
        <div class="grid sm:grid-cols-7 grid-cols-1 gap-5">
            <form
                class="bg-Silver rounded-2xl p-4 flex flex-col gap-4 shadow-2xl text-D_Grey cursor-pointer hover:bg-green hover:text-white"
                v-for="project in projects" @click="submitProject(project.id)">
                <h2 class="font-bold text-xl">{{ project.name }}</h2>
                <h2 class="font-bold text-xl" v-if="project.tasks">{{ project.tasks.length }} tasks</h2>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
