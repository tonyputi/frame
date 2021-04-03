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

                    <jet-link-button class="ml-4" v-if="canCreate" :href="route('environments.game-providers.create', [route().params.environment])">
                        Create
                    </jet-link-button>
                </div>

                <div v-if="meta.total > 0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <!-- <jet-resource-table :data="data" class="mb-2 text-sm" /> -->

                    <jet-table class="text-sm">
                        <template #header>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-2 py-4 w-16">
                                    <jet-checkbox v-model:checked="selectAll" />
                                </th>
                                <th class="px-2 py-4 text-left">ID</th>
                                <th class="px-2 py-4 text-center">Status</th>
                                <th class="px-2 py-4 text-left">Logo</th>
                                <th class="px-2 py-4 text-left">Name</th>
                                <th class="px-2 py-4 text-center">Bookings</th>
                                <th class="px-2 py-4 text-left">Booked By</th>
                                <th class="px-2 py-4 text-left">Booked Time</th>
                                <th class="px-2 py-4"></th>
                            </tr>
                        </template>

                        <template #body>
                            <tr v-for="resource in data" :key="resource.attributes.id" class="border border-black-600"> 
                                <td class="px-2 py-4 text-center">
                                    <jet-checkbox :value="resource" v-model:checked="collectionSelected" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.id }}</td>
                                <td class="px-2 py-4 text-center">
                                    <jet-boolean :value="resource.attributes?.current_booking?.is_active" />
                                </td>
                                <td class="px-2 py-4 text-left">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="resource.attributes.logo_url" :alt="resource.attributes.name" />
                                </td>
                                <td class="px-2 py-4 text-left">{{ resource.attributes.name }}</td>
                                <td class="px-2 py-4 text-center">
                                    <inertia-link :href="route('locations.bookings.index', [resource.attributes.id])">
                                        <jet-badge>{{ resource.attributes.next_bookings_count }}</jet-badge>
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
                                    <div class="inline-flex items-center">
                                        <button @click="resourceBeingBooked=resource" 
                                            class="inline-flex appearance-none cursor-pointer hover:text-primary mr-3">
                                            <ClockIcon class="h-6 w-6" />
                                        </button>
                                        <inertia-link v-if="resource.permissions.canView" 
                                            :href="route('game-providers.show', resource.attributes.id)"
                                            class="inline-flex cursor-pointer text-70 hover:text-primary mr-3">
                                            <EyeIcon class="h-6 w-6" />
                                        </inertia-link >
                                        <button v-if="resource.permissions.canDelete" 
                                            @click="resourceBeingDeleted=resource" 
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
                    <p>Ooops! No Game providers to show. Please change search value </p>
                </div>

                <!-- resource book modal -->
                <book-resource-modal
                    v-bind="resourceBeingBooked"
                    @close="resourceBeingBooked = null" />

                <!-- resource delete modal -->
                <delete-resource-modal
                    v-bind="resourceBeingDeleted"
                    @close="resourceBeingDeleted = null" />

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import BookResourceModal from './BookResourceModal';
import DeleteResourceModal from './DeleteResourceModal';
import JetTable from "@/Jetstream/Table";
import JetResourceTable from "@/Jetstream/ResourceTable";
import Pagination from "@/Jetstream/Pagination";
import SearchInput from "@/Jetstream/SearchInput";
import JetLinkButton from "@/Jetstream/LinkButton";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetBadge from "@/Jetstream/Badge";
import JetBoolean from "@/Jetstream/Boolean";

import { ClockIcon, EyeIcon, TrashIcon } from '@heroicons/vue/outline'
import InteractWithCollection from "@/mixins/InteractWithCollection"
import InteractWithDateTime from "@/mixins/InteractWithDateTime"

export default {
    mixins: [InteractWithCollection, InteractWithDateTime],
    components: {
        AppLayout,
        JetLinkButton,
        JetInput,
        JetCheckbox,
        JetBadge,
        JetBoolean,
        JetTable,
        JetResourceTable,
        Pagination,
        SearchInput,
        BookResourceModal,
        DeleteResourceModal,
        ClockIcon,
        EyeIcon,
        TrashIcon
    },

    data() {
        return {
            resourceBeingBooked: null,
            resourceBeingDeleted: null,
            collectionSelected: []
        }
    },

    computed: {
        selectAll: {
            get() {
                return this.data ? this.collectionSelected.length == this.data.length : false;
            },
            set(value) {
                (value) ? this.collectionSelected = this.data : this.collectionSelected = [];
            }
        },
        canCreate() {
            this.permissions.canCreate && !!route().params.environment;
        }
    }
};
</script>
