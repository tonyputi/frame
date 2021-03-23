<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Providers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex my-4">
                    <search-input @input="filter" placeholder="Search for game provider" />

                    <jet-link-button class="ml-4" v-if="permissions.canCreate" :href="route('game-providers.create')">
                        Create
                    </jet-link-button>
                </div>

                <div v-if="meta.total > 0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <jet-table class="text-sm">
                        <template #header>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-2 py-4 w-16">
                                    <jet-checkbox v-model:checked="selectAll" />
                                </th>
                                <th class="px-2 py-4 text-left">ID</th>
                                <th class="px-2 py-4 text-left">Status</th>
                                <th class="px-2 py-4 text-left">Logo</th>
                                <th class="px-2 py-4 text-left">Name</th>
                                <th class="px-2 py-4 text-left">Bookings</th>
                                <th class="px-2 py-4 text-left">Booked By</th>
                                <th class="px-2 py-4 text-left">Booked Time</th>
                                <th class="px-2 py-4"></th>
                            </tr>
                        </template>

                        <template #body>
                            <tr v-for="resource in data" :key="resource.attributes.id" class="border border-black-600">
                                
                                <td class="px-2 py-4 text-center">
                                    <jet-checkbox :value="resource" v-model:checked="gameProvidersSelected" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.id }}</td>
                                <td class="px-2 py-4 text-left">
                                    <span v-if="resource.attributes?.current_booking?.is_active" class="bg-red-600 inline-block w-3 h-3 mr-2 rounded-full" />
                                    <span v-else class="bg-green-600 inline-block w-3 h-3 mr-2 rounded-full" />
                                </td>
                                <td class="px-2 py-4 text-left">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="resource.attributes.logo_url" :alt="resource.attributes.name" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.name }}</td>
                                <td class="px-2 py-4 text-left">
                                    <inertia-link :href="route('game-providers.bookings.index', [resource.attributes.id])">
                                        <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none text-white bg-gray-800 rounded-full">
                                            {{ resource.attributes.next_bookings_count }}
                                        </span>
                                    </inertia-link>
                                </td>
                                <td class="px-2 py-4 text-left">
                                    {{ resource.attributes.current_booking?.user?.name || '-' }}
                                </td>
                                <td class="px-2 py-4 text-left">
                                    {{ datetimeFormat(resource.attributes.current_booking?.started_at, 'YYYY-MM-DD') }}
                                    {{ datetimeFormat(resource.attributes.current_booking?.started_at, 'HH:mm') }} - 
                                    {{ datetimeFormat(resource.attributes.current_booking?.ended_at, 'HH:mm') }}
                                </td>
                                <td class="px-2 py-4">
                                    <div class="flex">
                                        <button class="text-black-500" @click="gameProviderBeingBooked=resource">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                            </svg>
                                        </button>
                                        <inertia-link class="text-black-500 ml-4" v-if="resource.permissions.canView" :href="route('game-providers.show', resource.attributes.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </inertia-link>
                                        <button class="text-red-500 ml-4" v-if="resource.permissions.canDelete" @click="gameProviderBeingDeleted=resource">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </jet-table>

                    <pagination v-bind="meta" />
                </div>

                <!-- no result alert -->
                <div v-else class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
                    </svg>
                    <p>Ooops! No Game providers to show. Please change search value </p>
                </div>

                <!-- game provider book modal -->
                <book-game-provider-modal
                    v-bind="gameProviderBeingBooked"
                    @close="gameProviderBeingBooked = null" />

                <!-- game provider delete modal -->
                <delete-game-provider-modal
                    v-bind="gameProviderBeingDeleted"
                    @close="gameProviderBeingDeleted = null" />

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import BookGameProviderModal from './BookGameProviderModal';
import DeleteGameProviderModal from './DeleteGameProviderModal';
import GameProviderTableRow from './GameProviderTableRow';
import Timeline from './Timeline';
import JetTable from "@/Jetstream/Table";
import Pagination from "@/Jetstream/Pagination";
import SearchInput from "@/Jetstream/SearchInput";
import JetLinkButton from "@/Jetstream/LinkButton";
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
        SearchInput,
        GameProviderTableRow,
        BookGameProviderModal,
        DeleteGameProviderModal,
        Timeline
    },

    props: ['data', 'meta', 'permissions'],

    data() {
        return {
            gameProviderBeingBooked: null,
            gameProviderBeingDeleted: null,
            gameProvidersSelected: []
        }
    },

    computed: {
        selectAll: {
            get() {
                return this.data ? this.gameProvidersSelected.length == this.data.length : false;
            },
            set(value) {
                (value) ? this.gameProvidersSelected = this.data : this.gameProvidersSelected = [];
            }
        }
    },

    methods: {
        // TODO: this can be mixed
        filter(ev) {
            this.$inertia.reload({data: { search: ev.target.value, page: 1 }})
        },
        datetimeFormat(datetime, format = null) {
            if(datetime) {
                return moment(datetime).format(format)
            }
        }
    }
};
</script>
