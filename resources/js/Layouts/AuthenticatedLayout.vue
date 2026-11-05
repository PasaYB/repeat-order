<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();
const pageKey = computed(() => page.url.split('?')[0]);
const cartSummary = computed(() => page.props.cartSummary);
const profileImage = computed(
    () => page.props.auth.user?.image_url || '/default-profile-images/default.png',
);
const formatPrice = (price) =>
    `Rp ${Number(price).toLocaleString('id-ID')}`;

const showCartBar = computed(
    () => cartSummary.value?.item_count > 0 && !page.props.hideCartBar,
);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <nav
                    class="relative flex z-50 h-16 justify-between rounded-2xl px-4 shadow-lg shadow-slate-900/5 bg-white/10 backdrop-blur-xl border border-white/20"
                >
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationLogo
                                    class="block h-[1.25rem] w-auto fill-current text-shopee -rotate-[8deg]"
                                /> 
                            </Link>
                            <span class="font-playwrite text-shopee ml-2 rotate-[4deg]">
                                SUJA
                            </span>
                        </div>
                    </div>
                    <!-- Navigation Links -->
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                    >
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            text = "Home"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19v-6.733a4 4 0 0 0-1.245-2.9L13.378 3.31a2 2 0 0 0-2.755 0L4.245 9.367A4 4 0 0 0 3 12.267V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2" />
                            </svg>
                        </NavLink>
                        <NavLink
                            :href="route('carts')"
                            :active="route().current('carts')"
                            text = "Carts"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="1.5em" 
                                height="1.5em"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3a1 1 0 00.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </NavLink>
                        <NavLink
                            :href="route('orders.index')"
                            :active="route().current('orders.*')"
                            text = "My Orders"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                                <path d="M0 0h48v48H0z" fill="none" />
                                <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                    <rect width="30" height="36" x="9" y="8" rx="2" />
                                    <path stroke-linecap="round" d="M18 4v6m12-6v6m-14 9h16m-16 8h12m-12 8h8" />
                                </g>
                            </svg>
                        </NavLink>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div class="relative ms-3">
                            <span class="inline-flex rounded-md">
                                <Link
                                :href="route('profile.edit')"
                                class="group relative "
                                >
                                    <img
                                        :src="profileImage"
                                        :alt="$page.props.auth.user.name"
                                        class="size-10 rounded-full object-cover"
                                    >
                                     <span
                                        class="pointer-events-none absolute left-1/2 top-[80%] z-50 mt-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-md bg-shopee px-2.5 py-1 text-xs font-medium text-white opacity-0 shadow-lg transition duration-150 group-hover:translate-y-0 group-hover:opacity-100 group-focus-visible:translate-y-0 group-focus-visible:opacity-100"
                                    >
                                        Hi {{ $page.props.auth.user.name }}, tap for edit profile
                                    </span>
                                </Link>
                            </span>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </nav>

                <!-- CART -->
                <Link
                    v-if="cartSummary?.item_count && showCartBar"
                    :href="route('carts')"
                    class="group fixed inset-x-4 bottom-4 z-50 sm:inset-x-auto sm:right-6 sm:bottom-6 sm:w-96"
                >
                    <div
                        class="flex items-center gap-3 rounded-2xl bg-shopee p-3 text-white shadow-xl shadow-indigo-900/30 ring-1 ring-white/10 transition duration-200 group-hover:-translate-y-0.5 group-active:scale-[0.98]"
                    >
                        <div class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/15">
                            <svg
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
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3a1 1 0 00.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            <span
                                class="absolute -right-1.5 -top-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-400 px-1 text-xs font-bold text-amber-950"
                            >
                                {{ cartSummary.item_count }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="min-w-0 flex-1">
                            <p
                                v-if="cartSummary.restaurant"
                                class="truncate text-sm font-semibold leading-tight"
                            >
                                {{ cartSummary.restaurant.name }}
                            </p>
                            <p
                                v-if="cartSummary.items?.length"
                                class="mt-0.5 truncate text-xs text-indigo-100"
                            >
                                {{ cartSummary.items.slice(0, 2).map((item) => `${item.quantity}× ${item.name}`).join(', ') }}
                                <span v-if="cartSummary.items.length > 2">
                                    +{{ cartSummary.items.length - 2 }} lainnya
                                </span>
                            </p>
                        </div>

                        <!-- Total + CTA -->
                        <div class="flex shrink-0 flex-col items-end">
                            <span class="text-sm font-bold">
                                {{ formatPrice(cartSummary.total || 0) }}
                            </span>
                            <span class="mt-0.5 flex items-center gap-1 text-xs text-indigo-100">
                                Lihat cart
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden"
            >
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Home
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('profile.edit')"
                        :active="route().current('profile.edit')"
                    >
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('orders.index')"
                        :active="route().current('orders.*')"
                    >
                        Orders
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div
                    class="border-t border-gray-200 pb-1 pt-4"
                >
                    <div class="px-4">
                        <div
                            class="text-base font-medium text-gray-800"
                        >
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            Profile
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            <header
                class="relative z-0 bg-transparent flex"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main :key="pageKey" class="animate-pop">
                <slot />
            </main>
        </div>
    </div>
</template>
