<template>
    <jet-confirmation-modal :show="attributes" @close="closeModal">
        <template #title>
            Release Booking {{ attributes?.id }}
        </template>

        <template #content>
            Are you sure you want to release {{ attributes?.id }}?.
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="releaseBooking" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Release
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
            confirmingBookingDeletion: false,
            form: this.$inertia.form({
                ended_at: moment()
            })
        }
    },

    methods: {
        releaseBooking() {
            this.form.put(route('bookings.release', [this.attributes.id]), {
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
