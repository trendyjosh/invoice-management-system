<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    company_name: user.company_name,
    company_number: user.company_number,
    address_1: user.address_1,
    address_2: user.address_2,
    city: user.city,
    county: user.county,
    postcode: user.postcode,
    phone: user.phone,
    bank_name: user.bank_name,
    bank_acc_no: user.bank_acc_no,
    bank_sort_code: user.bank_sort_code,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
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

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Company Information
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update your company information and payment details.
                </p>
            </header>

            <div>
                <InputLabel for="company_name" value="Company Name" />

                <TextInput
                    id="company_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company_name"
                    required
                    autocomplete="company_name"
                />

                <InputError class="mt-2" :message="form.errors.company_name" />
            </div>

            <div>
                <InputLabel for="company_number" value="Company Number" />

                <TextInput
                    id="emacompany_numberil"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company_number"
                    required
                    autocomplete="company_number"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.company_number"
                />
            </div>

            <div>
                <InputLabel for="bank_name" value="Account Name" />

                <TextInput
                    id="bank_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.bank_name"
                    required
                    autocomplete="bank_name"
                />

                <InputError class="mt-2" :message="form.errors.bank_name" />
            </div>

            <div>
                <InputLabel for="bank_acc_no" value="Account Number" />

                <TextInput
                    id="bank_acc_no"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.bank_acc_no"
                    required
                    autocomplete="bank_acc_no"
                />

                <InputError class="mt-2" :message="form.errors.bank_acc_no" />
            </div>

            <div>
                <InputLabel for="bank_sort_code" value="Sort Code" />

                <TextInput
                    id="bank_sort_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.bank_sort_code"
                    required
                    autocomplete="bank_sort_code"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.bank_sort_code"
                />
            </div>

            <header>
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Address
                </h2>
            </header>

            <div>
                <InputLabel for="address_1" value="Line 1" />

                <TextInput
                    id="address_1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address_1"
                    required
                    autocomplete="address_1"
                />

                <InputError class="mt-2" :message="form.errors.address_1" />
            </div>

            <div>
                <InputLabel for="address_2" value="Line 2" />

                <TextInput
                    id="address_2"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address_2"
                    autocomplete="address_2"
                />

                <InputError class="mt-2" :message="form.errors.address_2" />
            </div>

            <div>
                <InputLabel for="city" value="City" />

                <TextInput
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                    required
                    autocomplete="city"
                />

                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div>
                <InputLabel for="county" value="County" />

                <TextInput
                    id="county"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.county"
                    autocomplete="county"
                />

                <InputError class="mt-2" :message="form.errors.county" />
            </div>

            <div>
                <InputLabel for="postcode" value="Postcode" />

                <TextInput
                    id="postcode"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.postcode"
                    required
                    autocomplete="postcode"
                />

                <InputError class="mt-2" :message="form.errors.postcode" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

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
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
