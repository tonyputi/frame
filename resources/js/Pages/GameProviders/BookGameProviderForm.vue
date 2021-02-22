<template>
    <!-- Boook Game Provider Modal -->
    <jet-dialog-modal :show="confirmingGameProviderBooking" @close="closeModal">
        <template #title>
            Book {{ gameProvider.name }}
        </template>

        <template #content>
            <!-- Are you sure you want to delete {{ gameProvider.name }}? Once game provider is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. -->

            <div class="mt-4">
                <!-- <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                            ref="password"
                            v-model="form.password"
                            @keyup.enter.native="bookGameProvider" />

                <jet-input-error :message="form.errors.password" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click.native="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click.native="bookGameProvider" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Book Game Provider
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
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

        // props: ['gameProvider'],
        
        props: {
            gameProvider: {
                type: Object,
                default: {
                    name: ''
                }
            }
        },

        data() {
            return {
                confirmingGameProviderBooking: true,

                form: this.$inertia.form({
                    started_at: '',
                    ended_at: ''
                })
            }
        },

        mounted() {
            console.log(this.gameProvider);
        },

        methods: {
            confirmGameProviderBooking() {
                this.confirmingGameProviderBooking = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },

            bookGameProvider() {
                // this.form.delete(route('game-providers.destroy', [this.gameProvider.id]), {
                //     preserveScroll: true,
                //     onSuccess: () => this.closeModal(),
                //     onError: () => this.$refs.password.focus(),
                //     onFinish: () => this.form.reset(),
                // })
            },

            closeModal() {
                this.confirmingGameProviderBooking = false

                this.form.reset()
            },
        },
    }
</script>
