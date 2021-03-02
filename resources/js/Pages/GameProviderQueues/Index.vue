<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Provider Queue
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex my-4">
                    <search-input 
                        @input="filter"
                        placeholder="Search for game provider" />

                    <jet-link-button :href="route('game-providers.create')">
                        Create
                    </jet-link-button>
                </div>

                <div v-if="gameProviderQueues.meta.total > 0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <jet-table class="text-sm">
                        <template #header>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-2 py-4 w-16">
                                    <jet-checkbox v-model:checked="resourcesSelected" />
                                </th>
                                <th class="px-2 py-4 text-left">ID</th>
                                <th class="px-2 py-4 text-left">User</th>
                                <th class="px-2 py-4 text-left">Game Provider</th>
                                <th class="px-2 py-4 text-left">Envirnoment</th>
                                <th class="px-2 py-4 text-left">Application</th>
                                <th class="px-2 py-4 text-left">Is Active</th>
                                <th class="px-2 py-4 text-left">Started At</th>
                                <th class="px-2 py-4 text-left">Ended At</th>
                                <th class="px-2 py-4"></th>
                            </tr>
                        </template>

                        <template #body>
                            <tr v-for="resource in gameProviderQueues.data" :key="resource.id" class="border border-black-600">
                                <td class="px-2 py-4 text-center">
                                    <jet-checkbox :value="resource" v-model:checked="resourcesSelected" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.id }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.user.name }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.game_provider.name }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.environment.name }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.application.name }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.is_active }}</td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.started_at) }}</td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.ended_at) }}</td>
                                <td class="px-2 py-4 text-center">
                                    <div class="flex">
                                        <inertia-link class="text-black-500 ml-4" :href="route('game-provider-queues.show', resource.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </inertia-link>
                                        <button class="text-red-500 ml-4 " v-if="permissions.canDeleteGameProviderQueue" @click="gameProviderQueueBeingDeleted=resource">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </jet-table>

                    <pagination v-bind="gameProviderQueues.meta" />
                </div>

                <!-- no result alert -->
                <div v-else class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
                    </svg>
                    <p>Ooops! No Game providers bookings to show. Please change search value </p>
                </div>

                <!-- game provider delete modal -->
                <!-- <delete-game-provider-queue-modal v-if="resourceBeingDeleted"
                    :gameProviderQueue="resourceBeingDeleted"
                    @close="resourceBeingDeleted = null" /> -->

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetTable from "@/Components/Table";
import Pagination from "@/Components/Pagination";
import JetLinkButton from "@/Components/LinkButton";
import SearchInput from "@/Components/SearchInput";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import moment from 'moment';

export default {
    components: {
        AppLayout,
        JetLinkButton,
        JetInput,
        JetCheckbox,
        JetTable,
        Pagination,
        SearchInput
    },

    props: ['gameProviderQueues', 'permissions'],

    data() {
        return {
            searchPid: null,
            resourceBeingDeleted: null,
            resourcesSelected: []
        }
    },

    methods: {
        filter(ev) {
            this.$inertia.reload({data: { search: ev.target.value }})
        },
        formatDate(datetime) {
            return (datetime) ? moment(datetime).format('YYYY-MM-DD HH:mm:ss') : null;
        }
    }
};
</script>
