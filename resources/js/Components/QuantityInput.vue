<script setup>
import { nextTick, ref, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Number, default: 0 },
    min: { type: Number, default: 0 },
    max: { type: Number, default: 99 },
    disabled: { type: Boolean, default: false },
});

const emit = defineEmits(['increase', 'decrease', 'commit']);

const draft = ref(String(props.modelValue));

// Ikuti nilai dari luar (setelah patch/post berhasil, rollback, dll)
watch(
    () => props.modelValue,
    (val) => (draft.value = String(val)),
);

// Hanya izinkan angka
const onInput = (e) => {
    draft.value = e.target.value.replace(/\D/g, '');
    e.target.value = draft.value;
};

const commit = async () => {
    // Kosong -> kembalikan ke nilai semula
    let next = draft.value === '' ? props.modelValue : parseInt(draft.value, 10);
    next = Math.min(Math.max(next, props.min), props.max);

    draft.value = String(next);

    if (next !== props.modelValue) {
        emit('commit', next);

        // Jika induk menolak/membatalkan (mis. alert hapus), tampilan kembali ke nilai asli
        await nextTick();
        draft.value = String(props.modelValue);
    }
};
</script>

<template>
    <div class="inline-flex items-center gap-1">
        <button
            type="button"
            class="rounded border border-gray-300 px-3 py-1 text-gray-700 transition hover:bg-gray-50 disabled:opacity-50"
            :disabled="disabled || modelValue <= min"
            aria-label="Kurangi"
            @click="emit('decrease')"
        >
            −
        </button>

        <input
            :value="draft"
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="3"
            :disabled="disabled"
            aria-label="Jumlah"
            class="w-12 rounded border border-gray-300 px-1 py-1 text-center text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 disabled:opacity-50"
            @input="onInput"
            @focus="$event.target.select()"
            @blur="commit"
            @keydown.enter.prevent="$event.target.blur()"
        />

        <button
            type="button"
            class="rounded border border-gray-300 px-3 py-1 text-gray-700 transition hover:bg-gray-50 disabled:opacity-50"
            :disabled="disabled || modelValue >= max"
            aria-label="Tambah"
            @click="emit('increase')"
        >
            +
        </button>
    </div>
</template>