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
                <jet-danger-button @click="resourceBeingDeleted = data">
                    Delete Booking
                </jet-danger-button>
            </div>

            <!-- Delete Booking Confirmation Modal -->
            <delete-resource-modal
                v-bind="resourceBeingDeleted"
                @close="resourceBeingDeleted = null" />
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
import DeleteResourceModal from './DeleteResourceModal';

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        DeleteResourceModal
    },

    props: ['data'],

    data() {
        return {
            resourceBeingDeleted: null,
        }
    },
}
</script>
