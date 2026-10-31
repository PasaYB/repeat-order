<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    restaurants: {
        type: Array,
        required: true,
    },
});

const selectedCategory = ref(null);

const filteredRestaurants = computed(() => {
    if (selectedCategory.value === null) {
        return props.restaurants;
    }

    return props.restaurants.filter(
        (restaurant) => restaurant.category?.id === selectedCategory.value,
    );
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Welcome, {{ $page.props.auth.user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h3 class="px-4 sm:px-0 mb-4 text-lg font-semibold text-gray-900">
                        Restaurants
                    </h3>

                    <div class="px-4 sm:px-0 mb-6 flex flex-wrap gap-2">
                        <button
                            type="button"
                            class="rounded-full px-4 py-2 text-sm font-medium transition"
                            :class="
                                selectedCategory === null
                                    ? 'bg-shopee text-white'
                                    : 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50'
                            "
                            @click="selectedCategory = null"
                        >
                            All
                        </button>
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            type="button"
                            class="rounded-full px-4 py-2 text-sm font-medium transition"
                            :class="
                                selectedCategory === category.id
                                    ? 'bg-shopee text-white'
                                    : 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50'
                            "
                            @click="selectedCategory = category.id"
                        >
                            {{ category.name }}
                        </button>
                    </div>

                    <div
                        v-if="filteredRestaurants.length"
                        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <article
                            v-for="restaurant in filteredRestaurants"
                            :key="restaurant.id"
                            class="overflow-hidden rounded-lg p-4 bg-white shadow-sm hover:bg-gray-100 hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98]"
                        >
                            <Link
                                :href="route('restaurants', restaurant.slug)
                                ">
                                <div class="h-32 bg-gray-100">
                                    <img
                                        v-if="restaurant.image_url"
                                        :src="restaurant.image_url"
                                        :alt="restaurant.name"
                                        class="h-full w-full object-cover rounded-lg"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full items-center justify-center text-gray-400"
                                    >
                                        No image
                                    </div>
                                </div>

                                <div class="p-2 mt-4">
                                    <div class="mb-2 flex items-start justify-between gap-3">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ restaurant.name }}
                                        </h4>
                                        <span
                                            class="shrink-0 rounded-full px-2 py-1 text-xs font-medium"
                                            :class="
                                                restaurant.is_open
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-gray-100 text-gray-600'
                                            "
                                        >
                                            {{ restaurant.is_open ? 'Open' : 'Closed' }}
                                        </span>
                                    </div>

                                    <p
                                        v-if="restaurant.category"
                                        class="mb-2 text-sm font-medium text-shopee"
                                    >
                                        {{ restaurant.category.name }}
                                    </p>
                                    <p class="mb-3 text-sm text-gray-600">
                                        {{ restaurant.description }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ restaurant.address }}
                                    </p>
                                </div>
                            </Link>
                        </article>
                    </div>

                    <div
                        v-else
                        class="rounded-lg bg-white p-6 text-gray-600 shadow-sm"
                    >
                        No restaurants found in this category.
                    </div>
                </div>

                <!-- <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
