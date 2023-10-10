<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
    customers: Object,
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table bg-white dark:bg-gray-800">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <th>No.</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Invoices</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="hover:bg-gray-100 hover:dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-100 dark:border-gray-700"
                    v-for="customer in customers"
                >
                    <td>
                        <Link
                            :href="
                                route('customers.show', {
                                    customer: customer.id,
                                })
                            "
                        >
                            {{ customer.id }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('customers.show', {
                                    customer: customer.id,
                                })
                            "
                        >
                            {{ customer.name }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('customers.show', {
                                    customer: customer.id,
                                })
                            "
                        >
                            {{ customer.address_1 }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('invoices.index', {
                                    customer: customer.id,
                                })
                            "
                        >
                            {{ customer.invoices.length }}
                        </Link>
                    </td>
                    <td>
                        <a
                            :href="
                                route('customers.show', {
                                    customer: customer.id,
                                })
                            "
                            target="_blank"
                        >
                            Download
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
