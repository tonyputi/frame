<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <update-booking-form v-bind="data" />

                    <jet-section-border v-if="permissions.canDelete" />
                </div>

                <div v-if="permissions.canDelete">
                    <delete-booking-form :data="data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeleteBookingForm from './DeleteBookingForm'
import UpdateBookingForm from './UpdateBookingForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import InteractWithResource from "@/mixins/InteractWithResource"

export default {
    mixins: [InteractWithResource],
    components: {
        AppLayout,
        JetSectionBorder,
        UpdateBookingForm,
        DeleteBookingForm
    },

    computed: {
        title() {
            return this.attributes.id ? `Booking: ${this.attributes.id}` : `Create new booking`
        }
    }
}
</script>
