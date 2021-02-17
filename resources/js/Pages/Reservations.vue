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


            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import SearchForm from "@/Pages/GameProviders/SearchForm";

export default {
    components: {
        AppLayout,
        Welcome,
        SearchForm
    },

    props: {
      casinoProviders: Array
    }
};
</script>
