<template>
    <jet-form-section @submitted="updateMiscellaneaInformation">
        <template #title>
            User Miscellanea
        </template>

        <template #description>
            Update your account's extra configuration
        </template>

        <template #form>
            <!-- Host -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="host" value="Host" />
                <jet-input id="host" type="text" class="mt-1 block w-full" v-model="form.host" />
                <jet-input-error :message="form.errors.host" class="mt-2" />
            </div>
        </template>

        <template #actions>
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
        JetSecondaryButton,
    },

    props: ['user'],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                host: this.user.host || '',
            }),
        }
    },

    methods: {
        updateMiscellaneaInformation() {
            console.log('why');
            this.form.post(route('user-miscellanea.update'), {
                errorBag: 'updateMiscellaneaInformation',
                preserveScroll: true
            });
        },
    },
}
</script>
