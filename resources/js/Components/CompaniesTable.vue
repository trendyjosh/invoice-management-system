<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Table from "./Table.vue";
import { LengthAwarePaginator } from "@/types/pagination";
import Pagination from "./Pagination.vue";

defineProps<{
    companies: LengthAwarePaginator;
}>();
</script>

<template>
    <template v-if="companies?.data">
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
                    v-for="company in companies.data"
                >
                    <td>
                        <Link
                            :href="
                                route('companies.show', {
                                    company: company.id,
                                })
                            "
                        >
                            {{ company.company_number }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('companies.show', {
                                    company: company.id,
                                })
                            "
                        >
                            {{ company.name }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('companies.show', {
                                    company: company.id,
                                })
                            "
                        >
                            {{ company.address_1 }}
                        </Link>
                    </td>
                    <td>
                        <Link
                            :href="
                                route('invoices.index', {
                                    company: company.id,
                                })
                            "
                        >
                            {{ company.invoices.length }}
                        </Link>
                    </td>
                </tr>
            </template>
        </Table>
        <Pagination :paginator="companies" />
    </template>
    <template v-else> No results </template>
</template>
