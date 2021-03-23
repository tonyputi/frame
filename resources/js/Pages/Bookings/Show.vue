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
                    <update-booking-form v-bind="data" />

                    <jet-section-border v-if="permissions.canDelete" />
                </div>

                <div v-if="permissions.canDelete">
                    <delete-booking-form :data="data" class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteBookingForm from './DeleteBookingForm'
    import UpdateBookingForm from './UpdateBookingForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        props: ['data'],

        components: {
            AppLayout,
            JetSectionBorder,
            UpdateBookingForm,
            DeleteBookingForm
        },

        props: {
            data: {
                type: Object,
                default: {}
            }
        },

        computed: {
            title() {
                return this.attributes.id ? `Booking: ${this.attributes.id}` : `Create new booking`
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
