<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>    
    <div
        class="relative flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 overflow-hidden"
    >
    <div class="absolute aspect-[2/1] w-full rounded-t-full -bottom-[40rem] bg-shopee"/>

    <div class="flex flex-col mt-6 w-full items-center overflow-hidden bg-white/50 backdrop-blur-md sm:max-w-lg px-6 py-4 z-20 shadow-2xl sm:rounded-2xl">
        <img src="nasgor.png" alt="nasgor" class="size-40">
        
        <div
            class="w-full px-6 py-4"
        >
            <slot />
        </div>
    </div>
    </div>
</template>
