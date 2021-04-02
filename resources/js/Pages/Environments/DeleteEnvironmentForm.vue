<template>
    <jet-action-section>
        <template #title>
            Delete Environment
        </template>

        <template #description>
            Permanently delete environment.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once environment is deleted, all of its resources and data will be permanently deleted. Before deleting environment, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="environmentBeingDeleted=data">
                    Delete Environment
                </jet-danger-button>
            </div>

            <!-- Delete Environment Confirmation Modal -->
            <delete-environment-modal
                v-bind="environmentBeingDeleted"
                @close="environmentBeingDeleted = null" />
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
import DeleteEnvironmentModal from './DeleteEnvironmentModal';

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        DeleteEnvironmentModal
    },

    props: ['data'],

    data() {
        return {
            environmentBeingDeleted: null,
        }
    },
}
</script>
