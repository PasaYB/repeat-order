<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    order: {
        type: Object,
        required: true,
    },
});

const printReceipt = () => window.print();

const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const statusClass = computed(() => ({
    pending: 'border-amber-600 text-amber-700',
    cancelled: 'border-red-600 text-red-700',
}[order.status] ?? 'border-green-600 text-green-700'));
</script>

<template>
    <Head title="Order Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Order Detail
            </h2>
        </template>

        <div class="pb-12">
            <div class="mx-auto max-w-md px-4 sm:px-0">
            <div id="receipt" class="drop-shadow-md print:drop-shadow-none">
                <div class="receipt-edge-top" />

                <section class="bg-white px-6 py-4 font-xmind text-sm text-gray-700">
                    <div class="text-center">
                        <h2 class="text-lg font-bold uppercase tracking-widest text-gray-900">
                            {{ order.restaurant.name }}
                        </h2>
                        <p class="mt-1 text-xs text-gray-500">Bukti Pesanan</p>
                    </div>

                    <div class="my-4 border-t-2 border-dashed border-gray-300" />

                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500">No. Order</span>
                            <span class="font-semibold text-gray-900">{{ order.order_number }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-500">Status</span>
                            <span
                                class="px-2 py-0.5 text-[11px] font-bold uppercase tracking-wider text-gray-900"
                            >
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="my-4 border-t-2 border-dashed border-gray-300" />
                    
                    <dl class="space-y-1 text-xs my-4">
                        <div class="flex gap-3">
                            <dt class="w-16 shrink-0 text-gray-500">Penerima</dt>
                            <dd class="min-w-0 break-words text-gray-900">{{ order.recipient_name }}</dd>
                        </div>
                        <div class="flex gap-3">
                            <dt class="w-16 shrink-0 text-gray-500">Telepon</dt>
                            <dd class="text-gray-900">{{ order.recipient_phone }}</dd>
                        </div>
                        <div class="flex gap-3">
                            <dt class="w-16 shrink-0 text-gray-500">Alamat</dt>
                            <dd class="min-w-0 break-words text-gray-900">{{ order.delivery_address }}</dd>
                        </div>
                            <div v-if="order.notes" class="flex gap-3">
                            <dt class="w-16 shrink-0 text-gray-500">Catatan</dt>
                            <dd class="min-w-0 break-words text-gray-900">{{ order.notes }}</dd>
                        </div>
                    </dl>

                    <div class="my-4 border-t-2 border-dashed border-gray-300" />

                    <ul class="space-y-3">
                        <li v-for="item in order.items" :key="item.id">
                            <p class="font-semibold text-gray-900">{{ item.menu_name }}</p>
                            <div class="flex justify-between gap-4 text-xs text-gray-500">
                                <span>{{ item.quantity }} × {{ formatPrice(item.unit_price) }}</span>
                                <span class="font-medium text-gray-900">
                                    {{ formatPrice(item.subtotal) }}
                                </span>
                            </div>
                        </li>
                    </ul>

                    <div class="my-4 border-t-2 border-dashed border-gray-300" />

                    <div class="space-y-1.5">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>{{ formatPrice(order.subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span>{{ formatPrice(order.delivery_fee) }}</span>
                        </div>
                    </div>

                    <div class="my-3 border-t-2 border-double border-gray-400" />

                    <div class="flex justify-between text-base font-bold text-gray-900">
                        <span>TOTAL</span>
                        <span>{{ formatPrice(order.total) }}</span>
                    </div>
                    

                    <div class="my-4 border-t-2 border-dashed border-gray-300" />

                    <p class="text-center text-xs text-gray-500">
                        *** Terima kasih sudah memesan ***
                    </p>
                </section>

                <div class="receipt-edge-bottom" />
            </div>

            <div class="mt-6 flex items-center justify-between text-sm print:hidden">
                <Link
                    :href="route('orders.index')"
                    class="font-medium text-shopee hover:text-shopee/80"
                >
                    ← Back to Order History
                </Link>
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                    @click="printReceipt"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 32 32">
                        <path d="M0 0h32v32H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 25H2V9h28v16h-5M7 19v11h18V19ZM25 9V2H7v7m15 5h3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    </AuthenticatedLayout>
</template>


<style scoped>
.receipt-edge-top,
.receipt-edge-bottom {
    height: 10px;
    background-repeat: repeat-x;
    background-size: 14px 10px;
}

.receipt-edge-top {
    background-image:
        linear-gradient(135deg, transparent 7px, #fff 0),
        linear-gradient(-135deg, transparent 7px, #fff 0);
    background-position: left top;
}

.receipt-edge-bottom {
    background-image:
        linear-gradient(-45deg, transparent 7px, #fff 0),
        linear-gradient(45deg, transparent 7px, #fff 0);
    background-position: left bottom;
}
</style>

<style>
@media print {
    body * {
        visibility: hidden;
    }

    #receipt,
    #receipt * {
        visibility: visible;
    }

    #receipt {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    #receipt * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: 80mm auto;
        margin: 4mm;
    }
}
</style>