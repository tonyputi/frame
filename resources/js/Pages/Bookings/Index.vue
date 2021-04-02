<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Provider Bookings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex my-4">
                    <search-input @input="filter" placeholder="Search for game provider or user" />

                    <jet-link-button class="ml-4" :href="route('game-providers.bookings.create', [gameProviderId])">
                        Create
                    </jet-link-button>
                </div>

                <div v-if="meta.total > 0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <jet-table class="text-sm">
                        <template #header>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-2 py-4 w-16">
                                    <jet-checkbox v-model:checked="bookingsSelected" />
                                </th>
                                <th class="px-2 py-4 text-left">ID</th>
                                <th class="px-2 py-4 text-left">User</th>
                                <th class="px-2 py-4 text-left">Game Provider</th>
                                <th class="px-2 py-4 text-left">Status</th>
                                <th class="px-2 py-4 text-left">Started At</th>
                                <th class="px-2 py-4 text-left">Ended At</th>
                                <th class="px-2 py-4"></th>
                            </tr>
                        </template>

                        <template #body>
                            <tr v-for="resource in data" :key="resource.attributes.id" class="border border-black-600">
                                <td class="px-2 py-4 text-center">
                                    <jet-checkbox :value="resource" v-model:checked="bookingsSelected" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.id }}</td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.user.name }}</td>
                                <td class="px-2 py-4 text-left">
                                    <inertia-link class="text-black-500" :href="route('game-providers.show', resource.attributes.game_provider.id)">
                                        {{ resource.attributes.game_provider.name }}
                                    </inertia-link>
                                </td>
                                <td class="px-2 py-4 text-left">
                                    <jet-boolean :value="resource.attributes.is_active" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.attributes.started_at) }}</td>
                                <td class="px-2 py-4 text-left">{{ formatDate(resource.attributes.ended_at) }}</td>
                                <td class="px-2 py-4">
                                    <div class="inline-flex items-center">
                                        <button v-if="resource.permissions.canUpdate" 
                                            @click="bookingBeingReleased=resource"
                                            class="inline-flex appearance-none cursor-pointer hover:text-primary mr-3">
                                            <XCircleIcon class="h-6 w-6" />
                                        </button>
                                        <inertia-link v-if="resource.permissions.canView" 
                                            :href="route('bookings.show', resource.attributes.id)"
                                            class="inline-flex cursor-pointer text-70 hover:text-primary mr-3">
                                            <EyeIcon class="h-6 w-6" />
                                        </inertia-link >
                                        <button v-if="resource.permissions.canDelete" 
                                            @click="bookingBeingDeleted=resource" 
                                            class="inline-flex appearance-none cursor-pointer hover:text-primary mr-3">
                                            <TrashIcon class="h-6 w-6" />
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
                    <p>Ooops! No Game providers bookings to show. Please change search value </p>
                </div>

                <!-- booking delete modal -->
                <release-booking-modal
                    v-bind="bookingBeingReleased"
                    @close="bookingBeingReleased = null" />

                <!-- booking delete modal -->
                <delete-booking-modal
                    v-bind="bookingBeingDeleted"
                    @close="bookingBeingDeleted = null" />

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetTable from "@/Jetstream/Table";
import Pagination from "@/Jetstream/Pagination";
import JetLinkButton from "@/Jetstream/LinkButton";
import SearchInput from "@/Jetstream/SearchInput";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetBoolean from "@/Jetstream/Boolean";
import DeleteBookingModal from './DeleteBookingModal';
import ReleaseBookingModal from './ReleaseBookingModal';

import { XCircleIcon, EyeIcon, TrashIcon } from '@heroicons/vue/outline'

export default {
    components: {
        AppLayout,
        JetLinkButton,
        JetInput,
        JetCheckbox,
        JetTable,
        JetBoolean,
        Pagination,
        SearchInput,
        DeleteBookingModal,
        ReleaseBookingModal,
        XCircleIcon,
        EyeIcon,
        TrashIcon
    },

    props: ['data', 'meta', 'permissions'],

    data() {
        return {
            bookingBeingDeleted: null,
            bookingBeingReleased: null,
            bookingsSelected: []
        }
    },

    computed: {
        gameProviderId() {
            return route().params['game_provider']
        }
    },

    methods: {
        // TODO: this can be mixed in HasTable.js
        filter(ev) {
            this.$inertia.reload({data: { search: ev.target.value, page: 1 }})
        },
        datetimeFormat(datetime, format = null) {
            if(datetime) {
                return moment(datetime).format(format)
            }
        },
        formatDate(datetime) {
            return (datetime) ? moment(datetime).format('YYYY-MM-DD HH:mm:ss') : null;
        }
    }
};
</script>
