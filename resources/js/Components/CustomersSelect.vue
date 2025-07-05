<script setup lang="ts">
import { useVModel } from "@vueuse/core";

const props = defineProps({
    customers: Object,
    modelValue: Number,
});

const emits = defineEmits<{
    (e: "update:modelValue", payload: typeof props.modelValue): void;
}>();

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
});
</script>

<template>
    <select
        class="select select-bordered w-full bg-white dark:bg-gray-800 disabled:bg-gray-100"
        v-model="modelValue"
    >
        <option :value="undefined">Select customer...</option>
        <option
            v-for="customer in customers"
            :value="customer.id"
            :selected="modelValue === customer.id"
        >
            {{ customer.name }}
        </option>
    </select>
</template>
