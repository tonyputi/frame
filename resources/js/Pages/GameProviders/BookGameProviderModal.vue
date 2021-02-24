<template>
    <!-- Boook Game Provider Modal -->
    <jet-dialog-modal :show="gameProvider" @close="closeModal">
        <template #title>
            Book {{ gameProvider?.name }}
        </template>

        <template #content>
            <!-- Are you sure you want to delete {{ name }}? Once game provider is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. -->

            <form>
                <!-- Start at -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="started_at" value="Start at" />
                    <jet-input id="started_at" type="text" class="mt-1 block w-full" v-model="form.started_at" autocomplete="started_at" />
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <!-- End at -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="ended_at" value="End at" />
                    <jet-input id="ended_at" type="text" class="mt-1 block w-full" v-model="form.ended_at" autocomplete="ended_at" />
                    <jet-input-error :message="form.errors.ended_at" class="mt-2" />
                </div>

                <!-- Notes -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="notes" value="Notes" />
                    <jet-textarea id="notes" class="mt-1 block w-full" v-model="form.notes" />
                    <jet-input-error :message="form.errors.notes" class="mt-2" />
                </div>
            </form>
        </template>

        <template #footer>
            <jet-secondary-button @click.native="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-button class="ml-2" @click.native="bookGameProvider" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Book Now
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetTextarea from '@/Jetstream/Textarea'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetButton from '@/Jetstream/Button'
    import moment from 'moment';

    export default {
        components: {
            JetActionSection,
            JetDialogModal,
            JetInput,
            JetTextarea,
            JetLabel,
            JetInputError,
            JetSecondaryButton,
            JetButton,
        },

        props: ['gameProvider'],
        emits: ['close'],

        data() {
            return {
                form: this.$inertia.form({
                    application_id: 1,
                    environment_id: 1,
                    game_provider_id: 1,
                    started_at: moment(),
                    ended_at: moment().add(1, 'hours'),
                    notes: null
                })
            }
        },

        methods: {
            bookGameProvider() {
                this.form.post(route('game-provider-queues.store'), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.started_at.focus(),
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
