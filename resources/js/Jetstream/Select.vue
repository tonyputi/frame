<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        ref="select">
        <option v-for="(element, i) in elements" :key="i" :value="element.value">{{ element.name }}</option>
    </select>
</template>

<script>
    export default {
        props: {
            modelValue: {
                type: String
            },
            options: {
                type: Object,
                default: []
            }
        },

        emits: ['update:modelValue'],

        computed: {
            elements() {
                return _.map(this.options, function(option, key) {
                    if(typeof option === 'Object') {
                        return {
                            name: option.name,
                            value: option.value
                        }
                    }

                    return {
                        name: key || option,
                        value: option
                    }
                })
            }
        },

        methods: {
            focus() {
                this.$refs.select.focus()
            }
        }
    }
</script>

