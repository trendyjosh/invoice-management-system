<script setup lang="ts">
import { useVModel } from "@vueuse/core";

const props = defineProps({
    companies: Object,
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
        <option :value="undefined">Select company...</option>
        <option
            v-for="company in companies"
            :value="company.id"
            :selected="modelValue === company.id"
        >
            {{ company.name }}
        </option>
    </select>
</template>
