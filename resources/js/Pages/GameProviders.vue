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
                    <casino-provider-card
                        v-for="provider in gameProviders"
                        :provider="provider"/>
                </div>
                <pagination :data="meta" v-if="meta.last_page > 1" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import CasinoProviderCard from "@/Pages/GameProviders/GameProviderCard";
import SearchForm from "@/Pages/GameProviders/SearchForm";
import Pagination from "@/Pages/Common/Pagination";

export default {
    components: {
        Pagination,
        AppLayout,
        Welcome,
        CasinoProviderCard,
        SearchForm
    },

    props: {
        gameProviders: Array,
        meta: Object
    },

    created() {
        console.log(this.gameProviders);
    }
};
</script>
