<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Profile from "@/Components/Profile.vue";
import Input from "@/Components/Input.vue";
import Submit from "@/Components/Submit.vue";
import {useForm} from "@inertiajs/vue3";
import Commentary from "@/Components/Commentary.vue";

defineProps({
    task: Object,
    users: Array,
    user: Object,
    authUser: Object,
    comments: Array,
})
function deleteTask(task)
{
    deleteTaskForm.id = task
    deleteTaskForm.delete('/tasks/delete');
}
function editStatus(status, task)
{
    editStatusForm.status = status;
    editStatusForm.task = task;
    editStatusForm.patch('/tasks/edit/status');
}
const editStatusForm = useForm({
    task: null,
    status: null,
})
const deleteTaskForm = useForm({
    id: null,
})
const editDeadlineForm = useForm({
    deadline: null,
})
const editUserForm = useForm({
    user: null,
})
</script>

<template>
    <AuthenticatedLayout>
    <div class="grid grid-cols-2 gap-6 items-center">
        <div class="bg-Silver p-6 rounded-xl shadow-2xl w-full items-center">
            <h2 class="text-2xl font-bold mb-4 text-D_Grey">Task: {{ task.title }}</h2>
            <div class="flex gap-4 mb-4 items-center">
                <form @submit.prevent="deleteTask(task.id)">
                    <button type="submit"
                            class="text-white bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none">
                        Delete task
                    </button>
                </form>
            </div>
            <h2 class="text-xl" >Status: {{ task.status }}</h2>

            <h2 class="text-xl mb-4">Deadline: {{ task.deadline }}</h2>

            <div class="flex flex-col gap-4">
                <div class="flex flex-row items-center gap-5">
                    <h2 class="text-xl">Task belongs to: </h2>
                    <Profile :user="user"></Profile>
                </div>
            </div>
        </div>
        <Commentary :task="task" :comments="comments" :authUser="authUser"></Commentary>
    </div>
        <div class="grid grid-cols-3 gap-5 mt-10">
            <div class="bg-Silver rounded-2xl flex flex-col items-center p-4 justify-center shadow-2xl">
                <h4 class="flex flex-row mb-4 items-center gap-3"><img src="../../../public/edit.png" alt="edit icon" width="40" height="40">Edit status:</h4>
                <div class="grid gap-10 grid-cols-2">
                    <form @submit.prevent="editStatus('not done', task.id)">
                        <Submit type="submit" value="To do"></Submit>
                    </form>
                    <form @submit.prevent="editStatus('in progress', task.id)">
                        <Submit type="submit" value="In progress"></Submit>
                    </form>
                    <form @submit.prevent="editStatus('completed', task.id)">
                        <Submit type="submit" value="Completed"></Submit>
                    </form>
                </div>
            </div>
            <form @submit.prevent="editDeadlineForm.patch(`/tasks/edit/deadline/${task.id}`)" class="bg-Silver flex flex-col items-center p-8 rounded-3xl shadow-2xl">
                <h4 class="flex flex-row mb-4 items-center gap-3"><img src="../../../public/edit.png" alt="edit icon" width="40" height="40">Edit Deadline:</h4>
                <Input type="date" name="deadline" value="{{ task.deadline }}" v-model="editDeadlineForm.deadline"></Input>
                <Submit type="submit" value="edit"></Submit>
            </form>
            <form @submit.prevent="editUserForm.patch(`/tasks/task/changeUser/${task.id}`)" class="bg-Silver flex flex-col items-center p-8 rounded-3xl shadow-2xl">
                <h4 class="flex flex-row mb-4 items-center gap-3"><img src="../../../public/edit.png" alt="edit icon" width="40" height="40">Edit User</h4>
                <select class="w-full p-2 border border-gray-300 rounded-md mb-5" name="userName" v-model="editUserForm.user">
                    <option v-for="user in users">{{ user.name }}</option>
                </select>
                <Submit type="submit" value="Change"></Submit>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
