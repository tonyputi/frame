<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Booking Information
        </template>

        <template #description>
            Update the booking information.
        </template>

        <template #form>
            <!-- Started at -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="started_at" value="Started at" />
                <jet-input id="started_at" type="text" class="mt-1 block w-full" 
                    v-model="form.started_at" :disabled="!permissions.canUpdateBooking" />
                <jet-input-error :message="form.errors.started_at" class="mt-2" />
            </div>

            <!-- Ended at -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="ended_at" value="Ended at" />
                <jet-input id="ended_at" type="text" class="mt-1 block w-full" 
                    v-model="form.ended_at" :disabled="!permissions.canUpdateBooking" />
                <jet-input-error :message="form.errors.ended_at" class="mt-2" />
            </div>

            <!-- Notes -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="notes" value="Notes" />
                <jet-textarea id="notes" class="mt-1 block w-full" 
                    v-model="form.notes" :disabled="!permissions.canUpdateBooking" />
                <jet-input-error :message="form.errors.notes" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateBooking">
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
    import JetCode from '@/Jetstream/Code'
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
            JetCode,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: {
            booking: {
                type: Object,
                default: {}
            },
            permissions: {
                type: Object
            }
        },

        data() {
            return {
                form: this.$inertia.form({
                    started_at: this.booking.started_at,
                    ended_at: this.booking.ended_at,
                    notes: this.booking.notes
                }),
            }
        },

        methods: {
            updateOrCreate() {
                if (this.$refs.logo) {
                    this.form.logo = this.$refs.logo.files[0]
                }

                if(this.gameProvider.id) {
                    this.form.put(route('booking.update', [this.gameProvider.id]), {
                        errorBag: 'updateGameProvider',
                        preserveScroll: true
                    });
                } else {
                    this.form.post(route('booking.store'), {
                        errorBag: 'createGameProvider',
                        preserveScroll: true
                    });
                }
            }
        },
    }
</script>
