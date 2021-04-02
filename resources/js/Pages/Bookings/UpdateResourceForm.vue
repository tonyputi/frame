<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Booking Information
        </template>

        <template #description>
            Update the booking information.
        </template>

        <template #form>
            <!-- Start date -->
            <div class="col-span-6 sm:col-span-4">
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
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="notes" value="Notes" />
                <jet-textarea id="notes" class="mt-1 block w-full" 
                    v-model="form.notes" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.notes" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="canUpdateOrCreate">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetTextarea from '@/Jetstream/Textarea'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetTextarea,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: {
        attributes: {
            type: Object,
            default: {}
        },
        permissions: {
            type: Object,
            default: {}
        }
    },

    data() {
        return {
            step: 5 * 60,
            form: this.$inertia.form({
                started_at: this.nextFifthMinute(),
                ended_at: this.nextFifthMinute().add(15, 'minutes'),
                notes: null
            })
        }
    },

    computed: {
        // TODO: this can be mixed
        canUpdateOrCreate() {
            return this.permissions.canUpdate || !this.attributes.id
        },
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
        updateOrCreate() {
            if(this.attributes.id) {
                this.form.put(route('bookings.update', [this.attributes.id]), {
                    errorBag: 'updateBooking',
                    preserveScroll: true,
                    onError: () => this.$refs.date.focus(),
                });
            } else {
                this.form.post(route('locations.bookings.store', [route().params.location]), {
                    errorBag: 'createBooking',
                    preserveScroll: true,
                    onError: () => this.$refs.date.focus(),
                });
            }
        },
        nextFifthMinute() {
            let now = moment()
            let minute = 5 - (now.minute() % 5)
            now.add(minute, 'minutes')
            now.set('seconds', 0)

            return now
        },
    },
}
</script>
