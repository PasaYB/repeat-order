<script setup>
import { computed, onMounted } from 'vue';
import { useUserLocation } from '@/composables/useUserLocation';

const { place, loading, error, locate } = useUserLocation();

const denied = computed(() => error.value === 'denied');

const text = computed(() =>
    place.value
        ? [place.value.kecamatan, place.value.kota].filter(Boolean).join(', ')
        : '',
);

onMounted(() => locate());
</script>

<template>
    <div
        class="flex items-center gap-3 py-3"
    >
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-shopee/10 text-shopee">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-12a7 7 0 10-14 0c0 5.8 7 12 7 12z" />
                <circle cx="12" cy="9" r="2.5" />
            </svg>
        </div>

        <div class="min-w-0 flex-1">

            <div v-if="loading" class="mt-1 h-4 w-40 animate-pulse rounded bg-gray-200" />

            <p v-else-if="text" class="truncate text-sm font-semibold text-gray-900">
                {{ text }}
            </p>

            <p v-else-if="denied" class="text-sm text-gray-600">
                Izin lokasi ditolak. Aktifkan lewat ikon gembok di address bar, lalu coba lagi.
            </p>

            <!-- Error lain -->
            <p v-else-if="error" class="text-sm text-red-600">{{ error }}</p>
        </div>

        <button
            v-if="!loading && (denied || error)"
            type="button"
            class="shrink-0 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
            @click="locate({ force: true })"
        >
            Coba lagi
        </button>
    </div>
</template>