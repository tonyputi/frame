<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Provider: {{ gameProvider.data?.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <update-game-provider-form :gameProvider="gameProvider.data" :permissions="permissions" />

                    <jet-section-border />
                </div>

                <div>
                    <update-game-provider-advanced-form :gameProvider="gameProvider.data" :permissions="permissions" />

                    <jet-section-border v-if="permissions.canDeleteGameProvider" />
                </div>

                <div v-if="permissions.canDeleteGameProvider">
                    <delete-game-provider-form :gameProvider="gameProvider.data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteGameProviderForm from './DeleteGameProviderForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UpdateGameProviderForm from './UpdateGameProviderForm'
    import UpdateGameProviderAdvancedForm from './UpdateGameProviderAdvancedForm'

    export default {
        props: ['gameProvider', 'permissions'],

        components: {
            AppLayout,
            JetSectionBorder,
            DeleteGameProviderForm,
            UpdateGameProviderForm,
            UpdateGameProviderAdvancedForm
        }
    }
</script>
