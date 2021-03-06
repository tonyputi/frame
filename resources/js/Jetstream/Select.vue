<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="select">
        <template v-for="(element, i) in elements" :key="i">
            <option :value="element.value">{{ element.name }}</option>
        </template>
    </select>
</template>

<script>
    export default {
        props: {
            modelValue: {
                type: String
            },
            options: {
                type: [Object],
                default: []
            }
        },

        emits: ['update:modelValue'],

        computed: {
            elements() {
                return _.map(this.options, function(option) {
                    if(typeof option === 'string'){
                        return {
                            name: option,
                            value: option
                        }
                    } else if(typeof option === 'Object') {
                        return {
                            name: option.name,
                            value: option.value
                        }
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

