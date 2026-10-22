<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    restaurants: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">
                        Restaurants
                    </h3>

                    <div
                        v-if="restaurants.length"
                        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <article
                            v-for="restaurant in restaurants"
                            :key="restaurant.id"
                            class="overflow-hidden rounded-lg bg-white shadow-sm"
                        >
                            <div class="h-32 bg-gray-100">
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

                            <div class="p-5">
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
                                    class="mb-2 text-sm font-medium text-indigo-600"
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
                        </article>
                    </div>

                    <div
                        v-else
                        class="rounded-lg bg-white p-6 text-gray-600 shadow-sm"
                    >
                        No restaurants found.
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
