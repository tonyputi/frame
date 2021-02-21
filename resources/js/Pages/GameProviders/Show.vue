<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Game Provider: {{ gameProvider.data.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <!-- <update-profile-information-form :user="$page.props.user" /> -->

                    <jet-section-border />
                </div>

                <!-- <div>
                    <update-miscellanea-form :user="$page.props.user" />

                    <jet-section-border />
                </div> -->

                <!-- <div v-if="$page.props.jetstream.canUpdatePassword">
                    <update-password-form class="mt-10 sm:mt-0" />

                    <jet-section-border />
                </div> -->

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <jet-section-border />

                    <delete-game-provider-form :gameProvider="gameProvider.data" class="mt-10 sm:mt-0" />
                </template>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteGameProviderForm from './DeleteGameProviderForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    // import UpdatePasswordForm from './UpdatePasswordForm'
    // import UpdateProfileInformationForm from './UpdateProfileInformationForm'


    export default {
        props: {
            gameProvider: {
                type: Object,
                default: {
                    data: {
                        name: ''
                    }
                }
            }
        },

        components: {
            AppLayout,
            JetSectionBorder,
            DeleteGameProviderForm
        },

        mounted() {
            console.log(this.gameProvider);
        }
    }
</script>
