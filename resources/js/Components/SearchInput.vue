<template>
<!--    <input @input="$emit('update:value', $event.target.value)" type="text" />-->
    <!-- <jet-input type="text" @input="$emit('update:modelValue', $event.target.value)" /> -->
    <!-- <jet-input type="text" @input="doSomething($event)" /> -->
    <jet-input type="text" @input="$emit('update:search', $event.target.value)" />
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
    emits: ['input', 'update:search'],
    methods: {
        doSomething(ev) {
            console.log('update:modelValue', ev);
            this.$emit('update:modelValue', ev.target.value)
            // clearTimeout(this.sid);
            // if(ev instanceof KeyboardEvent && ev.keyCode != 13) {
            //     this.sid = setTimeout(() => {
            //         console.log('update:value', ev.target.value);
            //         // this.$emit('update:value', ev.target.value)
            //     }, 500);
            // } else {
            //     console.log('update:value2', ev);
            //     this.$emit('update:value', ev.target.value);
            // }
        }
    }
}
</script>
