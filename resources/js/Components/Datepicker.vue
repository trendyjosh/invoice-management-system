<script setup lang="ts">
import { useVModel } from "@vueuse/core";
import { format } from "date-fns";
import { Calendar as CalendarIcon } from "lucide-vue-next";

import { ref } from "vue";
import { cn } from "@/lib/utils";
import { Button } from "@/Components/ui/button";
import { Calendar } from "@/Components/ui/calendar";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";

const props = defineProps<{
    modelValue?: Date;
}>();
const emits = defineEmits<{
    (e: "update:modelValue", payload: typeof props.modelValue): void;
}>();

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
});
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                :variant="'outline'"
                :class="
                    cn(
                        'w-full justify-start text-left font-normal',
                        !modelValue && 'text-muted-foreground'
                    )
                "
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <span>{{
                    modelValue ? format(modelValue, "PPP") : "Pick a date"
                }}</span>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar v-model="modelValue" />
        </PopoverContent>
    </Popover>
</template>
