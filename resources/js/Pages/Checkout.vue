<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import LocationPicker from '@/Components/LocationPicker.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { calculateDeliveryFee } from '@/utils/delivery';

const props = defineProps({
    cart: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    recipient_name: '',
    recipient_phone: '',
    delivery_address: '',
    latitude: null,
    longitude: null,
    delivery_fee: 0,
    notes: '',
});

const page = usePage();
const userName = computed(() => page.props.auth.user?.name ?? '');
const userPhone = computed(() => page.props.auth.user?.phone ?? '');
const recipientType = ref('self');
const otherName = ref('');
const otherPhone = ref('');

const userPoint = computed(() =>
    form.latitude != null && form.longitude != null
        ? [form.latitude, form.longitude]
        : null,
);
const delivery = computed(() => calculateDeliveryFee(userPoint.value, props.cart.restaurant));
const deliveryFee = computed(() => delivery.value.fee);
const deliveryDistance = computed(() =>
    delivery.value.distance != null ? Math.ceil(delivery.value.distance) : null,
);

const location = computed({
    get: () => ({
        latitude: form.latitude,
        longitude: form.longitude,
        address: form.delivery_address,
    }),
    set: (v) => {
        form.latitude = v.latitude;
        form.longitude = v.longitude;
        form.delivery_address = v.address;
    },
});

const restaurantPosition = computed(() => [
    Number(props.cart.restaurant.latitude),
    Number(props.cart.restaurant.longitude),
]);

const subtotal = computed(() =>
    props.cart.items.reduce(
        (sum, item) => sum + Number(item.menu.price) * item.quantity,
        0,
    ),
);

const tax = computed(() => subtotal.value * 0.11);
const total = computed(() => subtotal.value + tax.value + deliveryFee.value);
const canSubmit = computed(
    () =>
        form.recipient_name.trim() !== ''
        && form.recipient_phone.trim() !== ''
        && form.delivery_address.trim() !== ''
        && form.latitude != null
        && form.longitude != null
        && !form.processing,
);

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const placeOrder = () => {
    if (!canSubmit.value) {
        return;
    }

    form.delivery_fee = deliveryFee.value;
    form.post(route('orders.store'));
};

watch(
    [recipientType, otherName, otherPhone, userName, userPhone],
    () => {
        if (recipientType.value === 'self') {
            form.recipient_name = userName.value;
            form.recipient_phone = userPhone.value;
        } else {
            form.recipient_name = otherName.value;
            form.recipient_phone = otherPhone.value;
        }
    },
    { immediate: true },
);
</script>

<template>
    <Head title="Checkout" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Checkout
            </h2>
        </template>

        <div class="pb-12">
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
                                <div>

                                <div class="mt-2 grid gap-2 sm:grid-cols-2">
                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition has-[:checked]:border-shopee has-[:checked]:bg-shopee/10"
                                        :class="recipientType === 'self' ? 'border-shopee bg-shopee' : 'border-gray-300 bg-white hover:bg-gray-50'"
                                    >
                                        <input
                                            v-model="recipientType"
                                            type="radio"
                                            value="self"
                                            class="text-shopee focus:ring-shopee"
                                        />
                                        <span class="min-w-0">
                                            <span class="block text-sm font-medium text-gray-900">For Myself</span>
                                            <span class="block truncate text-xs text-gray-500">{{ userName }}</span>
                                        </span>
                                    </label>

                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition"
                                        :class="recipientType === 'other' ? 'border-shopee bg-shopee/10' : 'border-gray-300 bg-white hover:bg-gray-50'"
                                    >
                                        <input
                                            v-model="recipientType"
                                            type="radio"
                                            value="other"
                                            class="text-shopee focus:ring-shopee"
                                        />
                                        <span class="text-sm font-medium text-gray-900">For Others</span>
                                    </label>
                                </div>

                                <div v-if="recipientType === 'other'" class="mt-3">
                                    <label
                                        for="recipient-name"
                                        class="text-sm font-medium text-gray-700"
                                    >
                                        Recipient name
                                    </label>
                                    <TextInput
                                        id="recipient-name"
                                        v-model="otherName"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="Recipient Name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />

                                    <label
                                        for="recipient-phone"
                                        class="mt-3 block text-sm font-medium text-gray-700"
                                    >
                                        Phone number
                                    </label>
                                    <TextInput
                                        id="recipient-phone"
                                        v-model="otherPhone"
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

                                <p v-if="form.errors.recipient_name" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.recipient_name }}
                                </p>
                                <p
                                    v-if="recipientType === 'self' && !userPhone"
                                    class="mt-2 text-xs text-amber-600"
                                >
                                    Nomor HP akun belum diisi. Lengkapi profile atau pilih penerima lain.
                                </p>
                            </div>
                            </div>

                            <div v-if="recipientType === 'self'">
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
                                    readonly
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
                                <LocationPicker
                                    v-model="location"
                                    :center="restaurantPosition"
                                    :restaurant-position="restaurantPosition"
                                    :error="form.errors.delivery_address"
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
                                Delivery Fee
                                <span v-if="deliveryDistance !== null" class="text-shopee">
                                    ({{ deliveryDistance }} km)
                                </span>
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
                                <span>{{ formatPrice(total) }}</span>
                            </div>
                        </div>
                        <PrimaryButton
                            type="submit"
                            class="mt-6 w-full justify-center"
                            :disabled="!canSubmit"
                        >
                            Place order
                        </PrimaryButton>
                    </aside>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
