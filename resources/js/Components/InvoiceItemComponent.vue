<script setup lang="ts">
import { InertiaForm } from "@inertiajs/vue3";
import { useVModel } from "@vueuse/core";
import InputError from "@/Components/InputError.vue";

const props = defineProps<{
    modelValue: InvoiceItem;
    id: number;
    form: InertiaForm<any>;
}>();
const emits = defineEmits<{
    (e: "update:modelValue", payload: typeof props.modelValue): void;
    (e: "deleteItem", payload: number): void;
}>();

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
});
</script>

<template>
    <div class="join join-vertical lg:join-horizontal w-full">
        <textarea
            v-model="modelValue.description"
            class="input input-bordered join-item bg-white dark:bg-gray-800 w-full"
        ></textarea>
        <input
            type="number"
            v-model.number="modelValue.quantity"
            class="input input-bordered join-item bg-white dark:bg-gray-800"
        />
        <input
            type="number"
            v-model.number="modelValue.unit_price"
            class="input input-bordered join-item bg-white dark:bg-gray-800"
        />
        <button
            class="lg:ml-5 btn btn-outline btn-error join-item"
            type="button"
            @click="$emit('deleteItem', id)"
        >
            Remove
        </button>
    </div>
    <InputError
        class="mt-2"
        :message="form.errors['invoiceItems.' + id + '.description']"
    />
</template>
