<script setup>
import Alert from '@/Components/Alert.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    cart: {
        type: Object,
        default: null,
    },
});

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const showRemoveAlert = ref(false);
const itemToRemove = ref(null);

const updateQuantity = (item, quantity) => {
    if (quantity < 1) {
        removeItem(item);
        return;
    }

    if (quantity > 99) {
        return;
    }

    router.patch(route('cartItems.update', item.id), {
        quantity,
    });
};

const removeItem = (item) => {
    itemToRemove.value = item;
    showRemoveAlert.value = true;
};

const cancelRemove = () => {
    showRemoveAlert.value = false;
    itemToRemove.value = null;
};

const confirmRemove = () => {
    router.delete(route('cartItems.destroy', itemToRemove.value.id), {
        onSuccess: cancelRemove,
    });
};
</script>

<template>
    <Head title="Cart" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <section class="rounded-lg bg-white p-6 shadow-sm">
                    <div v-if="cart?.items?.length">
                        <p class="text-sm text-gray-500">
                            {{ cart.restaurant?.name }}
                        </p>
                        <div class="mt-4 divide-y divide-gray-100">
                            <div
                                v-for="item in cart.items"
                                :key="item.id"
                                class="flex items-center justify-between gap-4 py-4"
                            >
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ item.menu.name }}
                                    </p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <button
                                            type="button"
                                            class="rounded border border-gray-300 px-2 text-gray-700"
                                            @click="updateQuantity(item, item.quantity - 1)"
                                        >
                                            -
                                        </button>
                                        <span class="min-w-6 text-center text-sm text-gray-600">
                                            {{ item.quantity }}
                                        </span>
                                        <button
                                            type="button"
                                            class="rounded border border-gray-300 px-2 text-gray-700"
                                            :disabled="item.quantity >= 99"
                                            @click="updateQuantity(item, item.quantity + 1)"
                                        >
                                            +
                                        </button>
                                        <button
                                            type="button"
                                            class="ml-2 text-sm text-red-600 hover:text-red-800"
                                            @click="removeItem(item)"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <span class="font-medium text-gray-900">
                                    {{ formatPrice(item.menu.price * item.quantity) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between border-t pt-4 font-bold text-gray-900">
                            <span>Total</span>
                            <span>
                                {{ formatPrice(cart.items.reduce((sum, item) => sum + item.menu.price * item.quantity, 0)) }}
                            </span>
                        </div>
                    </div>
                    <p v-else class="text-gray-600">
                        Your cart is empty.
                    </p>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>

    <Alert
        :show="showRemoveAlert"
        :message="itemToRemove ? `All ${itemToRemove.menu.name} will be removed from your cart.` : ''"
        title="Remove from cart?"
        confirm-text="Remove"
        cancel-text="Cancel"
        variant="danger"
        @confirm="confirmRemove"
        @cancel="cancelRemove"
    />
</template>
