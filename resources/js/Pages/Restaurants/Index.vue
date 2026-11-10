<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StarRating from '@/Components/StarRating.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';

defineProps({
    restaurants: {
        type: Array,
        required: true,
    },
    search: {
        type: String,
        default: '',
    },
});


const searchRestaurants = (search) => {
    console.log(search);
    router.get(
        route('restaurants.index'),
        search ? { search } : {},
        { preserveState: true, preserveScroll: true },
    );
};
</script>

<template>
    <Head title="Restaurants" />

    <AuthenticatedLayout>
        <div class="pb-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <SearchBar
                    class="py-8"
                    :initial-search="search"
                    @search="searchRestaurants"
                />

                <div
                    v-if="restaurants.length"
                    class="flex flex-col gap-4"
                >
                    <Link
                        v-for="restaurant in restaurants"
                        :key="restaurant.id"
                        :href="route('restaurants.show', restaurant.slug)"
                        class="flex flex-col gap-4 rounded-2xl bg-white/70 p-4 shadow-sm backdrop-blur-md transition hover:-translate-y-0.5 hover:shadow-lg sm:flex-row"
                    >
                        <div class="h-40 shrink-0 overflow-hidden rounded-xl bg-gray-100 sm:w-52">
                            <img
                                v-if="restaurant.image_url"
                                :src="restaurant.image_url"
                                :alt="restaurant.name"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full items-center justify-center text-gray-400"
                            >
                                No image
                            </div>
                        </div>
                        <div class="flex min-w-0 flex-1 flex-col justify-center">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ restaurant.name }}
                                </h3>
                                <span
                                    class="shrink-0 rounded-full px-2 py-1 text-xs font-medium"
                                    :class="
                                        restaurant.is_currently_open
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-600'
                                    "
                                >
                                    {{ restaurant.is_currently_open ? 'Buka' : 'Tutup' }}
                                </span>
                            </div>
                            <p
                                v-if="restaurant.category"
                                class="mt-2 text-sm font-medium text-shopee"
                            >
                                {{ restaurant.category.name }}
                            </p>
                            <div class="mt-3 flex items-center gap-1.5 text-sm">
                                <StarRating :rating="restaurant.rating" />
                                <span class="font-semibold text-gray-800">
                                    {{ Number(restaurant.rating || 0).toFixed(1) }}
                                </span>
                                <span class="text-gray-500">
                                    ({{ restaurant.reviews_count || 0 }} ulasan)
                                </span>
                            </div>
                            <p class="mt-3 text-sm text-gray-500">
                                {{ restaurant.address }}
                            </p>
                        </div>
                    </Link>
                </div>
                <div
                    v-else
                    class="rounded-2xl bg-white/70 p-6 text-gray-600 shadow-sm"
                >
                    No result found
                    <span v-if="search"> for "{{ search }}"</span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
