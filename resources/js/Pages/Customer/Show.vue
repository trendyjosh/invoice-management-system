<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import InvoicesTable from "@/Components/InvoicesTable.vue";
import CustomerDetails from "./Partials/CustomerDetails.vue";

defineProps({
    customer: Object,
});
</script>

<template>
    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                View Customer
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CustomerDetails :customer="customer" />
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <InvoicesTable :invoices="customer?.invoices" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
