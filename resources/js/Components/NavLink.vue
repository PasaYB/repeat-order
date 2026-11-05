<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    text: {
        type: String, 
        default: 'titti'
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-shopee text-shopee text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-shopee hover:mb-2 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:mb-2 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes" class="group relative">
      <slot />
        <span
            v-if="text"
            role="tooltip"
            class="pointer-events-none absolute left-1/2 bottom-[80%] z-50 mt-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-md bg-shopee px-2.5 py-1 text-xs font-medium text-white opacity-0 shadow-lg transition duration-150 group-hover:translate-y-0 group-hover:opacity-100 group-focus-visible:translate-y-0 group-focus-visible:opacity-100"
        >
            {{ text }}
        </span>
    </Link>
</template>