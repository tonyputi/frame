<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking: {{ booking.data?.id }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <update-booking-form :booking="booking.data" :permissions="permissions" />

                    <jet-section-border v-if="permissions.canDeleteBooking" />
                </div>

                <div v-if="permissions.canDeleteBooking">
                    <delete-booking-form :booking="booking.data" class="mt-10 sm:mt-0" />
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

    export default {
        props: ['booking', 'permissions'],

        components: {
            AppLayout,
            JetSectionBorder,
            UpdateBookingForm,
            DeleteBookingForm
        }
    }
</script>
