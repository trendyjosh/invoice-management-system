<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    company: Object,
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

            <div v-if="company?.name" class="mt-6">
                <InputLabel value="Name" />

                <p>{{ company.name }}</p>
            </div>

            <div v-if="company?.company_number" class="mt-6">
                <InputLabel value="Company No." />

                <p>{{ company.company_number }}</p>
            </div>

            <div v-if="company?.email" class="mt-6">
                <InputLabel value="Email" />

                <p>{{ company.email }}</p>
            </div>

            <div v-if="company?.phone" class="mt-6">
                <InputLabel value="Phone" />

                <p>{{ company.phone }}</p>
            </div>

            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Address
                </h2>
            </header>

            <div v-if="company?.address_1" class="mt-6">
                <InputLabel value="Line 1" />

                <p>{{ company.address_1 }}</p>
            </div>

            <div v-if="company?.address_2" class="mt-6">
                <InputLabel value="Line 2" />

                <p>{{ company.address_2 }}</p>
            </div>

            <div v-if="company?.city" class="mt-6">
                <InputLabel value="City" />

                <p>{{ company.city }}</p>
            </div>

            <div v-if="company?.county" class="mt-6">
                <InputLabel value="County" />

                <p>{{ company.county }}</p>
            </div>

            <div v-if="company?.postcode" class="mt-6">
                <InputLabel value="Postcode" />

                <p>{{ company.postcode }}</p>
            </div>

            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Payment
                </h2>
            </header>

            <div v-if="company?.bank_name" class="mt-6">
                <InputLabel value="Account Name" />

                <p>{{ company.bank_name }}</p>
            </div>

            <div v-if="company?.bank_acc_no" class="mt-6">
                <InputLabel value="Account Number" />

                <p>{{ company.bank_acc_no }}</p>
            </div>

            <div v-if="company?.bank_sort_code" class="mt-6">
                <InputLabel value="Sort Code" />

                <p>{{ company.bank_sort_code }}</p>
            </div>

            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-primary btn-outline"
                    :href="
                        route('companies.edit', {
                            company: company?.id,
                        })
                    "
                >
                    Edit
                </Link>
            </div>
        </section>
    </div>
</template>
