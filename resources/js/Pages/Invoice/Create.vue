<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import InvoiceForm from "./Partials/InvoiceForm.vue";

defineProps({
    customers: Object,
    selected: Object,
});
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Invoice
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <InvoiceForm :customers="customers" :selected="selected" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
