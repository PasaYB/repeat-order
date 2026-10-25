<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    menus: {
        type: Array,
        required: true,
    },
    restaurants: {
        type: Array,
        required: true,
    },
    restaurant: {
        type: Object,
        default: null,
    },
});

const quantities = ref({});

const selectedItems = computed(() =>
    props.menus
        .filter((menu) => quantities.value[menu.id] > 0)
        .map((menu) => ({
            ...menu,
            quantity: quantities.value[menu.id],
            subtotal: Number(menu.price) * quantities.value[menu.id],
        })),
);

const total = computed(() =>
    selectedItems.value.reduce((sum, item) => sum + item.subtotal, 0),
);

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const addItem = (menu) => {
    quantities.value[menu.id] = (quantities.value[menu.id] || 0) + 1;
};

const decreaseItem = (menu) => {
    const quantity = quantities.value[menu.id] || 0;

    if (quantity <= 1) {
        delete quantities.value[menu.id];
        return;
    }

    quantities.value[menu.id] = quantity - 1;
};

const selectRestaurant = (event) => {
    router.get(
        route('menu'),
        { restaurant_id: event.target.value || undefined },
        { preserveState: false, preserveScroll: true },
    );
};
</script>

<template>
    <Head title="Menu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Menu
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Restaurant</p>
                        <h3 class="mt-1 text-2xl font-bold text-gray-900">
                            {{ restaurant.name }}
                        </h3>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
                    <section>
                        <div
                            v-if="menus.length"
                            class="grid gap-4 sm:grid-cols-2"
                        >
                            <article
                                v-for="menu in menus"
                                :key="menu.id"
                                class="rounded-lg bg-white p-5 shadow-sm"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ menu.name }}
                                        </h4>
                                        <p
                                            v-if="!restaurant && menu.restaurant"
                                            class="mt-1 text-sm font-medium text-indigo-600"
                                        >
                                            {{ menu.restaurant.name }}
                                        </p>
                                    </div>
                                    <span class="whitespace-nowrap font-semibold text-gray-900">
                                        {{ formatPrice(menu.price) }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm text-gray-600">
                                    {{ menu.description }}
                                </p>
                                <button
                                    type="button"
                                    class="mt-4 w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700"
                                    @click="addItem(menu)"
                                >
                                    Add to order
                                </button>
                            </article>
                        </div>
                        <div
                            v-else
                            class="rounded-lg bg-white p-6 text-gray-600 shadow-sm"
                        >
                            No available menu items found.
                        </div>
                    </section>

                    <aside class="h-fit rounded-lg bg-white p-5 shadow-sm lg:sticky lg:top-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Order summary
                        </h3>
                        <div
                            v-if="selectedItems.length"
                            class="mt-4 space-y-4"
                        >
                            <div
                                v-for="item in selectedItems"
                                :key="item.id"
                                class="border-b border-gray-100 pb-4"
                            >
                                <div class="flex justify-between gap-3">
                                    <span class="font-medium text-gray-900">
                                        {{ item.name }}
                                    </span>
                                    <span class="font-medium text-gray-900">
                                        {{ formatPrice(item.subtotal) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center gap-3">
                                    <button
                                        type="button"
                                        class="rounded border border-gray-300 px-2 text-gray-700"
                                        @click="decreaseItem(item)"
                                    >
                                        -
                                    </button>
                                    <span class="text-sm text-gray-600">
                                        {{ item.quantity }}
                                    </span>
                                    <button
                                        type="button"
                                        class="rounded border border-gray-300 px-2 text-gray-700"
                                        @click="addItem(item)"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p
                            v-else
                            class="mt-4 text-sm text-gray-500 mb-16"
                        >
                            Add menu items to calculate the total cost.
                        </p>
                        <div class="flex justify-between border-t pt-4 text-base font-bold text-gray-900">
                            <span>Total</span>
                            <span>{{ formatPrice(total) }}</span>
                        </div>
                        <div v-if="selectedItems.length">
                            <button
                                type="button"
                                class="mt-4 w-full rounded-md bg-yellow-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-yellow-700"
                            >
                                Add to Cart
                            </button>
                            <button
                                type="button"
                                class="mt-4 w-full rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700"
                            >
                                Buy Now
                            </button>
                       </div>
                    </aside>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
