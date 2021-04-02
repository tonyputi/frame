<template>
    <jet-confirmation-modal :show="attributes" @close="closeModal">
        <template #title>
            Delete Booking {{ attributes?.id }}
        </template>

        <template #content>
            Are you sure you want to delete {{ attributes?.id }}? Once booking is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteBooking" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Delete
            </jet-danger-button>
        </template>
    </jet-confirmation-modal>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetConfirmationModal,
        JetSecondaryButton,
        JetDangerButton
    },

    props: ['attributes', 'permissions'],
    emits: ['close'],

    data() {
        return {
            confirmingResourceDeletion: false,
            form: this.$inertia.form({})
        }
    },

    methods: {
        confirmBookingDeletion() {
            this.confirmingResourceDeletion = true;
        },

        deleteBooking() {
            this.form.delete(route('bookings.destroy', [this.attributes.id]), {
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
