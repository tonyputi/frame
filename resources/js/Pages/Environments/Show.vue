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
                    <update-environment-form v-bind="data" />

                    <jet-section-border v-if="permissions.canDelete" />
                </div>

                <div v-if="permissions.canDelete">
                    <delete-environment-form :data="data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import UpdateEnvironmentForm from './UpdateEnvironmentForm'
import DeleteEnvironmentForm from './DeleteEnvironmentForm'
import InteractWithResource from "@/mixins/InteractWithResource"

export default {
    mixins: [InteractWithResource],
    
    components: {
        AppLayout,
        JetSectionBorder,
        DeleteEnvironmentForm,
        UpdateEnvironmentForm
    },

    computed: {
        title() {
            return this.attributes.id ? `Environment: ${this.attributes.name}` : `Create new environment`
        }
    }
}
</script>
