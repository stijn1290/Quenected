<script setup>
import Input from "@/Components/Input.vue";
import Submit from "@/Components/Submit.vue";
import {useForm} from "@inertiajs/vue3";

defineProps({
    step: Number,
})
const stepUpForm = useForm({
    step: null,
});
function nextStep() {
    stepUpForm.get('/nextStep');
}
</script>

<template>
    <div class="pt-80 pl-96 pr-96" v-if="step === 1">
        <div class="flex flex-col items-center bg-white rounded-3xl shadow-2xl">
            <h1 class="font-bold">Step {{ step }}/2</h1>
            <h1 class="text-4xl font-bold text-D_Grey">How are you planning to use Q-nect</h1>
            <div class="grid grid-cols-2 items-center gap-6 pt-5 pb-5">
                <form @submit.prevent="nextStep" class="pb-3">
                    <Input type="hidden" name="type" value="setup"></Input>
                    <Input type="hidden" name="name" value="none"></Input>
                    <Submit type="submit" name="skip" value="Free (recommended for individuals)"></Submit>
                </form>
                <form @submit.prevent="nextStep" class="pb-3">
                    <Input type="hidden" name="type" value="setup"></Input>
                    <Input type="hidden" name="name" value="none"></Input>
                    <Submit type="submit" name="skip" value="Q-nect teams (I want to use Q-nect for my business or team)"></Submit>
                </form>
            </div>
            <h2>Does your team manager already has an subscription: ask your team manager to invite you to get the benefits of teams</h2>
        </div>
    </div>
    <div class="pt-80 pl-96 pr-96" v-if="step === 2">
        <div class="flex flex-col items-center bg-white rounded-3xl shadow-2xl">
            <h1 class="font-bold">Step {{ step }}/2</h1>
            <h1 class="text-4xl font-bold">Choose your profile picture </h1>
            <form @submit.prevent="nextStep" class="pb-3">
                <Submit type="submit" name="skip" value="Skip"></Submit>
            </form>
            <form action="{{ route('setting.updateImage') }}" method="post" enctype="multipart/form-data"
                  class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/2">
                <h2 class="text-2xl font-bold mb-4">Choose your Profile Picture:</h2>
                <Input type="hidden" name="type" value="setup"></Input>
                <Input type="file" name="file" value=""></Input>
                <Submit type="submit" value="Choose"></Submit>
            </form>
        </div>
    </div>
    <div class="pt-80 pl-96 pr-96" v-if="step === 3">
        <div class="flex flex-row justify-center items-center gap-10 bg-white rounded-3xl shadow-2xl">
            <h1 class="text-4xl font-bold animate-bounce text-green">You Are done!!</h1>
            <a class="cursor-pointer p-2 bg-green text-white rounded-lg hover:bg-green-700" href="'/userStatistics'">Get Started</a>
        </div>
    </div>
</template>
