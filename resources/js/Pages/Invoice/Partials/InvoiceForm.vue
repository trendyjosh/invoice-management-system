<script setup lang="ts">
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CustomersSelect from "@/Components/CustomersSelect.vue";
import InvoiceItemComponent from "@/Components/InvoiceItemComponent.vue";
import { useForm, InertiaForm } from "@inertiajs/vue3";

const props = defineProps({
    customers: Object,
    selected: Object,
    invoice: Object,
});

const form: InertiaForm<{
    customer: number;
    invoiceItems: Array<InvoiceItem>;
}> = useForm({
    customer: props.selected?.id,
    invoiceItems: props.invoice?.invoice_items || Array<InvoiceItem>(),
});

/**
 * Add a new empty invoice item.
 */
function addItem() {
    const invoiceItem = ref<InvoiceItem>({
        description: "",
        quantity: 1,
        unit_price: 0,
    });
    form.invoiceItems.push(invoiceItem.value);
}

/**
 * Delete selected invoice item.
 */
function deleteItem(key: number) {
    form.invoiceItems.splice(key, 1);
    console.log("Removed: " + key);
}

/**
 * Submit invoice form as patch or post depending on
 * presence of invoice id.
 */
function submit() {
    if (props.invoice) {
        form.patch(
            route("invoices.update", {
                invoice: props.invoice!.id,
            })
        );
    } else {
        form.post(route("invoices.store"));
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <section class="space-y-6">
                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Details
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Select your customer and invoice dates.
                    </p>
                </header>
                <div class="mt-6">
                    <InputLabel value="Customer" />

                    <p v-if="invoice">{{ invoice.customer.name }}</p>
                    <CustomersSelect
                        v-else
                        :customers="customers"
                        v-model="form.customer"
                    />
                    <InputError class="mt-2" :message="form.errors.customer" />
                </div>

                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Invoice Items
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        The invoice total is calculated from the sum of all
                        invoice items.
                    </p>
                </header>

                <div class="space-y-6">
                    <InvoiceItemComponent
                        v-for="(invoiceItem, index) in form.invoiceItems"
                        :id="index"
                        :form="form"
                        v-model="form.invoiceItems[index]"
                        @delete-item="deleteItem"
                    />
                    <button
                        class="btn btn-outline btn-primary"
                        type="button"
                        @click="addItem"
                    >
                        Add item
                    </button>
                </div>

                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Summary
                    </h2>

                    <InputLabel
                        >Amount:
                        {{
                            "£" +
                            form.invoiceItems.reduce(
                                (
                                    accumulator: number,
                                    currentValue: InvoiceItem
                                ) =>
                                    accumulator +
                                    currentValue.quantity *
                                        currentValue.unit_price,
                                0
                            )
                            .toFixed(2)
                        }}
                    </InputLabel>
                </header>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">{{
                        invoice ? "Update" : "Create"
                    }}</PrimaryButton>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >
                            Created.
                        </p>
                    </Transition>
                </div>
            </section>
        </div>
    </form>
</template>
