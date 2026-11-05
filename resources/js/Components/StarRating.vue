<script setup>
import { computed } from 'vue';

const props = defineProps({
    rating: { type: Number, default: 0 },
    max: { type: Number, default: 5 },
    size: { type: String, default: 'h-4 w-4' },
});

const percent = computed(
    () => Math.min(Math.max(props.rating / props.max, 0), 1) * 100,
);

const STAR =
    'M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.191l4.07 2.485c.715.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z';
</script>

<template>
    <div
        class="relative inline-flex"
        role="img"
        :aria-label="`Rating ${rating} dari ${max}`"
    >
        <!-- Dasar: bintang abu-abu -->
        <div class="flex text-gray-300">
            <svg v-for="i in max" :key="i" :class="[size, 'shrink-0']" viewBox="0 0 20 20" fill="currentColor">
                <path :d="STAR" />
            </svg>
        </div>

        <!-- Lapisan atas: bintang kuning, dipotong sesuai persentase -->
        <div
            class="absolute inset-y-0 left-0 overflow-hidden"
            :style="{ width: percent + '%' }"
        >
            <div class="flex w-max text-yellow-400">
                <svg v-for="i in max" :key="i" :class="[size, 'shrink-0']" viewBox="0 0 20 20" fill="currentColor">
                    <path :d="STAR" />
                </svg>
            </div>
        </div>
    </div>
</template>