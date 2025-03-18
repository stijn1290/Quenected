<script setup>
import Input from "@/Components/Input.vue";
import Submit from "@/Components/Submit.vue";
import LoginLink from "@/Components/LoginLink.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    email: null,
    password: null,
})
</script>

<template>
    <GuestLayout>
        <a href="http://localhost:5174" class="flex flex-row items-center gap-2 p-6">
            <img src="../../../public/qnect.png" alt="qnect Icon" class="w-20 h-20">
            <h2 class="hover:text-green text-D_Grey text-2xl font-medium">uenected</h2>
        </a>
    <div class="flex flex-row sm:justify-center pt-40">
        <form @submit.prevent="form.post('/login/user')"
              class="bg-Silver flex flex-col justify-center  text-black gap-3 shadow-green shadow-2xl p-12 rounded-3xl h-max sm:w-1/4">
            <h1 class="text-4xl font-bold text-D_Grey">Sign in</h1>
            <Input :type="'email'" :name="'email'" :placeholder="'Email'" v-model="form.email"></Input>
            <Input :type="'password'" :name="'password'" :placeholder="'Password'" v-model="form.password"></Input>
            <Submit :type="'submit'" :name="'submit'" :value="'Sign in'"></Submit>
            <LoginLink :link="'/resetPassword'" :text="'Forgot Password'"></LoginLink>
            <a class="bg-white border border-gray-500 text-gray-500 shadow-2xl rounded-lg p-2 flex flex-row items-center gap-3 self-center"
               href="/"><img src="../../../public/google.png" class="w-6 h-6">Continue
                with google</a>
            <LoginLink :type="'login'" :link="'/register'" :text="'Are you new here register now!!'"></LoginLink>
        </form>
    </div>
    </GuestLayout>
</template>
