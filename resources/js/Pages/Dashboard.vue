<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!--<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>-->

                <div v-for="chart in charts" :key="chart.id" class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4 p-4">
                    <apexchart width="100%" type="heatmap" :options="chart.options" :series="chart.series" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import VueApexCharts from 'vue3-apexcharts'

    export default {
        components: {
            AppLayout,
            Welcome,
            apexchart: VueApexCharts,
        },
        props: {
            charts: {
                type: Array,
                default: []
            }
        },

        mounted() {
            // console.log(this.chartOptions, this.charts[0].chartOptions)
            // console.log(this.series, this.charts[0].series)
            // console.log(this.charts)
        },

        data() {
            return {
                chartss: _.merge({}, this.charts),

                // chartOptions: {
                //     dataLabels: {
                //         enabled: true
                //     },
                //     colors: ["#008FFB"],
                //     xaxis: {
                //         type: 'category',
                //     },
                //     title: {
                //         text: 'Environment Location Reservation Map'
                //     }
                // },
                // series: [{
                //     name: 'Metric1',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric2',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric3',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric4',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric5',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric6',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric7',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric8',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric9',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric10',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric11',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric12',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric13',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric14',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric15',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric16',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric17',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric18',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric19',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric20',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric21',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric22',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric23',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric24',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }, {
                //     name: 'Metric25',
                //     data: this.generateData(24, {min: 0, max: 90})
                // }],
            }
        },
        methods: {
            // generateData(count, yrange) {
            //     var i = 0;
            //     var series = [];
            //     while (i < count) {
            //         var x = (i + 1).toString();
            //         var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            //         series.push({
            //             x: x,
            //             y: y
            //         });
            //         i++;
            //     }
            //     return series;
            // }
        }
    }
</script>
