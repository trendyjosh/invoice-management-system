<script setup lang="ts">
import { useVModel } from "@vueuse/core";

const props = defineProps({
    modelValue: Number,
});

const emits = defineEmits<{
    (e: "update:modelValue", payload: typeof props.modelValue): void;
}>();

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
});

const invoiceNumberFormats = [
    "default (e.g. 7)",
    "customer-based (e.g. 03-007)",
];
</script>

<template>
    <select
        class="select select-bordered w-full bg-white dark:bg-gray-800 disabled:bg-gray-100"
        v-model="modelValue"
    >
        <option
            v-for="(invoiceNumberFormat, index) in invoiceNumberFormats"
            :value="index"
            :selected="modelValue === index"
        >
            {{ invoiceNumberFormat }}
        </option>
    </select>
</template>
