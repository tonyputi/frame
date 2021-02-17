<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Casino Providers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <search-form></search-form>
                <vue-table :header="header" :content="content"></vue-table>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import SearchForm from "@/Pages/GameProviders/SearchForm";
import VueTable from '@/Shared/VueTable';

export default {
    components: {
        AppLayout,
        Welcome,
        SearchForm,
        VueTable
    },

    data() {
        return {
            header: [
                'id', 'environment_id', 'application_id', 'Game Provider', 'Host', 'Notes',  'Started at', 'Ended at', 'applied_at' , 'Is Active', 'created_at', 'updated_at'
            ],
            queue: null,
            content: null
        }
    },

    mounted() {
        this.content = this.gameProviderQueue.data
    },

    props: {
      gameProviderQueue: Array
    }
};
</script>
