<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Alert from '@/Components/Alert.vue';
import QuantityInput from '@/Components/QuantityInput.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    menus: {
        type: Array,
        required: true,
    },
    restaurant: {
        type: Object,
        default: null,
    },
});

const page = usePage();
const cartSummary = computed(() => page.props.cartSummary);
const cartRestaurantId = computed(() => Number(cartSummary.value?.restaurant?.id));
const cartQuantities = computed(() =>
    Object.fromEntries(
        (cartSummary.value?.items || []).map((item) => [
            item.menu_id,
            item.quantity,
        ]),
    ),
);

const cartItemIds = computed(() =>
    Object.fromEntries(
        (cartSummary.value?.items || []).map((item) => [
            item.menu_id,
            item.id,
        ]),
    ),
);
const quantities = ref(
    cartRestaurantId.value === props.restaurant?.id
        ? { ...cartQuantities.value }
        : {},
);

const showReplaceAlert = ref(false);
const showRemoveAlert = ref(false);
const replaceMessage = ref('');
const pendingCartData = ref(null);
const itemToRemove = ref(null);

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

const displayedQuantity = (menu) =>
    quantities.value[menu.id] || cartQuantities.value[menu.id] || 0;

const syncQuantitiesFromCart = () => {
    quantities.value =
        cartRestaurantId.value === props.restaurant?.id
            ? { ...cartQuantities.value }
            : {};
};

const refreshCart = () => {
    router.reload({
        preserveScroll: true,
        preserveState: true,
        onSuccess: syncQuantitiesFromCart,
    });

};

const cancelReplace = () => {
    showReplaceAlert.value = false;
    pendingCartData.value = null;
};

const cancelRemove = () => {
    showRemoveAlert.value = false;
    itemToRemove.value = null;
};

const confirmRemove = () => {
    const cartItemId = itemToRemove.value
        ? cartItemIds.value[itemToRemove.value.id]
        : null;

    if (!cartItemId) {
        cancelRemove();
        return;
    }

    router.delete(route('cartItems.destroy', cartItemId), {
        onSuccess: () => {
            cancelRemove();
            refreshCart();
        },  
    });
        
};

const confirmReplace = () => {
    router.post(route('addToCart'), {
        ...pendingCartData.value,
        replace_existing: true,
    }, {
        onSuccess: () => {
            cancelReplace();
            refreshCart();
        },
    });
};

const addItem = (menu) => {
    setQuantity(menu, displayedQuantity(menu) + 1);
};

const decreaseItem = (menu) => {
    setQuantity(menu, displayedQuantity(menu) - 1);
};

const setQuantity = (menu, value) => {
    const nextQuantity = Number(value);
    const previousQuantity = displayedQuantity(menu);
    const cartItemId = cartItemIds.value[menu.id];

    if (nextQuantity < 0 || nextQuantity > 99 || nextQuantity === previousQuantity) {
        return;
    }

    if (nextQuantity === 0 && cartItemId) {
        itemToRemove.value = menu;
        showRemoveAlert.value = true;
        return;
    }

    if (!cartItemId) {
        if (nextQuantity === 0) {
            delete quantities.value[menu.id];
            return;
        }

        router.post(route('addToCart'), {
            items: [{ menu_id: menu.id, quantity: nextQuantity }],
        }, {
            onError: (errors) => {
                if (previousQuantity > 0) {
                    quantities.value[menu.id] = previousQuantity;
                } else {
                    delete quantities.value[menu.id];
                }

                if (errors.cart) {
                    pendingCartData.value = {
                        items: [{ menu_id: menu.id, quantity: nextQuantity }],
                    };
                    replaceMessage.value = errors.cart;
                    showReplaceAlert.value = true;
                }
            },
            onSuccess: () => {
                refreshCart();
                quantities.value[menu.id] = nextQuantity;
            }, 
        });

        return;
    }

    quantities.value[menu.id] = nextQuantity;

    router.patch(
        route('cartItems.update', cartItemId),
        {
            quantity: nextQuantity,
        },
        {
            onError: () => {
                quantities.value[menu.id] = previousQuantity;
            },
            onSuccess: refreshCart,
        },
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
                                <div class="mt-4 flex items-center justify-end">
                                    <div class="flex items-center gap-3">
                                        <QuantityInput
                                            :model-value="quantities[menu.id] ?? 0"
                                            @increase="addItem(menu)"
                                            @decrease="decreaseItem(menu)"
                                            @commit="(value) => setQuantity(menu, value)"
                                        />
                                    </div>
                                </div>
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
                        <p
                            v-if="page.props.errors.items"
                            class="mt-3 rounded-md bg-red-50 p-3 text-sm text-red-700"
                        >
                            {{ page.props.errors.items }}
                        </p>
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
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900">
                                            {{ item.name }}
                                        </span>
                                        <span class="text-sm text-gray-600">
                                            {{ item.quantity }} x
                                        </span>
                                    </div>
                                    <span class="font-medium text-gray-900">
                                        {{ formatPrice(item.subtotal) }}
                                    </span>
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
                    </aside>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Alert
        :show="showReplaceAlert"
        title="Replace cart?"
        :message="replaceMessage"
        confirm-text="Replace cart"
        cancel-text="Keep current cart"
        variant="warning"
        @confirm="confirmReplace"
        @cancel="cancelReplace"
    />

    <Alert
        :show="showRemoveAlert"
        :message="
            itemToRemove
                ? `All ${itemToRemove.name} will be removed from your cart.`
                : ''
        "
        title="Remove from cart?"
        confirm-text="Remove"
        cancel-text="Cancel"
        variant="danger"
        @confirm="confirmRemove"
        @cancel="cancelRemove"
        />
</template>
