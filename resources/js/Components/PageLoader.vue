<script setup>
import { onBeforeUnmount, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ApplicationLogo from './ApplicationLogo.vue';

const CURTAIN_PATHS = ['/login', '/logout'];
const MIN_DURATION = 700;

const DELAY_PATHS = ['/logout'];
const CLOSE_DURATION = 500;

let bypass = false;

/* ---------- State ---------- */
const visible = ref(false);
let startedAt = 0;
let hideTimer = null;
let active = false;

const show = () => {
    clearTimeout(hideTimer);
    startedAt = Date.now();
    visible.value = true;
};

const hide = () => {
    const remaining = Math.max(0, MIN_DURATION - (Date.now() - startedAt));
    clearTimeout(hideTimer);
    hideTimer = setTimeout(() => (visible.value = false), remaining);
};

/* ---------- Event Inertia ---------- */
const offs = [
    // LOGOUT
    router.on('before', (event) => {
    if (bypass) {
        bypass = false;
        return;
    }

    const visit = event.detail.visit;
    const path = new URL(visit.url, window.location.origin).pathname;

    if (visit.method !== 'post' || !DELAY_PATHS.includes(path)) return;

    active = true;
    show();

    setTimeout(() => {
        bypass = true;
        router.visit(visit.url, { ...visit });
    }, CLOSE_DURATION);

    return false;
    }),

    // LOGIN
    router.on('start', (event) => {
        const { url, method } = event.detail.visit;
        const path = new URL(url, window.location.origin).pathname;

        if (method === 'post' && CURTAIN_PATHS.includes(path)) {
            active = true;
            show();
        }
    }),
    router.on('finish', () => {
        if (!active) return;
        active = false;
        hide();
    }),
];

onBeforeUnmount(() => {
    offs.forEach((off) => off());
    clearTimeout(hideTimer);
});
</script>

<template>
    <div
        class="pointer-events-none fixed inset-x-0 top-0 z-[200] flex items-center justify-center overflow-hidden bg-white transition-[height] duration-500 ease-in-out"
        :class="visible ? 'pointer-events-auto h-full' : 'h-0'"
    >
        <div v-show="visible" class="h-16 w-16 animate-bounce rounded-full bg-shopee flex p-2 ">
            <ApplicationLogo class="fill-[rgb(255,255,255)]"/>
        </div>
    </div>
</template>