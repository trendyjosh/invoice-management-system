<script setup lang="ts">
import { InertiaForm, Link, useForm } from "@inertiajs/vue3";
import Table from "./Table.vue";
import Pagination from "./Pagination.vue";
import { LengthAwarePaginator } from "@/types/pagination";
import { ArrowDown, ArrowUp } from "lucide-vue-next";

const props = defineProps<{
    invoices: LengthAwarePaginator;
    orderKey: string;
    orderDir: string;
}>();

const form: InertiaForm<{
    invoices: Array<number>;
    action: string | null;
}> = useForm({
    invoices: Array<number>(),
    action: null,
});

/**
 * Submit a list of invoices with selected action.
 */
function submit() {
    form.post(route("invoices.action"), {
        onSuccess: () => {
            form.invoices.length = 0;
        },
    });
}

/**
 * Toggle between all invoices selected or unselected.
 */
function toggleAll(event: Event) {
    // Get checkbox input
    const target = event.target as HTMLInputElement;
    if (target.checked) {
        // Add all bookings to selection
        props.invoices.data.forEach((invoice) => {
            form.invoices.push(invoice.id);
        });
    } else {
        // Remove all bookings from selection
        if (form) {
            form.invoices.length = 0;
        }
    }
}

// Prepare table head details
const tableHeads = [
    {
        label: "ID",
        key: "id",
        active: props.orderKey == "id",
        asc: props.orderKey == "id" && props.orderDir == "desc",
    },
    {
        label: "No.",
        key: "number",
        active: props.orderKey == "number",
        asc: props.orderKey == "number" && props.orderDir == "desc",
    },
    {
        label: "Date",
        key: "date",
        active: props.orderKey == "date",
        asc: props.orderKey == "date" && props.orderDir == "desc",
    },
    {
        label: "Customer",
        key: "customer",
        active: props.orderKey == "customer",
        asc: props.orderKey == "customer" && props.orderDir == "desc",
    },
    {
        label: "Due Date",
        key: "due_date",
        active: props.orderKey == "due_date",
        asc: props.orderKey == "due_date" && props.orderDir == "desc",
    },
    {
        label: "Status",
        key: "status",
        active: props.orderKey == "status",
        asc: props.orderKey == "status" && props.orderDir == "desc",
    },
];
</script>

<template>
    <div class="bg-white table p-2" v-show="form.invoices.length">
        <select
            class="select select-bordered border-primary bg-white dark:bg-gray-800 disabled:bg-gray-100 mr-2"
            name="action"
            id="action"
            v-model="form.action"
        >
            <option :value="null">Select...</option>
            <option value="paid">Paid</option>
            <option value="outstanding">Outstanding</option>
        </select>
        <button class="btn btn-outline btn-primary mr-2" @click="submit">
            Apply
        </button>
        {{ form.invoices.length }} invoice(s) selected
    </div>
    <template v-if="invoices?.data">
        <Table>
            <template #head>
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <th>
                        <input
                            title="Select all"
                            type="checkbox"
                            @change="toggleAll"
                        />
                    </th>
                    <th v-for="tableHead in tableHeads">
                        <Link
                            :href="
                                route('invoices.index', {
                                    sort: tableHead.key,
                                    asc: tableHead.asc,
                                })
                            "
                            class="flex items-center"
                        >
                            {{ tableHead.label }}
                            <template v-if="tableHead.active && tableHead.asc">
                                <ArrowUp />
                            </template>
                            <template
                                v-else-if="tableHead.active && !tableHead.asc"
                            >
                                <ArrowDown />
                            </template>
                        </Link>
                    </th>
                    <th>View</th>
                </tr>
            </template>
            <template #body>
                <tr
                    class="hover:bg-gray-100 hover:dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-100 dark:border-gray-700"
                    v-for="invoice in invoices.data"
                >
                    <td>
                        <input
                            type="checkbox"
                            :class="{
                                'border-red-500': form.errors.invoices,
                            }"
                            v-model="form.invoices"
                            :value="invoice.id"
                        />
                    </td>
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
                        {{ invoice.status }}
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
