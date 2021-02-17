<template>
    <div class="bg-white casino-provider-card p-4 sm:rounded-lg">
        <h2>{{ provider.name }}</h2>
    </div>
</template>
<script>
export default {
    props: {
        provider: Object,
    },
    created() {

    }
}
</script>
