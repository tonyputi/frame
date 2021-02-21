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
                <jet-danger-button @click.native="confirmGameProviderDeletion">
                    Delete Game Provider
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingGameProviderDeletion" @close="closeModal">
                <template #title>
                    Delete {{ gameProvider.name }}
                </template>

                <template #content>
                    Are you sure you want to delete {{ gameProvider.name }}? Once game provider is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter.native="deleteGameProvider" />

                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteGameProvider" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Game Provider
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
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

    export default {
        components: {
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        props: ['gameProvider'],

        data() {
            return {
                confirmingGameProviderDeletion: false,

                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            confirmGameProviderDeletion() {
                this.confirmingGameProviderDeletion = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },

            deleteGameProvider() {
                this.form.delete(route('game-providers.destroy', [this.gameProvider.id]), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            closeModal() {
                this.confirmingGameProviderDeletion = false

                this.form.reset()
            },
        },
    }
</script>
