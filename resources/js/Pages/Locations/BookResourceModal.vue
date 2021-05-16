<template>
    <!-- Boook Location Modal -->
    <jet-dialog-modal :show="attributes" @close="closeModal">
        <template #title>
            Book {{ attributes?.name }}
        </template>

        <template #content>
            <form>
                <!-- Start date -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="date" value="Date" />
                    <input id="date" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="date" ref="date" />
                    <!--<jet-input id="date" type="date" class="mt-1 block w-full" v-model="date" ref="date" :min="minDate" :max="maxDate" />-->
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <!-- Start time -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="start_at" value="Started at" />
                    <input id="start_at" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="start_at" ref="start_at" />
                    <!--<jet-input id="start_at" type="time" class="mt-1 block w-full" v-model="start_at" :step="step" />-->
                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                </div>

                <!-- End time -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="end_at" value="Ended at" />
                    <input id="end_at" type="time" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="end_at" ref="end_at" />
                    <!--<jet-input id="end_at" type="time" class="mt-1 block w-full" v-model="end_at" :step="step" />-->
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

            <jet-button class="ml-2" @click="bookLocation" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
import flatpickr from 'flatpickr'
import 'flatpickr/dist/themes/dark.css'

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

    props: ['attributes', 'permissions'],
    emits: ['close'],

    data() {
        return {
            flatpickr: null,
            step: 5 * 60,
            form: this.$inertia.form({
                started_at: this.nextFifthMinute(),
                ended_at: this.nextFifthMinute().add(15, 'minutes'),
                notes: null
            })
        }
    },

    mounted() {
        this.$nextTick(() => {
            this.createDatePicker()
            this.createStartTimePicker()
            this.createEndTimePicker()
        })
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
        createDatePicker() {
            this.flatpickr = flatpickr(this.$refs.date, {
                enableTime: false,
                monthSelectorType: 'static',
                dateFormat: 'Y-m-d',
                minDate: moment().format('YYYY-MM-DD'),
                maxDate: moment().add(14, 'days').format('YYYY-MM-DD')
            });
        },

        createStartTimePicker() {
            this.flatpickr = flatpickr(this.$refs.start_at, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                // minTime: '16:00',
                // maxTime: '22:30',
            });
        },

        createEndTimePicker() {
            this.flatpickr = flatpickr(this.$refs.end_at, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                // minTime: '16:00',
                // maxTime: '22:30',
            });
        },

        bookLocation() {
            // need to remove one second to match ie 14:04:59
            this.form.ended_at = moment(this.form.ended_at).subtract(1, 'second')

            this.form.post(route('locations.bookings.store', [this.attributes.id]), {
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
