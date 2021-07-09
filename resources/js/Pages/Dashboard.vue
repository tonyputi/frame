<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="chart in charts" :key="chart.id" class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4 p-4">
                    <apexchart width="100%" type="heatmap" :options="chart.options" :series="chart.series" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import VueApexCharts from 'vue3-apexcharts'

    export default {
        components: {
            AppLayout,
            apexchart: VueApexCharts,
        },

        props: {
            charts: {
                type: Array,
                default: []
            }
        },

        mounted() {
            console.log(this.charts)
        }
    }
</script>
