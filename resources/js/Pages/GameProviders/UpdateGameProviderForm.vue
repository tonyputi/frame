<template>
    <jet-form-section @submitted="updateOrCreate">
        <template #title>
            Game Provider Information
        </template>

        <template #description>
            Update the game provider information.
        </template>

        <template #form>
            <!-- Game Provider Logo -->
            <div class="col-span-6 sm:col-span-4">
                <!-- Game Provider File Input -->
                <input type="file" class="hidden" ref="logo" 
                    @change="updateLogoPreview" 
                    v-if="permissions.canUpdateGameProvider" />

                <jet-label for="logo" value="Logo" />

                <!-- Current Game Provider Logo -->
                <div class="mt-2" v-show="!logoPreview">
                    <img class="rounded-full h-20 w-20 object-cover" :src="gameProvider.logo_url" :alt="gameProvider.name">
                </div>

                <!-- New Game Provider Logo Preview -->
                <div class="mt-2" v-show="logoPreview">
                    <span class="block rounded-full w-20 h-20"
                        :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + logoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button type="button" class="mt-2 mr-2" @click.prevent="selectNewLogo" v-if="permissions.canUpdateGameProvider">
                    Select A New Logo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.prevent="deleteLogo" v-if="gameProvider.logo_path">
                    Remove Logo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.logo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" 
                    v-model="form.name" :disabled="!permissions.canUpdateGameProvider" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Default Host -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="default_host" value="Default Host" />
                <jet-input id="default_host" type="text" class="mt-1 block w-full" 
                    v-model="form.default_host" :disabled="!permissions.canUpdateGameProvider" />
                <jet-input-error :message="form.errors.default_host" class="mt-2" />
            </div>

            <!-- Location Modifier -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="location_modifier" value="Location Modifier" />
                <jet-select id="location_match" class="mt-1 block w-full"
                    v-model="form.location_modifier" :options="['', '=', '~', '~*', '^~']" 
                    :disabled="!permissions.canUpdateGameProvider" />
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
            <div class="col-span-6 sm:col-span-6 w-full">
                <jet-label for="location_block" value="Location Block" />
                <jet-code id="location_block" class="mt-1 block w-full" rows="5" 
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
                    name: this.gameProvider.name,
                    logo: null,
                    location_modifier: this.gameProvider.location_modifier,
                    location_match: this.gameProvider.location_match,
                    location_block: this.gameProvider.location_block,
                    default_host: this.gameProvider.default_host
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
            },

            selectNewLogo() {
                this.$refs.logo.click();
            },

            updateLogoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.logoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.logo.files[0]);
            },

            deleteLogo() {
                this.$inertia.delete(route('game-provider-logo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => (this.logoPreview = null),
                });
            },
        },
    }
</script>
