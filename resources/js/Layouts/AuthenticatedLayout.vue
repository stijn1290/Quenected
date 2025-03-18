<script setup>
import {Head} from '@inertiajs/vue3';
import LogoLink from "@/Components/LogoLink.vue";
import {usePage} from '@inertiajs/vue3';

function sidebarToggle() {
    let sidebar = document.querySelectorAll(".hiddenText");
    sidebar.forEach(item => {
        if (item.style.display === "none" || item.style.display === "") {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}

const {props} = usePage();
const auth = props.auth;
</script>

<template>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Q-nect</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&display=swap" rel="stylesheet">
        <link rel="icon" href="/qnect.png">
    </head>
    <body class="bg-white" id="body">
    <header
        class="bg-Silver lg:fixed md:top-0 lg:h-svh lg:flex lg:flex-col lg:justify-around lg:items-center lg:pl-4 lg:pr-4 fixed bottom-0 w-full left-0 flex flex-row gap-3 sm:flex sm:flex-row justify-between sm:w-fit shadow-2xl">
        <LogoLink :link="'/projects'" v-if="!auth.admin">
            <img src="../../../public/qnect.png" class="sm:w-10 sm:h-10 w-4 h-4">
        </LogoLink>
        <LogoLink :link="'/projects'" v-if="!auth.admin">
            <img src="../../../public/project.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Projects</h3>
        </LogoLink>
        <LogoLink :link="'/team'" v-if="auth.teamUser || auth.teamManager">
            <img src="../../../public/team.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Team</h3>
        </LogoLink>
        <LogoLink :link="'/settings'" v-if="!auth.admin">
            <img src="../../../public/setting.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Settings</h3>
        </LogoLink>
        <LogoLink :link="'/admin/users'" v-if="auth.admin">
            <img src="../../../public/team.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Users</h3>
        </LogoLink>
        <LogoLink :link="'/admin/teams'" v-if="auth.admin">
            <img src="../../../public/team.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Teams</h3>
        </LogoLink>
        <LogoLink :link="'/logout'">
            <img src="../../../public/logout.png" class="sm:w-10 sm:h-10 w-4 h-4">
            <h3 class="hiddenText">Logout</h3>
        </LogoLink>
    </header>
    <div class="2xl:max-w-[1200px] min-[1810px]:max-w-[1500px] mx-auto my-10 flex flex-col items-center max-w-3xl">
        <div class="sm:flex flex-row self-start gap-10 hidden">
            <img src="../../../public/menu.png" class="w-8 h-8 cursor-pointer mb-4"
                 @click="sidebarToggle">
        </div>
        <slot/>
    </div>
    </body>
</template>
<style scoped>
.hiddenText {
    display: none;
}
</style>
