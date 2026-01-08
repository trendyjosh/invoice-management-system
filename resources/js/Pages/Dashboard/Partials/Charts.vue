<script setup lang="ts">
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
</script>

<template>
    <div
        class="stats stats-vertical lg:stats-horizontal bg-white border border-slate-500 w-full flex"
    >
        <div class="stat border-slate-500 w-2/3">
            <div class="stat-title text-primary">Line chart</div>
            <div class="stat-value text-primary">
                <Line
                    :data="{
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                        datasets: [
                            {
                                data: [15, 20, 25, 35, 20],
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

        <div class="stat border-slate-50 w-1/3">
            <div class="stat-title text-primary">Doughnut chart</div>
            <div class="stat-value text-primary">
                <Doughnut
                    :data="{
                        labels: ['Paid', 'Outstanding', 'Unset'],
                        datasets: [
                            {
                                data: [20, 20, 15],
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
