<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Environment Information
        </template>

        <template #description>
            Update the environment information.
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full"
                    v-model="form.name" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Domain -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="domain" value="Domain" />
                <jet-input id="domain" type="text" class="mt-1 block w-full"
                    v-model="form.domain" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.domain" class="mt-2" />
            </div>

            <!-- Is bookable -->
            <div class="col-span-6 sm:col-span-4 mt-2">
                <jet-label for="is_bookable" value="Bookable" />
                <jet-checkbox id="is_bookable" v-model:checked="form.is_bookable" ref="is_bookable" />
                <jet-input-error :message="form.errors.is_bookable" class="mt-2" />
            </div>

            <!-- Middleware -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="middleware" value="Middleware" />
                <jet-input id="middleware" type="text" class="mt-1 block w-full"
                    v-model="form.middleware" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.middleware" class="mt-2" />
            </div>

            <!-- Prefix -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="prefix" value="Prefix" />
                <jet-input id="prefix" type="text" class="mt-1 block w-full"
                    v-model="form.prefix" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.prefix" class="mt-2" />
            </div>

            <!-- Default redirect to -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="default_redirect_to" value="Default redirect to" />
                <jet-input id="default_redirect_to" type="text" class="mt-1 block w-full"
                    v-model="form.default_redirect_to" :disabled="!canUpdateOrCreate" />
                <jet-input-error :message="form.errors.default_redirect_to" class="mt-2" />
            </div>

            <!-- Default redirect ip -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="default_redirect_ip" value="Default redirect IP" />
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
    import JetCheckbox from '@/Jetstream/Checkbox'
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
            JetCheckbox,
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
            }
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: this.attributes.name,
                    domain: this.attributes.domain,
                    is_bookable: this.attributes.is_bookable,
                    middleware: this.attributes.middleware,
                    prefix: this.attributes.prefix,
                    default_redirect_to: this.attributes.default_redirect_to,
                    default_redirect_ip: this.attributes.default_redirect_ip
                })
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
                if(this.attributes.id) {
                    this.form.put(route('environments.update', [this.attributes.id]), {
                        errorBag: 'updateEnvironment',
                        preserveScroll: true
                    });
                } else {
                    this.form.post(route('environments.store'), {
                        errorBag: 'createEnvironment',
                        preserveScroll: true
                    });
                }
            }
        },
    }
</script>
