<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Environment -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="environment_id" value="Environment" />
                    <jet-select id="environment_id" class="mt-1 block w-full" v-model="environment_id" :options="environments" />
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4 p-4">
                    <apexchart ref="heatmap" width="100%" type="heatmap" :options="heatmap.options" :series="heatmap.series" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSelect from '@/Jetstream/Select'
    import JetLabel from '@/Jetstream/Label'
    import VueApexCharts from 'vue3-apexcharts'

    export default {
        components: {
            AppLayout,
            JetSelect,
            JetLabel,
            apexchart: VueApexCharts,
        },

        props: {
            environments: {
                type: Object,
                default: []
            }
        },

        data() {
            return {
                environment_id: String(_.head(Object.values(this.environments))),
                heatmap: {
                    options: {
                        plotOptions: {
                            heatmap: {
                                distributed: true,
                                colorScale: {
                                    ranges: [
                                        {from: 0, to: 0, color: '#00A100', name: 'Low'},
                                        {from: 1, to: 3, color: '#FFBF00', name: 'Normal'},
                                        {from: 4, to: 100, color: '#990000', name: 'High'}
                                    ]
                                }
                            }
                        },
                        chart: {
                            toolbar: { show: false },
                            // events: {
                            //     mounted: function(chartContext, config) {
                            //         console.log(chartContext, config)
                            //     }
                            // }
                        },
                        dataLabels: { enabled: true },
                        colors: ['#008FFB'],
                        xaxis: {
                            type: 'category',
                            categories: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
                        }
                    },
                    series: []
                }
            }
        },

        mounted() {
            this.$nextTick(() => {
                this.fetch()
            })
        },

        methods: {
            fetch() {
                axios.get(`/api/heatmap/${this.environment_id}`).then((response) => {
                    // this.$refs.heatmap.updateOptions(response.data.options);
                    this.$refs.heatmap.updateSeries(response.data.series);
                })
            }
        }
    }
</script>
