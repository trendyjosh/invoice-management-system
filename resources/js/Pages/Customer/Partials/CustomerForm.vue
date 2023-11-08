<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    customer: Object,
});

const storeForm = useForm({
    name: props.customer?.name || "",
    email: props.customer?.email || "",
    address_1: props.customer?.address_1 || "",
    address_2: props.customer?.address_2 || "",
    city: props.customer?.city || "",
    county: props.customer?.county || "",
    postcode: props.customer?.postcode || "",
    payment_terms: props.customer?.payment_terms || 0,
});

function store() {
    if (props.customer) {
        storeForm.patch(
            route("customers.update", {
                customer: props.customer!.id,
            })
        );
    } else {
        storeForm.post(route("customers.store"));
    }
}

const archiveForm = useForm({});

function archive() {
    archiveForm.patch(
        route("customers.archive", {
            customer: props.customer!.id,
        })
    );
}
</script>

<template>
    <form @submit.prevent="store">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <section class="space-y-6">
                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Details
                    </h2>
                </header>

                <div class="mt-6">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="storeForm.errors.name" />
                </div>

                <div class="mt-6">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.email"
                        required
                        autofocus
                        autocomplete="email"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.email"
                    />
                </div>

                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Address
                    </h2>
                </header>

                <div class="mt-6">
                    <InputLabel for="address_1" value="Line 1" />

                    <TextInput
                        id="address_1"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.address_1"
                        required
                        autofocus
                        autocomplete="address_1"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.address_1"
                    />
                </div>

                <div class="mt-6">
                    <InputLabel for="address_2" value="Line 2" />

                    <TextInput
                        id="address_2"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.address_2"
                        autofocus
                        autocomplete="address_2"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.address_2"
                    />
                </div>

                <div class="mt-6">
                    <InputLabel for="city" value="City" />

                    <TextInput
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.city"
                        required
                        autofocus
                        autocomplete="city"
                    />
                    <InputError class="mt-2" :message="storeForm.errors.city" />
                </div>

                <div class="mt-6">
                    <InputLabel for="county" value="County" />

                    <TextInput
                        id="county"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.county"
                        autofocus
                        autocomplete="county"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.county"
                    />
                </div>

                <div class="mt-6">
                    <InputLabel for="postcode" value="Postcode" />

                    <TextInput
                        id="postcode"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.postcode"
                        required
                        autofocus
                        autocomplete="postcode"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.postcode"
                    />
                </div>

                <div class="mt-6">
                    <InputLabel for="payment_terms" value="Payment Terms" />

                    <TextInput
                        id="payment_terms"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="storeForm.payment_terms"
                        required
                        autofocus
                        autocomplete="payment_terms"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.payment_terms"
                    />
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="storeForm.processing">{{
                        customer ? "Update" : "Create"
                    }}</PrimaryButton>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="storeForm.recentlySuccessful"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >
                            Created.
                        </p>
                    </Transition>
                </div>
            </section>
        </div>
    </form>
    <form v-if="customer" @submit.prevent="archive">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <section class="space-y-6">
                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Archive customer
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Once a customer has been archived you can no longer
                        create new invoices for them. Their old invoices will
                        still be available, however.
                    </p>
                </header>

                <div class="flex items-center gap-4">
                    <SecondaryButton :disabled="archiveForm.processing">
                        Archive
                    </SecondaryButton>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="archiveForm.recentlySuccessful"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >
                            Archived.
                        </p>
                    </Transition>
                </div>
            </section>
        </div>
    </form>
</template>
