<template>
    <jet-confirmation-modal :show="attributes" @close="closeModal">
        <template #title>
            Delete {{ attributes?.name }}
        </template>

        <template #content>
            Are you sure you want to delete {{ attributes?.name }}? Once game provider is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

            <div class="mt-4">
                <jet-input type="text" class="mt-1 block w-3/4" placeholder="Game Provider Name"
                           ref="name"
                           v-model="form.name"
                           @keyup.enter="deleteResource" />

                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteResource" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Delete
            </jet-danger-button>
        </template>
    </jet-confirmation-modal>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'

export default {
    components: {
        JetActionSection,
        JetConfirmationModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetDangerButton,
    },

    props: ['attributes', 'permissions'],
    emits: ['close'],

    data() {
        return {
            confirmingResourceDeletion: false,

            form: this.$inertia.form({
                name: '',
            })
        }
    },

    methods: {
        confirmGameProviderDeletion() {
            this.confirmingResourceDeletion = true;

            setTimeout(() => this.$refs.name.focus(), 250)
        },

        deleteResource() {
            this.form.delete(route('game-providers.destroy', [this.attributes.id]), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.name.focus(),
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
