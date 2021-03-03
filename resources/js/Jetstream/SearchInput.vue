<template>
    <jet-input type="text" 
        class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" 
        @input="search" />
</template>

<script>
import JetInput from '@/Jetstream/Input';

export default {
    components: {
        JetInput
    },
    data() {
        return {
            sid: null
        }
    },
    props: {
        timeout: {
            type: Number,
            default: 500
        }
    },
    emits: ['input'],
    methods: {
        search(ev) {
            clearTimeout(this.sid);
            this.sid = setTimeout(() => this.$emit('input', ev), this.timeout);
        },
        // search: _.debounce(function(ev) {
        //     this.$emit('input', ev)
        // }, 500)
    }
}
</script>
