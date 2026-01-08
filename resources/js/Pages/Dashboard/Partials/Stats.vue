<script setup lang="ts">
import {
    BanknoteArrowUp,
    BanknoteX,
    ReceiptPoundSterling,
    Users,
} from "lucide-vue-next";
</script>

<template>
    <div
        class="stats stats-vertical lg:stats-horizontal bg-white border border-slate-500 w-full"
    >
        <div class="stat border-slate-500">
            <div class="stat-figure text-primary">
                <Users :size="32" />
            </div>
            <div class="stat-title text-primary">Customers</div>
            <div class="stat-value text-primary">4</div>
        </div>

        <div class="stat border-slate-500">
            <div class="stat-figure text-primary">
                <ReceiptPoundSterling :size="32" />
            </div>
            <div class="stat-title text-primary">Invoices</div>
            <div class="stat-value text-primary">2</div>
        </div>

        <div class="stat border-slate-500">
            <div class="stat-figure text-success">
                <BanknoteArrowUp :size="32" />
            </div>
            <div class="stat-title text-primary">Paid</div>
            <div class="stat-value text-success">120</div>
            <div class="stat-desc text-primary">Total: £9,000</div>
        </div>

        <div class="stat border-slate-500">
            <div class="stat-figure text-error">
                <BanknoteX :size="32" />
            </div>
            <div class="stat-title text-primary">Overdue</div>
            <div class="stat-value text-error">50</div>
            <div class="stat-desc text-primary">Total: £1,500</div>
        </div>
    </div>
</template>
