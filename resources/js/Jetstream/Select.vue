<template>
    <select v-for="(option, i) in options" :key="i"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="select">
        <option value="option">{{ option }}</option>
    </select>
</template>

<script>
    export default {
        props: {
            modelValue: {
                type: String
            },
            options: {
                type: [Object, Array],
                default: []
            }
        },

        emits: ['update:modelValue'],

        computed: {
            optionss() {
                if(typeof this.options === Array) {

                } else if(typeof this.options === Object) {

                }
            }
        },

        methods: {
            focus() {
                this.$refs.select.focus()
            }
        }
    }
</script>

