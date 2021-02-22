<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Providers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div>
                        <inertia-link :href="route('game-providers.create')" class="ml-4 text-sm text-black-500">
                            Create
                        </inertia-link>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr class="border border-black-600">
                                <th class="px-2 py-2 text-sm text-center">#</th>
                                <th class="px-2 py-2 text-sm text-center">Name</th>
                                <th class="px-2 py-2 text-sm text-center">Reservations</th>
                                <th class="px-2 py-2 text-sm text-center">Created At</th>
                                <th class="px-2 py-2 text-sm text-center">Updated At</th>
                                <th class="px-2 py-2 text-sm text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="provider in gameProviders.data" :key="provider.id" class="border border-black-600">
                                <td class="px-2 py-2 text-sm text-center">{{ provider.id }}</td>
                                <td class="px-2 py-2 text-sm text-center">{{ provider.name }}</td>
                                <td class="px-2 py-2 text-sm text-center">
                                    <inertia-link :href="route('game-providers.show', provider.id)" class="text-sm text-black-500">
                                        {{ provider.game_provider_queues_count }}
                                    </inertia-link>
                                </td>
                                <td class="px-2 py-2 text-sm text-center">{{ provider.created_at }}</td>
                                <td class="px-2 py-2 text-sm text-center">{{ provider.updated_at }}</td>
                                <td class="px-2 py-2 text-sm text-center">
                                    <button class="text-sm text-black-500" @click="confirmGameProviderBook(provider)">
                                        Book
                                    </button>
                                    <inertia-link :href="route('game-providers.show', provider.id)" class="ml-4 text-sm text-black-500">
                                        Show
                                    </inertia-link>
                                    <button class="ml-4 text-sm text-red-500" v-if="permissions.canDeleteGameProvider">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <book-game-provider-form 
                        :show="gameProviderBeingRemoved" 
                        :gameProvider="gameProviderBeingRemoved"
                        @close="gameProviderBeingRemoved = null" /> -->

                    <book-game-provider-form 
                        :gameProvider="gameProviders.data[0]" />

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import SearchForm from "@/Pages/GameProviders/SearchForm";
import Pagination from "@/Shared/Pagination";
import BookGameProviderForm from './BookGameProviderForm.vue';

export default {
    components: {
        Pagination,
        AppLayout,
        SearchForm,
        BookGameProviderForm
    },

    props: ['gameProviders', 'permissions'],
    data() {
        return {
            // leaveTeamForm: this.$inertia.form(),
            // removeTeamMemberForm: this.$inertia.form(),
            gameProviderBeingRemoved: null,
        }
    },

    methods: {
        confirmGameProviderBook(gameProvider) {
            this.gameProviderBeingBooked = gameProvider
            console.log('provider');
        }
    },

    mounted() {
        //console.log(this.gameProviders.data[0]);
    }
};
</script>
