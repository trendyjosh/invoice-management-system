<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CustomersTable from "@/Components/CustomersTable.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    customers: Object,
});
</script>

<template>
    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Customers
            </h2>
            <Link
                class="btn btn-outline btn-primary"
                :href="route('customers.create')"
            >
                Create
            </Link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CustomersTable :customers="customers" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
