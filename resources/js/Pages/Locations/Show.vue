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
                    <update-resource-form v-bind="data" :meta="meta" />

                    <jet-section-border v-if="permissions.canDelete" />
                </div>

                <div v-if="permissions.canDelete">
                    <delete-resource-form :data="data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import UpdateResourceForm from './UpdateResourceForm'
import DeleteResourceForm from './DeleteResourceForm'
import InteractWithResource from "@/mixins/InteractWithResource"

export default {
    mixins: [InteractWithResource],
    components: {
        AppLayout,
        JetSectionBorder,
        DeleteResourceForm,
        UpdateResourceForm
    },

    computed: {
        title() {
            return this.attributes.id ? `Location: ${this.attributes.name}` : `Create new location`
        }
    }
}
</script>
