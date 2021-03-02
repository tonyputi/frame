<template>
    <jet-dialog-modal v-if="booking" :show="booking" @close="closeModal">
        <template #title>
            Delete Booking {{ booking.id }}
        </template>

        <template #content>
            Are you sure you want to delete {{ booking.id }}? Once booking is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteBooking" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Delete
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetSecondaryButton,
    },

    props: ['booking'],
    emits: ['close'],

    data() {
        return {
            confirmingBookingDeletion: false,
            form: this.$inertia.form({})
        }
    },

    methods: {
        confirmBookingDeletion() {
            this.confirmingBookingDeletion = true;
        },

        deleteBooking() {
            this.form.delete(route('bookings.destroy', [this.booking.id]), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                // onError: () => this.$refs.name.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.$emit('close')

            this.form.reset()
        },
    },
}
</script>
