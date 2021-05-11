<template>
    <!-- Duplicate Resource Modal -->
    <jet-dialog-modal :show="attributes" @close="closeModal">
        <template #title>
            Duplicate {{ attributes?.name }}
        </template>

        <template #content>
            <form>
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="name" value="New Name" />
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" ref="name" />
                    <jet-input-error :message="form.errors.name" class="mt-2" />
                </div>

                <!-- Domain -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="domain" value="New Domain" />
                    <jet-input id="domain" type="text" class="mt-1 block w-full" v-model="form.domain" ref="domain" />
                    <jet-input-error :message="form.errors.domain" class="mt-2" />
                </div>

                <!-- Include locations -->
                <div class="col-span-6 sm:col-span-4 mt-2">
                    <jet-label for="withLocations" value="Include locations" />
                    <jet-checkbox id="withLocations" v-model:checked="form.withLocations" ref="withLocations" />
                    <jet-input-error :message="form.errors.withLocations" class="mt-2" />
                </div>
            </form>
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-button class="ml-2" @click="duplicate" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Duplicate
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
import JetSelect from '@/Jetstream/Select'
import JetCheckbox from '@/Jetstream/Checkbox'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetButton from '@/Jetstream/Button'

export default {
    components: {
        JetActionSection,
        JetDialogModal,
        JetInput,
        JetSelect,
        JetCheckbox,
        JetLabel,
        JetInputError,
        JetSecondaryButton,
        JetButton,
    },

    props: ['attributes', 'permissions'],
    emits: ['close'],

    data() {
        return {
            form: this.$inertia.form({
                id: this.attributes.id,
                name: `${this.attributes.name} Copy`,
                domain: this.attributes?.domain,
                withLocations: true,
            })
        }
    },

    methods: {
        duplicate() {
            this.form.post(route('environments.duplicate'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.date.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.$emit('close')

            this.form.reset()
        },
    },
}
</script>
