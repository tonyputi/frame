<template>
    <tr class="border border-black-600">
        <td class="px-2 py-4 text-center">
            <jet-checkbox :value="resource" v-model:checked="selected" />
        </td>
        <td class="px-2 py-4 text-left">{{ attributes.id }}</td>
        <td class="px-2 py-4 text-left">
            <span v-if="isCurrentBooked" class="bg-red-600 inline-block w-3 h-3 mr-2 rounded-full" />
            <span v-else class="bg-green-600 inline-block w-3 h-3 mr-2 rounded-full" />
        </td>
        <td class="px-2 py-4 text-left">
            <img class="h-8 w-8 rounded-full object-cover" :src="attributes.logo_url" :alt="attributes.name" />
        </td>
        <td class="px-2 py-4 text-left">{{ attributes.name }}</td>
        <td class="px-2 py-4 text-left">
            <inertia-link :href="route('locations.bookings.index', [attributes.id])">
                <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none text-white bg-gray-800 rounded-full">
                    {{ attributes.next_bookings_count }}
                </span>
            </inertia-link>
        </td>
        <td class="px-2 py-4 text-left">{{ currentBookedUser }}</td>
        <td class="px-2 py-4 text-left">{{ currentBookedTimeSlot }}</td>
        <td class="px-2 py-4 text-center">
            <div class="flex">
                <button class="text-black-500" @click="$emit('book', resource)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                </button>
                <inertia-link class="text-black-500 ml-4" v-if="permissions.canView" :href="route('locations.show', attributes.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                </inertia-link>
                <button class="text-red-500 ml-4 " v-if="permissions.canDelete" @click="$emit('delete', resource)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
import JetCheckbox from "@/Jetstream/Checkbox";

export default {
    components: {
        JetCheckbox,
    },

    props: ['resource', 'selected'],
    emits: ['delete', 'book'],

    computed: {
        attributes() {
            return this.resource.attributes;
        },
        permissions() {
            return this.resource.permissions;
        },
        currentBooking() {
            return this.attributes.current_booking || {}
        },
        isCurrentBooked() {
            return this.currentBooking.is_active;
        },
        currentBookedUser() {
            return this.currentBooking.user?.name
        },
        currentBookedTimeSlot() {
            if(this.currentBooking?.started_at && this.currentBooking?.ended_at) {
                let time = [
                    moment(this.currentBooking?.started_at).format('HH:mm:ss'),
                    moment(this.currentBooking?.ended_at).format('HH:mm:ss')
                ]

                return `${time[0]} - ${time[1]}`
            }
        }
    }
};
</script>
