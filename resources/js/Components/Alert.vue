<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch, nextTick } from 'vue';

const props = defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, default: 'Apakah kamu yakin?' },
    message: { type: String, default: '' },
    confirmText: { type: String, default: 'Ya, lanjutkan' },
    cancelText: { type: String, default: 'Batal' },
    variant: {
        type: String,
        default: 'danger', // danger | warning | info
        validator: (v) => ['danger', 'warning', 'info'].includes(v),
    },
    loading: { type: Boolean, default: false },
});

const emit = defineEmits(['confirm', 'cancel']);

const confirmButton = ref(null);

const styles = computed(() => ({
    danger: {
        icon: 'bg-red-100 text-red-600',
        button: 'bg-red-600 hover:bg-red-700 focus-visible:ring-red-500',
    },
    warning: {
        icon: 'bg-amber-100 text-amber-600',
        button: 'bg-amber-500 hover:bg-amber-600 focus-visible:ring-amber-500',
    },
    info: {
        icon: 'bg-indigo-100 text-indigo-600',
        button: 'bg-indigo-600 hover:bg-indigo-700 focus-visible:ring-indigo-500',
    },
}[props.variant]));

const cancel = () => {
    if (!props.loading) emit('cancel');
};

const onKeydown = (e) => {
    if (props.show && e.key === 'Escape') cancel();
};

onMounted(() => document.addEventListener('keydown', onKeydown));
onBeforeUnmount(() => document.removeEventListener('keydown', onKeydown));

watch(
    () => props.show,
    async (val) => {
        document.body.style.overflow = val ? 'hidden' : '';
        if (val) {
            await nextTick();
            confirmButton.value?.focus();
        }
    },
);

onBeforeUnmount(() => {
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[100] flex items-end justify-center p-4 sm:items-center"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="confirm-title"
                aria-describedby="confirm-message"
            >
                <!-- Backdrop -->
                <div
                    class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
                    @click="cancel"
                />

                <!-- Panel -->
                <div
                    class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-black/5"
                >
                    <div class="flex gap-4">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full"
                            :class="styles.icon"
                        >
                            <!-- Ikon peringatan -->
                            <svg
                                v-if="variant !== 'info'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                                />
                            </svg>
                            <!-- Ikon info -->
                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 id="confirm-title" class="text-base font-semibold text-gray-900">
                                {{ title }}
                            </h3>
                            <p
                                v-if="message || $slots.default"
                                id="confirm-message"
                                class="mt-1.5 text-sm text-gray-600"
                            >
                                <slot>{{ message }}</slot>
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-50"
                            :disabled="loading"
                            @click="cancel"
                        >
                            {{ cancelText }}
                        </button>
                        <button
                            ref="confirmButton"
                            type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-white transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-60"
                            :class="styles.button"
                            :disabled="loading"
                            @click="emit('confirm')"
                        >
                            <svg
                                v-if="loading"
                                class="h-4 w-4 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                            </svg>
                            {{ confirmText }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>