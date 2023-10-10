<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    customer: Object,
});

const form = useForm({
    name: props.customer?.name || "",
    email: props.customer?.email || "",
    address_1: props.customer?.address_1 || "",
    address_2: props.customer?.address_2 || "",
    city: props.customer?.city || "",
    county: props.customer?.county || "",
    postcode: props.customer?.postcode || "",
});

function submit() {
    if (props.customer) {
        form.patch(
            route("customers.update", {
                customer: props.customer!.id,
            })
        );
    } else {
        form.post(route("customers.store"));
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
                </header>

                <div class="mt-6">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-6">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
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
                        v-model="form.address_1"
                        required
                        autofocus
                        autocomplete="address_1"
                    />
                    <InputError class="mt-2" :message="form.errors.address_1" />
                </div>

                <div class="mt-6">
                    <InputLabel for="address_2" value="Line 2" />

                    <TextInput
                        id="address_2"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.address_2"
                        autofocus
                        autocomplete="address_2"
                    />
                    <InputError class="mt-2" :message="form.errors.address_2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="city" value="City" />

                    <TextInput
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                        required
                        autofocus
                        autocomplete="city"
                    />
                    <InputError class="mt-2" :message="form.errors.city" />
                </div>

                <div class="mt-6">
                    <InputLabel for="county" value="County" />

                    <TextInput
                        id="county"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.county"
                        autofocus
                        autocomplete="county"
                    />
                    <InputError class="mt-2" :message="form.errors.county" />
                </div>

                <div class="mt-6">
                    <InputLabel for="postcode" value="PostCode" />

                    <TextInput
                        id="postcode"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.postcode"
                        required
                        autofocus
                        autocomplete="postcode"
                    />
                    <InputError class="mt-2" :message="form.errors.postcode" />
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">{{
                        customer ? "Update" : "Create"
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
