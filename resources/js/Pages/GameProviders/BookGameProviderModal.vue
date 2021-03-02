<template>
    <!-- Boook Game Provider Modal -->
    <jet-dialog-modal  v-if="!!gameProvider" :show="gameProvider" @close="closeModal">
        <template #title>
            Book {{ gameProvider.name }}
        </template>

        <template #content>
            <form>
                <!-- Start date -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="date" value="Date" />
                    <jet-input id="date" type="date" class="mt-1 block w-full" v-model="date" ref="date" :min="minDate" :max="maxDate" />
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <!-- Start time -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="start_at" value="Started at" />
                    <jet-input id="start_at" type="time" class="mt-1 block w-full" v-model="start_at" :step="step" />
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <!-- End time -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="end_at" value="Ended at" />
                    <jet-input id="end_at" type="time" class="mt-1 block w-full" v-model="end_at" :step="step" />
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
                step: 5 * 60,
                form: this.$inertia.form({
                    application_id: 1,
                    environment_id: 1,
                    started_at: this.nextFifthMinute(),
                    ended_at: this.nextFifthMinute().add(15, 'minutes'),
                    notes: null
                })
            }
        },

        computed: {
            minDate(){
                return moment().format('YYYY-MM-DD')
            },
            maxDate(){
                return moment().add(6, 'months').format('YYYY-MM-DD')
            },
            date: {
                get() {
                    return moment(this.form.started_at).format('YYYY-MM-DD')
                },
                set(value) {
                    this.form.started_at = moment(`${value} ${this.start_at}`)
                    this.form.ended_at = moment(`${value} ${this.end_at}`)
                }
            },
            start_at: {
                get() {
                    return moment(this.form.started_at).format('HH:mm')
                },
                set(value) {
                    this.form.started_at = moment(`${this.date} ${value}`)
                }
            },
            end_at: {
                get() {
                    return moment(this.form.ended_at).format('HH:mm')
                },
                set(value) {
                    this.form.ended_at = moment(`${this.date} ${value}`)
                }
            }
        },

        methods: {
            bookGameProvider() {
                // need to remove one second to match ie 14:04:59
                this.form.ended_at = moment(this.form.ended_at).subtract(1, 'second')

                this.form.post(route('game-providers.bookings.store', [this.gameProvider.id]), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.date.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            nextFifthMinute() {
                let now = moment()
                let minute = 5 - (now.minute() % 5)
                now.add(minute, 'minutes')
                now.set('seconds', 0)

                return now
            },

            closeModal() {
                this.$emit('close')

                this.form.reset()
            },
        },
    }
</script>
