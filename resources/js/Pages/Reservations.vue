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
                <div class="py-12">
                    <vue-table :header="header" :content="content"></vue-table>
                </div>
<!--                <pagination v-if="gameProviderQueue.last_page > 1"-->
<!--                            :data="gameProviderQueue" />-->
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import SearchForm from "@/Pages/GameProviders/SearchForm";
import VueTable from '@/Shared/VueTable';
import Pagination from "@/Shared/Pagination";

export default {
    components: {
        Pagination,
        AppLayout,
        Welcome,
        SearchForm,
        VueTable
    },

    data() {
        return {
            header: [
                'Environment', 'App', 'Provider', 'User Id', 'Notes', 'Started at', 'Ended at', 'Applied At', 'Is Active'
            ],
            queue: null,
            content: null
        };
    },

    mounted() {
        console.log(this.gameProviderQueue)

        this.content = this.gameProviderQueue.data.map(data => {
            return {
                environment_id: data.environment_id,
                application_id: data.application_id,
                game_provider_id: data.game_provider_id,
                user_id: data.user_id,
                notes: data.notes,
                started_at: data.started_at,
                ended_at: data.ended_at,
                applied_at: data.applied_at,
                is_active: data.is_active
            };
        });
    },

    props: {
        gameProviderQueue: Array
    }
};
</script>
