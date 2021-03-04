<template>
    <jet-action-section>
        <template #title>
            Delete Booking
        </template>

        <template #description>
            Permanently delete booking.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once bookig is deleted, all of its resources and data will be permanently deleted.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="bookingBeingDeleted=booking">
                    Delete Booking
                </jet-danger-button>
            </div>

            <!-- Delete Game Provider Confirmation Modal -->
            <delete-booking-modal
                :booking="bookingBeingDeleted"
                @close="bookingBeingDeleted = null" />
        </template>
    </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import DeleteBookingModal from './DeleteBookingModal';

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        DeleteBookingModal
    },

    props: ['booking'],

    data() {
        return {
            bookingBeingDeleted: null,
        }
    },
}
</script>
