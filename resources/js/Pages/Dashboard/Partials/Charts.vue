<script setup lang="ts">
import { DashboardCharts } from "@/types";
import {
    ArcElement,
    CategoryScale,
    Chart,
    Legend,
    LinearScale,
    LineElement,
    PointElement,
    Tooltip,
} from "chart.js";
import { Doughnut, Line } from "vue-chartjs";

Chart.register(
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement
);

defineProps<{
    charts: DashboardCharts;
}>();
</script>

<template>
    <div
        class="stats stats-vertical lg:stats-horizontal bg-white w-full flex flex-col lg:flex-row"
    >
        <div class="stat lg:w-2/3 border-gray-100">
            <div class="stat-title text-primary">Line chart</div>
            <div class="stat-value text-primary">
                <Line
                    :data="{
                        labels: charts.invoiceDates.labels,
                        datasets: [
                            {
                                data: charts.invoiceDates.data,
                                borderColor: '#5a6eb9',
                            },
                        ],
                    }"
                    :options="{
                        responsive: true,
                        interaction: {
                            intersect: false,
                        },
                    }"
                />
            </div>
        </div>

        <div class="stat lg:w-1/3 border-gray-100">
            <div class="stat-title text-primary">Doughnut chart</div>
            <div class="stat-value text-primary">
                <Doughnut
                    :data="{
                        labels: charts.invoiceStates.labels,
                        datasets: [
                            {
                                data: charts.invoiceStates.data,
                                backgroundColor: [
                                    '#8c9de0',
                                    '#e6e9f2',
                                    '#5a6eb9',
                                ],
                                hoverOffset: 5,
                            },
                        ],
                    }"
                    :options="{
                        responsive: true,
                    }"
                />
            </div>
        </div>
    </div>
</template>
