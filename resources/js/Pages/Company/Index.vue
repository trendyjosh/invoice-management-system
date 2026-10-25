<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CompaniesTable from "@/Components/CompaniesTable.vue";
import { Head, Link } from "@inertiajs/vue3";
import { LengthAwarePaginator } from "@/types/pagination";

defineProps<{
    companies: LengthAwarePaginator;
}>();
</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Companies
            </h2>
            <div class="flex space-between">
                <a
                    class="btn btn-outline btn-primary mr-2"
                    :href="route('companies.export')"
                >
                    Export
                </a>
                <Link
                    class="btn btn-outline btn-primary"
                    :href="route('companies.create')"
                >
                    Add
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CompaniesTable :companies="companies" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
