<script setup>
import { computed, onBeforeUnmount, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    restaurants: { type: Array, default: () => [] },
    onlyOpen: { type: Boolean, default: true }, 
    steps: { type: Number, default: 24 },
});

const emit = defineEmits(['result']);

const spinning = ref(false);
const display = ref(null);
const winner = ref(null);

let timer = null;

const pool = computed(() =>
    props.restaurants.filter((r) => !props.onlyOpen || r.is_currently_open !== false),
);

const randomFrom = (list, exclude = null) => {
    const options = list.length > 1 ? list.filter((r) => r.id !== exclude?.id) : list;
    return options[Math.floor(Math.random() * options.length)];
};

const prefersReducedMotion = () =>
    window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;

const spin = () => {
    if (spinning.value || pool.value.length === 0) return;

    const picked = randomFrom(pool.value, winner.value);

    spinning.value = true;
    winner.value = null;

    const finish = () => {
        display.value = picked;
        winner.value = picked;
        spinning.value = false;
        emit('result', picked.id);
    };

    if (prefersReducedMotion() || pool.value.length === 1) {
        return finish();
    }

    let step = 0;
    const tick = () => {
        step++;

        if (step >= props.steps) return finish();

        display.value = randomFrom(pool.value, display.value);

        const progress = step / props.steps;
        const delay = 60 + progress ** 3 * 340;
        timer = setTimeout(tick, delay);
    };

    tick();
};

const reset = () => {
    clearTimeout(timer);
    spinning.value = false;
    winner.value = null;
    display.value = null;
};

onBeforeUnmount(() => clearTimeout(timer));
</script>

<template>
    <div class="w-full max-w-xs">
        <div
            class="relative flex aspect-square w-full flex-col items-center justify-center overflow-hidden rounded-2xl border-4 bg-white text-center shadow-md transition-colors duration-300"
            :class="winner ? 'border-shopee' : 'border-gray-200'"
        >
            <template v-if="!display">
                <p class="mt-3 text-sm text-gray-500">
                    {{ pool.length ? 'Tekan tombol untuk mulai gacha' : 'Belum ada restoran yang buka' }}
                </p>
            </template>

            <template v-else>
                <div
                    class="flex h-40 w-40 items-center justify-center overflow-hidden rounded-xl bg-gray-100 transition-transform duration-300"
                    :class="{ 'scale-110': winner }"
                >
                    <img
                        v-if="display.image_url"
                        :src="display.image_url"
                        :alt="display.name"
                        class="h-full w-full object-cover"
                    />
                    <span v-else class="text-4xl">🍽️</span>
                </div>

                <p
                    class="mt-3 line-clamp-2 text-lg font-bold leading-tight text-gray-900"
                    :class="{ 'opacity-60': spinning }"
                >
                    {{ display.name }}
                </p>

                <p v-if="display.category?.name" class="mt-0.5 text-xs text-gray-500">
                    {{ display.category.name }}
                </p>
            </template>

            <span
                v-if="winner"
                class="absolute right-3 top-3 rounded-full bg-shopee px-2.5 py-0.5 text-xs font-semibold text-white"
            >
                Pilihanmu!
            </span>
        </div>

        <div class="mt-4 flex flex-col gap-2">
            <Link
                v-if="winner"
                :href="route('restaurants.show', winner.slug)"
                class="rounded-full bg-shopee px-5 py-2.5 text-center text-sm font-semibold text-white shadow transition hover:opacity-90"
            >
                Lihat menu {{ winner.name }}
            </Link>

            <button
                type="button"
                class="rounded-full px-5 py-2.5 text-sm font-semibold transition disabled:cursor-not-allowed disabled:opacity-60"
                :class="
                    winner
                        ? 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        : 'bg-shopee text-white shadow hover:opacity-90'
                "
                :disabled="spinning || pool.length === 0"
                @click="spin"
            >
                {{ spinning ? 'Mengacak...' : winner ? 'Gacha lagi' : 'Gacha sekarang!' }}
            </button>

            <button
                v-if="winner && !spinning"
                type="button"
                class="text-xs text-gray-400 hover:text-gray-600"
                @click="reset"
            >
                Reset
            </button>
        </div>
    </div>
</template>