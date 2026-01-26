<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InvoicesTable from "@/Components/InvoicesTable.vue";
import { Head, Link } from "@inertiajs/vue3";
import { LengthAwarePaginator } from "@/types/pagination";

defineProps<{
    invoices: LengthAwarePaginator;
    orderKey: string;
    orderDir: string;
}>();
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
            <div class="flex space-between">
                <a
                    class="btn btn-outline btn-primary mr-2"
                    :href="route('invoices.export')"
                >
                    Export
                </a>
                <Link
                    class="btn btn-outline btn-primary"
                    :href="route('invoices.create')"
                >
                    Add
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <InvoicesTable :invoices :orderKey :orderDir />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
