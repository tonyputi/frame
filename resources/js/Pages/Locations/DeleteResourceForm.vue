<template>
    <jet-action-section>
        <template #title>
            Delete Location
        </template>

        <template #description>
            Permanently delete location.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once location is deleted, all of its resources and data will be permanently deleted. Before deleting location, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="resourceBeingDeleted=data">
                    Delete Location
                </jet-danger-button>
            </div>

            <!-- Delete resource confirmation modal -->
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
