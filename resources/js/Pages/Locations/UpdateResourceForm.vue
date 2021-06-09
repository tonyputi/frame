<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Location Information
        </template>

        <template #description>
            Update the location information.
        </template>

        <template #form>
            <!-- Environment -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="environment_id" value="Environment" />
                <jet-select id="environment_id" class="mt-1 block w-full"
                    v-model="form.environment_id" :disabled="!canUpdateOrCreate" :options="meta.environments" />
                <jet-input-error :message="form.errors.environment_id" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full"
                    v-model="form.name" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Location Match -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="match" value="Location Match" />
                <jet-input id="match" type="text" class="mt-1 block w-full"
                    v-model="form.match" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.match" class="mt-2" />
            </div>

            <!-- Default Host -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="default_redirect_to" value="Default Host" />
                <jet-input id="default_redirect_to" type="text" class="mt-1 block w-full"
                    v-model="form.default_redirect_to" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.default_redirect_to" class="mt-2" />
            </div>

            <!-- Default Host -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="default_redirect_ip" value="Default IP" />
                <jet-input id="default_redirect_ip" type="text" class="mt-1 block w-full"
                    v-model="form.default_redirect_ip" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.default_redirect_ip" class="mt-2" />
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
import JetCode from '@/Jetstream/Code'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetSelect from '@/Jetstream/Select'

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
        JetSelect,
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
        },
        meta: {
            type: Object,
            default: {}
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                environment_id: this.attributes.environment_id || route().params.environment,
                name: this.attributes.name,
                logo: null,
                match: this.attributes.match,
                default_redirect_to: this.attributes.default_redirect_to,
                default_redirect_ip: this.attributes.default_redirect_ip
            }),

            logoPreview: null,
        }
    },

    computed: {
        // TODO: this can be mixed
        canUpdateOrCreate() {
            return this.permissions.canUpdate || !this.attributes.id
        },
    },

    methods: {
        updateOrCreate() {
            if (this.$refs.logo) {
                this.form.logo = this.$refs.logo.files[0]
            }

            if(this.attributes.id) {
                this.form.put(route('locations.update', [this.attributes.id]), {
                    errorBag: 'updateLocation',
                    preserveScroll: true
                });
            } else {
                this.form.post(route('locations.store'), {
                    errorBag: 'createLocation',
                    preserveScroll: true
                });
            }
        }
    },
}
</script>
