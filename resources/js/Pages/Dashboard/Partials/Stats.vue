<script setup lang="ts">
import { DashboardStat } from "@/types";
import { Link } from "@inertiajs/vue3";
import {
    BanknoteArrowUp,
    BanknoteX,
    ReceiptPoundSterling,
    Users,
} from "lucide-vue-next";

defineProps<{
    stats: {
        customers: DashboardStat;
        invoices: DashboardStat;
        paid: DashboardStat;
        overdue: DashboardStat;
    };
}>();
</script>

<template>
    <div class="stats stats-vertical lg:stats-horizontal bg-white w-full">
        <Link
            :href="route('customers.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-primary">
                <Users :size="32" />
            </div>
            <div class="stat-title text-primary">
                {{ stats.customers.title }}
            </div>
            <div class="stat-value text-primary">
                {{ stats.customers.value }}
            </div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-primary">
                <ReceiptPoundSterling :size="32" />
            </div>
            <div class="stat-title text-primary">
                {{ stats.invoices.title }}
            </div>
            <div class="stat-value text-primary">
                {{ stats.invoices.value }}
            </div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-success">
                <BanknoteArrowUp :size="32" />
            </div>
            <div class="stat-title text-primary">{{ stats.paid.title }}</div>
            <div class="stat-value text-success">{{ stats.paid.value }}</div>
            <div class="stat-desc text-primary">
                {{ stats.paid.description }}
            </div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-error">
                <BanknoteX :size="32" />
            </div>
            <div class="stat-title text-primary">{{ stats.overdue.title }}</div>
            <div class="stat-value text-error">{{ stats.overdue.value }}</div>
            <div class="stat-desc text-primary">
                {{ stats.overdue.description }}
            </div>
        </Link>
    </div>
</template>
