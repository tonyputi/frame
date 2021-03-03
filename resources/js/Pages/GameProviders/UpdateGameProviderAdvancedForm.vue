<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Game Provider Advanced
        </template>

        <template #description>
            Update advanced game provider settings.
        </template>

        <template #form>
            <!-- Location Modifier -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="location_modifier" value="Location Modifier" />
                <jet-input id="location_modifier" type="text" class="mt-1 block w-full" 
                    v-model="form.location_modifier" :disabled="!permissions.canUpdateGameProvider" />
                <jet-input-error :message="form.errors.location_modifier" class="mt-2" />
            </div>

            <!-- Location Match -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="location_match" value="Location Match" />
                <jet-input id="location_match" type="text" class="mt-1 block w-full" 
                    v-model="form.location_match" :disabled="!permissions.canUpdateGameProvider" />
                <jet-input-error :message="form.errors.location_match" class="mt-2" />
            </div>

            <!-- Location Block -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="location_block" value="Location Block" />
                <jet-textarea id="location_block" class="mt-1 block w-full" rows="5" 
                    v-model="form.location_block" :disabled="!permissions.canUpdateGameProvider" />
                <jet-input-error :message="form.errors.location_block" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateGameProvider">
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
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetTextarea from '@/Jetstream/Textarea'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetTextarea,
            JetSecondaryButton,
        },

        props: {
            gameProvider: {
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
                    location_modifier: this.gameProvider.location_modifier,
                    location_match: this.gameProvider.location_match,
                    location_block: this.gameProvider.location_block,
                }),

                logoPreview: null,
            }
        },

        methods: {
            updateOrCreate() {
                if (this.$refs.logo) {
                    this.form.logo = this.$refs.logo.files[0]
                }

                if(this.gameProvider.id) {
                    this.form.put(route('game-providers.update', [this.gameProvider.id]), {
                        errorBag: 'updateGameProvider',
                        preserveScroll: true
                    });
                } else {
                    this.form.post(route('game-providers.store'), {
                        errorBag: 'createGameProvider',
                        preserveScroll: true
                    });
                }
            }
        },
    }
</script>
