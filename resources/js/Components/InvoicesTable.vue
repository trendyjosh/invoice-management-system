<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
    invoices: Object,
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table bg-white dark:bg-gray-800">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <th>No.</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Due Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="hover:bg-gray-100 hover:dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-100 dark:border-gray-700"
                    v-for="invoice in invoices"
                >
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
                            :href="
                                route('customers.show', {
                                    customer: invoice.customer.id,
                                })
                            "
                        >
                            {{ invoice.customer.name }}
                        </Link>
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
                        <a
                            :href="
                                route('invoices.print', { invoice: invoice.id })
                            "
                            target="_blank"
                        >
                            Download
                        </a>
                        <Link
                            :href="
                                route('invoices.send', { invoice: invoice.id })
                            "
                        >
                            Send
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
