<script setup>
import ImageSlider from '@/Components/ImageSlider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref, toRef } from 'vue';
import SearchBar from '@/Components/SearchBar.vue';
import StarRating from '@/Components/StarRating.vue';

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

const searchRestaurants = (search) => {
    router.get(
        route('restaurants.index'),
        search ? { search } : {},
        { preserveState: true, preserveScroll: true },
    );
};

const filteredRestaurants = computed(() => {
    const restaurants = props.restaurants ?? [];

    if (selectedCategory.value === null) {
        return restaurants;
    }

    return restaurants.filter(
        (restaurant) => restaurant.category?.id === selectedCategory.value,
    );
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Welcome, {{ $page.props.auth.user.name }}
            </h2>
        </template> -->
        
        <div class="pb-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <ImageSlider/>
                <SearchBar @search="searchRestaurants" />
                <div class="mb-6 p-4 rounded-3xl">
                    <div class="mb-6 flex flex-wrap gap-2">
                        <button
                            type="button"
                            class="rounded-full px-4 py-2 text-sm font-medium transition"
                            :class="
                                selectedCategory === null
                                    ? 'bg-shopee text-white'
                                    : 'bg-white/50 backdrop-blur-md text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50'
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
                                    : 'bg-white/50 backdrop-blur-md text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50'
                            "
                            @click="selectedCategory = category.id"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                    <h3 class="px-4 sm:px-0 mb-4 text-lg font-semibold text-gray-900">
                        Popular Restaurants
                    </h3>

                    <div
                        v-if="filteredRestaurants.length"
                        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <article
                            v-for="restaurant in filteredRestaurants"
                            :key="restaurant.id"
                            class="overflow-hidden rounded-lg bg-white/50 backdrop-blur-md shadow-sm hover:bg-gray-100 hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98]"
                        >
                            <Link
                                :href="route('restaurants.show', restaurant.slug)
                                ">
                                <div class="h-64 bg-gray-100">
                                    <img
                                        v-if="restaurant.image_url"
                                        :src="restaurant.image_url"
                                        :alt="restaurant.name"
                                        class="h-full w-full object-cover rounded-2xl"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full items-center justify-center text-gray-400"
                                    >
                                        No image
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="mb-2 flex items-start justify-between gap-3">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ restaurant.name }}
                                        </h4>
                                        <span
                                            class="shrink-0 rounded-full px-2 py-1 text-xs font-medium"
                                            :class="restaurant.is_currently_open
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-red-100 text-red-600'
                                            "
                                        >
                                            {{ restaurant.is_currently_open ? 'Buka' : 'Tutup' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-sm">
                                        <StarRating :rating="restaurant.rating" />
                                        <span class="font-semibold text-gray-800">{{ restaurant.rating.toFixed(1) }}</span>
                                        <span class="text-gray-500">({{ restaurant.reviews_count }} ulasan)</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-8">
                                        {{ restaurant.address }}
                                    </p>
                                </div>
                            </Link>
                        </article>
                    </div>

                    <div
                        v-else
                        class="rounded-lg bg-white/50 backdrop-blur-md p-6 text-gray-600 shadow-sm"
                    >
                        No restaurants found in this category.
                    </div>
                </div>

               <div
                    class="flex flex-col items-center gap-8 rounded-3xl bg-white/60 p-6 shadow-md ring-1 ring-gray-200 backdrop-blur-md md:flex-row md:justify-between md:gap-12 md:p-10"
                >
                    <div class="w-full text-center md:w-1/2 md:text-left">
                        <h2 class="text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:text-4xl">
                            Bingung mau pesan apa?
                            <span class="block text-shopee">Coba fitur gacha restoran!</span>
                        </h2>
                    </div>

                    <div class="flex w-full items-center justify-center md:w-1/2">
                        <div
                            class="flex aspect-square w-full max-w-xs items-center justify-center rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 text-sm text-gray-400"
                        >
                            COMING SOON
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
