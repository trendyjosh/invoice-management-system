<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Table from "./Table.vue";
import Pagination from "./Pagination.vue";
import { LengthAwarePaginator } from "@/types/pagination";

defineProps<{
    invoices: LengthAwarePaginator;
}>();
</script>

<template>
    <template v-if="invoices?.data">
        <Table>
            <template #head>
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <th>ID</th>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </template>
            <template #body>
                <tr
                    class="hover:bg-gray-100 hover:dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-100 dark:border-gray-700"
                    v-for="invoice in invoices.data"
                >
                    <td>
                        <Link
                            :href="
                                route('invoices.edit', { invoice: invoice.id })
                            "
                        >
                            {{ invoice.id }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('invoices.edit', { invoice: invoice.id })
                            "
                        >
                            {{ invoice.invoice_number }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('invoices.edit', { invoice: invoice.id })
                            "
                        >
                            {{ invoice.date }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            v-if="invoice.customer"
                            :href="
                                route('customers.show', {
                                    customer: invoice.customer.id,
                                })
                            "
                        >
                            {{ invoice.customer.name }}
                        </Link>
                        <template v-else> Error </template>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('invoices.edit', { invoice: invoice.id })
                            "
                        >
                            {{ invoice.due_date }}
                        </Link>
                    </td>
                    <td>
                        {{ invoice.paid ? "Paid" : "Outstanding" }}
                    </td>
                    <td>
                        <a
                            :href="
                                route('invoices.print', { invoice: invoice.id })
                            "
                            target="_blank"
                        >
                            Download
                        </a>
                    </td>
                </tr>
            </template>
        </Table>
        <Pagination :paginator="invoices" />
    </template>
    <template v-else> No results </template>
</template>
