<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Stats from "./Partials/Stats.vue";
import Charts from "./Partials/Charts.vue";
import { DashboardStats } from "@/types";

defineProps<{
    stats: DashboardStats;
}>();

const invoiceDates = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May"],
    data: [15, 20, 25, 35, 20],
};

const invoiceStates = {
    labels: ["Paid", "Outstanding", "Unset"],
    data: [20, 20, 15],
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Stats :stats />
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-12"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Charts :invoiceDates :invoiceStates />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
