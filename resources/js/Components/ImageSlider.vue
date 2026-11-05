<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    slides: {
        type: Array,
        default: () => [
            { src: 'https://images.wallpaperscraft.com/image/single/baking_sweets_cooking_1503131_1920x1080.jpg', alt: 'Slide 1' },
            { src: 'https://images.wallpaperscraft.com/image/single/hamburger_burger_meat_116725_1920x1080.jpg', alt: 'Slide 2' },
            { src: 'https://images.wallpaperscraft.com/image/single/breakfast_fruit_strawberries_174810_1920x1080.jpg', alt: 'Slide 3' },
        ],
    },
    interval: { type: Number, default: 3000 },
    autoplay: { type: Boolean, default: true },
});

const current = ref(0);
let timer = null;

const goTo = (index) => {
    current.value = (index + props.slides.length) % props.slides.length;
};

const next = () => goTo(current.value + 1);
const prev = () => goTo(current.value - 1);

const stop = () => {
    clearInterval(timer);
    timer = null;
};

const start = () => {
    stop(); // cegah interval dobel
    if (props.autoplay && props.slides.length > 1) {
        timer = setInterval(next, props.interval);
    }
};

// Klik manual: pindah lalu mulai ulang hitungan waktu
const select = (index) => {
    goTo(index);
    start();
};

onMounted(start);
onBeforeUnmount(stop);
</script>

<template>
    <div class="flex flex-col items-center my-4">
        <div
            class="relative w-full overflow-hidden md:aspect-[3/1]"
            @mouseenter="stop"
            @mouseleave="start"
        >
            <div
                class="flex h-full sm:rounded-lg transition-transform duration-500 ease-in-out"
                :style="{ transform: `translateX(-${current * 100}%)` }"
            >
                <img
                    v-for="(slide, i) in slides"
                    :key="slide.src"
                    :src="slide.src"
                    :alt="slide.alt"
                    class="h-full w-full flex-shrink-0 sm:rounded-lg object-cover"
                    :loading="i === 0 ? 'eager' : 'lazy'"
                />
            </div>

            <!-- Tombol panah -->
            <!-- <button
                type="button"
                class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/40 px-3 py-1.5 text-white transition hover:bg-black/60"
                aria-label="Slide sebelumnya"
                @click="select(current - 1)"
            >
                ‹
            </button>
            <button
                type="button"
                class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/40 px-3 py-1.5 text-white transition hover:bg-black/60"
                aria-label="Slide berikutnya"
                @click="select(current + 1)"
            >
                ›
            </button> -->
        </div>

        <!-- Indikator titik -->
        <div class="mt-5 flex items-center justify-center space-x-2">
            <button
                v-for="(slide, i) in slides"
                :key="slide.src"
                type="button"
                class="h-3 rounded-full transition-all duration-300"
                :class="i === current ? 'w-6 bg-shopee' : 'w-3 bg-shopee/20 hover:bg-shopee/40'"
                :aria-label="`Ke slide ${i + 1}`"
                :aria-current="i === current"
                @click="select(i)"
            />
        </div>
    </div>
</template>