<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Casino Providers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <search-form></search-form>

                <div class="overflow-hidden sm:rounded-lg py-12 grid grid-cols-3 gap-4">
                    <game-provider-card
                        v-for="provider in casinoProviders"
                        :provider="provider"/>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import GameProviderCard from "@/Pages/GameProviders/GameProviderCard";
import SearchForm from "@/Pages/GameProviders/SearchForm";

export default {
    components: {
        AppLayout,
        Welcome,
        GameProviderCard,
        SearchForm
    },

    props: {
      casinoProviders: Array
    }
};
</script>
