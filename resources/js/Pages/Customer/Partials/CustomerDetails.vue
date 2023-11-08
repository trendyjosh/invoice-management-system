<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    customer: Object,
});
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <section class="space-y-6">
            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Details
                </h2>
            </header>

            <div v-if="customer?.name" class="mt-6">
                <InputLabel value="Name" />

                <p>{{ customer.name }}</p>
            </div>

            <div v-if="customer?.email" class="mt-6">
                <InputLabel value="Email" />

                <p>{{ customer.email }}</p>
            </div>

            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Address
                </h2>
            </header>

            <div v-if="customer?.address_1" class="mt-6">
                <InputLabel value="Line 1" />

                <p>{{ customer.address_1 }}</p>
            </div>

            <div v-if="customer?.address_2" class="mt-6">
                <InputLabel value="Line 2" />

                <p>{{ customer.address_2 }}</p>
            </div>

            <div v-if="customer?.city" class="mt-6">
                <InputLabel value="City" />

                <p>{{ customer.city }}</p>
            </div>

            <div v-if="customer?.county" class="mt-6">
                <InputLabel value="County" />

                <p>{{ customer.county }}</p>
            </div>

            <div v-if="customer?.postcode" class="mt-6">
                <InputLabel value="Postcode" />

                <p>{{ customer.postcode }}</p>
            </div>

            <div v-if="customer?.payment_terms" class="mt-6">
                <InputLabel value="Payment Terms" />

                <p>{{ customer.payment_terms }}</p>
            </div>

            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-primary btn-outline"
                    :href="
                        route('customers.edit', {
                            customer: customer?.id,
                        })
                    "
                >
                    Edit
                </Link>
            </div>
        </section>
    </div>
</template>
