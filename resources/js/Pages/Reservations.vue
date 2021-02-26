<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Games Providers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-12">
                    <vue-table :header="header" :content="gameProviderQueues"></vue-table>
                </div>
                <pagination v-if="gameProviderQueue.last_page > 1" :data="gameProviderQueue" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import SearchForm from "@/Pages/GameProviders/SearchForm";
import VueTable from '@/Shared/VueTable';
// import Pagination from "@/Shared/Pagination";

export default {
    components: {
        // Pagination,
        AppLayout,
        Welcome,
        SearchForm,
        VueTable
    },

    data() {
        return {
            header: [
                'Environment', 'App', 'Provider', 'User', 'Notes', 'Started at', 'Ended at', 'Applied At', 'Is Active'
            ],
            queue: null
        };
    },

    computed: {
        gameProviderQueues() {
            if (this.gameProviderQueue) {
                return this.gameProviderQueue.data.map(data => {
                    return {
                        environment: data.environment.name,
                        application: data.application.name,
                        provider: data.game_provider.name,
                        user: data.user.name,
                        notes: data.notes,
                        started_at: data.started_at,
                        ended_at: data.ended_at,
                        applied_at: data.applied_at,
                        is_active: data.is_active
                    };
                });
            }

            return null;
        }
    },

    props: {
        gameProviderQueue: Array
    }
};
</script>
