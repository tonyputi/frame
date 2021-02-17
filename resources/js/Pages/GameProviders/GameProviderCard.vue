<template>
    <div class="flex flex-col bg-white provider-card p-4 sm:rounded-lg">
        <div class="provider-card-header mb-2">
            <div class="provider-status" :class="providerClass"></div>
            <h2 class="provider-name">{{ provider.name }}</h2>
        </div>
        <div class="provider-card-body flex flex-col flex-1 items-start justify-end">
            <div class="text-sm" v-if="!provider.is_available">
                <p>{{ provider.user.name }}</p>
                <p>{{ provider.started_at }} - {{ provider.ended_at }}</p>
            </div>

            <button @click="isModalShown = true"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 mt-5">
                Book <span v-if="provider.is_available">&nbsp;Now</span>
            </button>
        </div>

        <common-modal
            @close="isModalShown = false"
            v-if="isModalShown">
            <template #content>
                <book-form :provider="provider"></book-form>
            </template>
        </common-modal>
    </div>
</template>
<script>
import BookForm from "@/Pages/GameProviders/BookForm";
import CommonModal from "@/Shared/CommonModal";
export default {
    components: {CommonModal, BookForm},

    props: {
        provider: Object,
    },

    computed: {
        providerClass() {
            return this.provider.is_available ? 'available' : 'unavailable';
        }
    },

    data() {
        return {
            isModalShown: false
        };
    }
}
</script>
<style>
.provider-card {
    min-height: 120px;
}

.provider-card-header {
    display: flex;
    align-items: center;
}

.provider-name {
    display: inline-block;
    font-weight: bold;
}

.provider-status {
    display: inline-block;
    margin-right: 10px;
    height: 16px;
    width: 16px;
    border-radius: 50%;
}

.provider-status.available {
    background-color: green;
}

.provider-status.unavailable {
    background-color: red;
}
</style>
