<template>
    <span v-if="value" class="bg-red-600 inline-block w-3 h-3 mr-2 rounded-full" />
    <span v-else class="bg-green-600 inline-block w-3 h-3 mr-2 rounded-full" />
</template>

<script>

export default {
    props: {
        value: {
            type: Boolean,
            default: false
        }
    }
}
</script>
