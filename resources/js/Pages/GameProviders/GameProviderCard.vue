<template>
    <div class="bg-white provider-card p-4 sm:rounded-lg">
        <div class="provider-card-header">
            <div class="provider-status" :class="providerClass"></div>
            <h2 class="provider-name">{{ provider.name }}</h2>
        </div>
        <div class="provider-card-body">
            <button v-if="provider.is_available"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 mt-5">
                Book
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        provider: Object,
    },

    computed: {
        providerClass() {
            return this.provider.is_available ? 'available' : 'unavailable';
        }
    },

    created() {

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
