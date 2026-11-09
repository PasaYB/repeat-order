<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import { useUserLocation } from '@/composables/useUserLocation';
import { calculateDeliveryFee } from '@/utils/delivery';

const props = defineProps({
    cart: {
        type: Object,
        required: true,
    },
});

const { position, locate } = useUserLocation();
onMounted(() => locate());

const delivery = computed(() => calculateDeliveryFee(position.value, props.cart.restaurant));
const deliveryFee = computed(() => delivery.value.fee);
const deliveryDistance = computed(() => delivery.value.distance != null ? Math.ceil(delivery.value.distance) : null)

const form = useForm({
    recipient_name: '',
    recipient_phone: '',
    delivery_address: '',
    notes: '',
});

const subtotal = computed(() =>
    props.cart.items.reduce(
        (sum, item) => sum + Number(item.menu.price) * item.quantity,
        0,
    ),
);

const tax = subtotal.value * 0.11;

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const placeOrder = () => {
    if (
        !form.recipient_name.trim()
        || !form.recipient_phone.trim()
        || !form.delivery_address.trim()
    ) {
        return;
    }

    form.post(route('orders.store'));
};
</script>

<template>
    <Head title="Checkout" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Checkout
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form
                    class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]"
                    @submit.prevent="placeOrder"
                >
                    <section class="rounded-lg bg-white p-6 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-500">Restaurant</p>
                            <h3 class="mt-1 text-xl font-semibold text-gray-900">
                                {{ cart.restaurant.name }}
                            </h3>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label
                                    for="recipient-name"
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Recipient name
                                </label>
                                <TextInput
                                    id="recipient-name"
                                    type="text"
                                    v-model="form.recipient_name"
                                    class="mt-1 block w-full"
                                    placeholder="Recipient Name"
                                    required
                                    autofocus
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.recipient_name"
                                />
                            </div>

                            <div>
                                <label
                                    for="recipient-phone"
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Phone number
                                </label>
                                <TextInput
                                    id="recipient-phone"
                                    v-model="form.recipient_phone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                    placeholder="Phone Number"
                                    required
                                    autocomplete="tel"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.recipient_phone"
                                />
                            </div>

                            <div>
                                <label
                                    for="delivery-address"
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Delivery address
                                </label>
                                <textarea
                                    id="delivery-address"
                                    v-model="form.delivery_address"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.delivery_address"
                                />
                            </div>

                            <div>
                                <label
                                    for="notes"
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Notes
                                </label>
                                <textarea
                                    id="notes"
                                    v-model="form.notes"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.notes"
                                />
                            </div>
                        </div>
                    </section>

                    <aside class="h-fit rounded-lg bg-white p-6 shadow-sm lg:sticky lg:top-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Order summary
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div
                                v-for="item in cart.items"
                                :key="item.id"
                                class="flex justify-between gap-4 border-b border-gray-100 pb-3"
                            >
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ item.menu.name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ item.quantity }} × {{ formatPrice(item.menu.price) }}
                                    </p>
                                </div>
                                <span class="font-medium text-gray-900">
                                    {{ formatPrice(Number(item.menu.price) * item.quantity) }}
                                </span>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between gap-4 border-b border-gray-100 pb-3">
                                <p class="font-medium text-gray-900">
                                    Delivery Fee <span class="text-shopee">({{ deliveryDistance + " km" }})</span>
                                </p>
                                <span class="font-medium text-gray-900">
                                    {{ formatPrice(deliveryFee) }}
                                </span>
                            </div>
                            <div class="flex justify-between gap-4 border-b border-gray-100 pb-3">
                                <p class="font-medium text-gray-900">
                                    PPn <span class="text-shopee">(11%)</span>
                                </p>
                                <span class="font-medium text-gray-900">
                                    {{ formatPrice(tax) }}
                                </span>
                            </div>
                            <div class="mt-4 flex justify-between pt-4 font-bold text-gray-900">
                                <span>Total</span>
                                <span>{{ formatPrice(subtotal + deliveryFee + tax) }}</span>
                            </div>
                        </div>
                        <PrimaryButton
                            type="submit"
                            class="mt-6 w-full justify-center"
                            :disabled="form.processing"
                        >
                            Place order
                        </PrimaryButton>
                    </aside>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
