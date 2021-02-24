<template>
    <jet-action-section>
        <template #title>
            Delete Game Provider
        </template>

        <template #description>
            Permanently delete game provider.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once game provider is deleted, all of its resources and data will be permanently deleted. Before deleting game provider, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="gameProviderBeingDeleted=gameProvider">
                    Delete Game Provider
                </jet-danger-button>
            </div>

            <!-- Delete Game Provider Confirmation Modal -->
            <delete-game-provider-modal
                :gameProvider="gameProviderBeingDeleted"
                @close="gameProviderBeingDeleted = null" />
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
import DeleteGameProviderModal from './DeleteGameProviderModal';

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        DeleteGameProviderModal
    },

    props: ['gameProvider'],

    data() {
        return {
            gameProviderBeingDeleted: null,
        }
    },
}
</script>
