<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Table from "./Table.vue";

defineProps({
    customers: Object,
});
</script>

<template>
    <Table>
        <template #head>
            <tr class="border-b border-gray-100 dark:border-gray-700">
                <th>No.</th>
                <th>Name</th>
                <th>Address</th>
                <th>Invoices</th>
            </tr>
        </template>
        <template #body>
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
                        {{ customer.customer_number }}
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
            </tr>
        </template>
    </Table>
</template>
