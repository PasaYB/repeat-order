<script setup>
import 'leaflet/dist/leaflet.css';
import { onBeforeUnmount, ref, nextTick, onMounted } from 'vue';
import { LMap, LTileLayer, LCircleMarker } from '@vue-leaflet/vue-leaflet';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({ latitude: null, longitude: null, address: '' }),
    },
    center: { type: Array, default: () => [-7.7956, 110.3695] },
    restaurantPosition: { type: Array, default: null },
    error: { type: String, default: '' },
});

const emit = defineEmits(['update:modelValue']);

const mapRef = ref(null);
const loadingAddress = ref(false);
const locating = ref(false);
const geoError = ref('');

let timer = null;
let controller = null;

const startCenter =
    props.modelValue.latitude != null
        ? [Number(props.modelValue.latitude), Number(props.modelValue.longitude)]
        : props.center;

const update = (patch) => emit('update:modelValue', { ...props.modelValue, ...patch });

const reverse = async (lat, lng) => {
    controller?.abort();
    const current = (controller = new AbortController());

    try {
        const params = new URLSearchParams({
            format: 'jsonv2',
            lat,
            lon: lng,
            zoom: '18',
            addressdetails: '1',
            'accept-language': 'id',
        });
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?${params}`, {
            signal: current.signal,
        });
        if (!res.ok) throw new Error('Gagal mengambil alamat.');

        const data = await res.json();
        emit('update:modelValue', {
            latitude: lat,
            longitude: lng,
            address: data.display_name ?? '',
        });
        geoError.value = '';
    } catch (e) {
        if (e.name === 'AbortError') return;
        geoError.value = 'Alamat tidak bisa diambil. Silakan isi manual.';
    } finally {
        if (controller === current) loadingAddress.value = false;
    }
};

const onMoveEnd = () => {
    const map = mapRef.value?.leafletObject;
    if (!map) return;

    const { lat, lng } = map.getCenter();
    const latitude = Number(lat.toFixed(6));
    const longitude = Number(lng.toFixed(6));

    update({ latitude, longitude });
    loadingAddress.value = true;

    clearTimeout(timer);
    timer = setTimeout(() => reverse(latitude, longitude), 600); // debounce
};

const useMyLocation = () => {
    if (!('geolocation' in navigator)) {
        geoError.value = 'Browser tidak mendukung geolokasi.';
        return;
    }
    locating.value = true;
    geoError.value = '';

    navigator.geolocation.getCurrentPosition(
        ({ coords }) => {
            mapRef.value?.leafletObject.setView([coords.latitude, coords.longitude], 17);
            locating.value = false;
        },
        (e) => {
            geoError.value =
                e.code === 1 ? 'Izin lokasi ditolak.' : 'Lokasi tidak bisa ditemukan.';
            locating.value = false;
        },
        { enableHighAccuracy: true, timeout: 10000 },
    );
};
const refreshSize = () => mapRef.value?.leafletObject?.invalidateSize();

const onReady = () => {
    onMoveEnd();
    setTimeout(refreshSize, 400);
};

let observer;
onMounted(async () => {
    await nextTick();
    const el = mapRef.value?.$el;
    if (el && 'ResizeObserver' in window) {
        observer = new ResizeObserver(refreshSize);
        observer.observe(el);
    }
});

onBeforeUnmount(() => observer?.disconnect());
</script>

<template>
    <div class="space-y-3">
        <div class="relative isolate h-72 overflow-hidden rounded-xl ring-1 ring-gray-300 sm:h-80">
            <LMap
                ref="mapRef"
                :zoom="16"
                :center="startCenter"
                :use-global-leaflet="false"
                @ready="onReady"
                @moveend="onMoveEnd"
            >
                <LTileLayer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    attribution="&copy; OpenStreetMap"
                    layer-type="base"
                    name="OpenStreetMap"
                />

                <LCircleMarker
                    v-if="restaurantPosition"
                    :lat-lng="restaurantPosition"
                    :radius="8"
                    color="#16a34a"
                    :fill-opacity="0.9"
                />
            </LMap>

            <div
                class="pointer-events-none absolute left-1/2 top-1/2 z-[1000] -translate-x-1/2 -translate-y-full"
            >
                <svg class="h-10 w-10 text-red-500 drop-shadow-md" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.1 2 5 5.1 5 9c0 5.3 7 13 7 13s7-7.7 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z" />
                </svg>
            </div>

            <button
                type="button"
                class="absolute bottom-3 right-3 z-[1000] inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-md ring-1 ring-gray-200 transition hover:bg-gray-50 disabled:opacity-60"
                :disabled="locating"
                @click="useMyLocation"
            >
                {{ locating ? 'Mencari...' : '📍 My Location' }}
            </button>
        </div>
        <!-- Alamat -->
        <div>
            <div v-if="loadingAddress" class="mt-1 space-y-2 rounded-md border border-gray-200 p-3">
                <div class="h-3 w-full animate-pulse rounded bg-gray-200" />
                <div class="h-3 w-2/3 animate-pulse rounded bg-gray-200" />
            </div>

            <textarea
                v-else
                id="delivery-address"
                :value="modelValue.address"
                rows="3"
                placeholder="Geser peta untuk mengisi alamat, lalu tambahkan patokan jika perlu"
                class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                @input="update({ address: $event.target.value })"
            />

            <p v-if="error || geoError" class="mt-1 text-xs text-red-600">
                {{ error || geoError }}
            </p>
        </div>
    </div>
</template>