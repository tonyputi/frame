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

                    <jet-link-button :href="route('game-providers.create')">
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
                            <template v-for="resource in data" :key="resource.attributes.id">
                                <game-provider-table-row :resource="resource"
                                    :selected="gameProvidersSelected"
                                    @book="gameProviderBeingBooked = $event"
                                    @delete="gameProviderBeingDeleted = $event" />
                            </template>
                        </template>

                        <!-- <template #body>
                            <tr v-for="resource in data" :key="resource.attributes.id" class="border border-black-600">
                                
                                <td class="px-2 py-4 text-center">
                                    <jet-checkbox :value="resource" v-model:checked="gameProvidersSelected" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.id }}</td>
                                <td class="px-2 py-4 text-left">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="resource.attributes.logo_url" :alt="resource.attributes.name" />
                                </td>
                                <td class="px-2 py-4 text-left">
                                    <svg v-if="resource.attributes.current_booking?.is_active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path fill-rule="evenodd" d="M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM7.879 6.464a1 1 0 010 1.414 3 3 0 000 4.243 1 1 0 11-1.415 1.414 5 5 0 010-7.07 1 1 0 011.415 0zm4.242 0a1 1 0 011.415 0 5 5 0 010 7.072 1 1 0 01-1.415-1.415 3 3 0 000-4.242 1 1 0 010-1.415zM10 9a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path d="M3.707 2.293a1 1 0 00-1.414 1.414l6.921 6.922c.05.062.105.118.168.167l6.91 6.911a1 1 0 001.415-1.414l-.675-.675a9.001 9.001 0 00-.668-11.982A1 1 0 1014.95 5.05a7.002 7.002 0 01.657 9.143l-1.435-1.435a5.002 5.002 0 00-.636-6.294A1 1 0 0012.12 7.88c.924.923 1.12 2.3.587 3.415l-1.992-1.992a.922.922 0 00-.018-.018l-6.99-6.991zM3.238 8.187a1 1 0 00-1.933-.516c-.8 3-.025 6.336 2.331 8.693a1 1 0 001.414-1.415 6.997 6.997 0 01-1.812-6.762zM7.4 11.5a1 1 0 10-1.73 1c.214.371.48.72.795 1.035a1 1 0 001.414-1.414c-.191-.191-.35-.4-.478-.622z" />
                                    </svg>
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.name }}</td>
                                <td class="px-2 py-4 text-left">
                                    <inertia-link :href="route('game-providers.bookings.index', [resource.attributes.id])">
                                        {{ resource.attributes.next_bookings_count }}
                                    </inertia-link>
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.current_booking?.user?.name }}</td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.attributes.current_booking?.started_at) }}</td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.attributes.current_booking?.ended_at) }}</td>
                                <td class="px-2 py-4 text-center">
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
                                        <button class="text-red-500 ml-4 " v-if="resource.permissions.canDelete" @click="gameProviderBeingDeleted=resource">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template> -->
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
        formatDate(datetime) {
            return (datetime) ? moment(datetime).format('YYYY-MM-DD HH:mm:ss') : null;
        }
    }
};
</script>
