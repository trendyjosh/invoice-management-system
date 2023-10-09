<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InvoicesTable from "@/Components/InvoicesTable.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    invoices: Object,
});
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Invoices
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <InvoicesTable :invoices="invoices" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
