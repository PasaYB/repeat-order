<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    orders: {
        type: Array,
        required: true,
    },
});

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;
</script>

<template>
    <Head title="Order History" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Order History
            </h2>
        </template>

        <div class="pb-12">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                <div
                    v-if="orders.length"
                    class="space-y-4"
                >
                    <Link
                        v-for="order in orders"
                        :key="order.id"
                        :href="route('orders.show', order.id)"
                        class="block rounded-lg bg-white p-6 shadow-sm transition hover:shadow-md"
                    >
                        <div class="flex flex-wrap justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ order.order_number }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ order.restaurant.name }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium capitalize text-green-700">
                                {{ order.status }}
                            </span>
                        </div>
                        <div class="mt-4 flex justify-between border-t pt-4 text-sm text-gray-600">
                            <span>{{ order.items.length }} menu item(s)</span>
                            <span class="font-semibold text-gray-900">
                                {{ formatPrice(order.total) }}
                            </span>
                        </div>
                    </Link>
                </div>
                <div
                    v-else
                    class="rounded-lg bg-white p-6 text-gray-600 shadow-sm"
                >
                    You have no order history yet.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
