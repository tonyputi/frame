<template>
    <!-- Boook Game Provider Modal -->
    <jet-dialog-modal  v-if="!!gameProvider" :show="gameProvider" @close="closeModal">
        <template #title>
            Book {{ gameProvider.name }}
        </template>

        <template #content>
            <!-- Are you sure you want to delete {{ name }}? Once game provider is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. -->

            <form>
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="date" value="Date" />
                    <jet-input id="date" type="date" class="mt-1 block w-full" v-model="date" step="300" />
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="start_at" value="Start at" />
                    <jet-input id="start_at" type="time" class="mt-1 block w-full" v-model="start_at" step="300" />
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="end_at" value="Ended at" />
                    <jet-input id="end_at" type="time" class="mt-1 block w-full" v-model="end_at" step="300" />
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
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-button class="ml-2" @click="bookGameProvider" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
                date: moment().format('YYYY-MM-DD'),
                start_at: this.nextFifthMinute().format('HH:mm'),
                end_at: this.nextFifthMinute().add(15, 'minutes').format('HH:mm'),

                form: this.$inertia.form({
                    application_id: 1,
                    environment_id: 1,
                    started_at: null,
                    ended_at: null,
                    notes: null
                })
            }
        },

        computed: {
            started_at() {
                return moment(`${this.date} ${this.start_at}`, 'YYYY-MM-DD HH:mm')
            },

            ended_at() {
                return moment(`${this.date} ${this.end_at}`, 'YYYY-MM-DD HH:mm').subtract(1, 'second')
            }
        },

        methods: {
            bookGameProvider() {
                this.form.started_at = this.started_at.toISOString()
                this.form.ended_at = this.ended_at.toISOString()

                this.form.post(route('game-providers.bookings.store', [this.gameProvider.id]), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.started_at.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            nextFifthMinute() {
                let now = moment()
                let minute = 5 - (now.minute() % 5)
                now.add(minute, 'minutes')
                return now
            },

            closeModal() {
                this.$emit('close')

                this.form.reset()
            },
        },
    }
</script>
