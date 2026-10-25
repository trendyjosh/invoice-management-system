<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    company: Object,
});

const storeForm = useForm({
    name: props.company?.name || "",
    company_number: props.company?.company_number || "",
    address_1: props.company?.address_1 || "",
    address_2: props.company?.address_2 || "",
    city: props.company?.city || "",
    county: props.company?.county || "",
    postcode: props.company?.postcode || "",
    phone: props.company?.phone || "",
    bank_name: props.company?.bank_name || "",
    bank_acc_no: props.company?.bank_acc_no || "",
    bank_sort_code: props.company?.bank_sort_code || "",
});

function store() {
    if (props.company) {
        storeForm.patch(
            route("companies.update", {
                company: props.company!.id,
            }),
        );
    } else {
        storeForm.post(route("companies.store"));
    }
}

const archiveForm = useForm({});

function archive() {
    archiveForm.patch(
        route("companies.archive", {
            company: props.company!.id,
        }),
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
                    <InputLabel for="company_number" value="Company Number" />

                    <TextInput
                        id="company_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.company_number"
                        required
                        autofocus
                        autocomplete="company_number"
                    />
                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.company_number"
                    />
                </div>

                <div>
                    <InputLabel for="phone" value="Phone" />

                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.phone"
                        required
                        autocomplete="phone"
                    />

                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.phone"
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

                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Payment details
                    </h2>
                </header>

                <div>
                    <InputLabel for="bank_name" value="Account Name" />

                    <TextInput
                        id="bank_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.bank_name"
                        required
                        autocomplete="bank_name"
                    />

                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.bank_name"
                    />
                </div>

                <div>
                    <InputLabel for="bank_acc_no" value="Account Number" />

                    <TextInput
                        id="bank_acc_no"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.bank_acc_no"
                        required
                        autocomplete="bank_acc_no"
                    />

                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.bank_acc_no"
                    />
                </div>

                <div>
                    <InputLabel for="bank_sort_code" value="Sort Code" />

                    <TextInput
                        id="bank_sort_code"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="storeForm.bank_sort_code"
                        required
                        autocomplete="bank_sort_code"
                    />

                    <InputError
                        class="mt-2"
                        :message="storeForm.errors.bank_sort_code"
                    />
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="storeForm.processing">{{
                        company ? "Update" : "Create"
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
    <form v-if="company" @submit.prevent="archive">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <section class="space-y-6">
                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Archive company
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Once a company has been archived you can no longer
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
