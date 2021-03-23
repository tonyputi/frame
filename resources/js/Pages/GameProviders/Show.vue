<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <update-game-provider-form v-bind="data" />

                    <jet-section-border v-if="permissions.canDelete" />
                </div>

                <div v-if="permissions.canDelete">
                    <delete-game-provider-form :data="data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UpdateGameProviderForm from './UpdateGameProviderForm'
    import DeleteGameProviderForm from './DeleteGameProviderForm'

    export default {
        props: ['data'],

        components: {
            AppLayout,
            JetSectionBorder,
            DeleteGameProviderForm,
            UpdateGameProviderForm
        },

        props: {
            data: {
                type: Object,
                default: {}
            }
        },

        computed: {
            title() {
                return this.attributes.id ? `Game Provider: ${this.attributes.name}` : `Create new game provider`
            },
            attributes() {
                return this.data.attributes || {}
            },
            permissions() {
                return this.data.permissions || {}
            }
        }
    }
</script>
