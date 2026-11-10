<script setup>
import { onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps({
    initialSearch: {
        type: String,
        default: '',
    },
});
const emit = defineEmits(['search']);
const search = ref(props.initialSearch);
let searchTimeout;

const submitSearch = () => {
    emit('search', search.value.trim());
};

const handleInput = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(submitSearch, 500);
};

const clearSearch = () => {
    search.value = '';
    emit('search', '');
};

watch(
    () => props.initialSearch,
    (value) => {
        search.value = value;
    },
);

onBeforeUnmount(() => clearTimeout(searchTimeout));
</script>

<template>
    <div class="relative w-full px-2 sm:px-0">
        <button
            type="button"
            class="absolute left-4 top-1/2 -translate-y-1/2 p-1"
            @click="submitSearch"
        >
            <svg
            width="17"
            height="16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            role="img"
            aria-labelledby="search"
            class="w-5 h-5 text-gray-700"
            >
            <path
                d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                stroke="currentColor"
                stroke-width="1.333"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></path>
            </svg>
        </button>
        <input
            class="w-full rounded-full border-2 border-transparent bg-white px-12 py-3 shadow-md transition-all duration-300 placeholder:text-gray-400 focus:border-shopee focus:outline-none focus:ring-0"
            placeholder="Search..."
            type="text"
            v-model="search"
            @input="handleInput"
            @keyup.enter="submitSearch"
        />
        <button
            type="button"
            class="absolute right-4 top-1/2 -translate-y-1/2 p-1"
            @click="clearSearch"
        >
            <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-gray-700"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
            ></path>
            </svg>
        </button>
    </div>
</template>