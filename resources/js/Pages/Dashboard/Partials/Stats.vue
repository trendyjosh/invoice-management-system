<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import {
    BanknoteArrowUp,
    BanknoteX,
    ReceiptPoundSterling,
    Users,
} from "lucide-vue-next";
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
            <div class="stat-title text-primary">Customers</div>
            <div class="stat-value text-primary">4</div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-primary">
                <ReceiptPoundSterling :size="32" />
            </div>
            <div class="stat-title text-primary">Invoices</div>
            <div class="stat-value text-primary">2</div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-success">
                <BanknoteArrowUp :size="32" />
            </div>
            <div class="stat-title text-primary">Paid</div>
            <div class="stat-value text-success">120</div>
            <div class="stat-desc text-primary">Total: £9,000</div>
        </Link>

        <Link
            :href="route('invoices.index')"
            class="stat border-gray-100 hover:opacity-50 duration-200"
        >
            <div class="stat-figure text-error">
                <BanknoteX :size="32" />
            </div>
            <div class="stat-title text-primary">Overdue</div>
            <div class="stat-value text-error">50</div>
            <div class="stat-desc text-primary">Total: £1,500</div>
        </Link>
    </div>
</template>
