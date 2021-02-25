<template>
<!--    <input @input="$emit('update:value', $event.target.value)" type="text" />-->
    <input type="text" />
</template>

<script>
export default {
    data(){
        return {
            value: '',
            schedulerId: null
        }
    },
    emits: ['input', 'update:value'],
    computed: {
        inputListeners(){
            return Object.assign({}, this.$listeners, {
                input: (ev) => this.$emit('input', ev.target.value),
                keyup: (ev) => {
                    clearTimeout(this.schedulerId);
                    if(ev instanceof KeyboardEvent && ev.keyCode != 13) {
                        this.schedulerId = setTimeout(() => this.$emit('update:value', ev.target.value), 500);
                    } else {
                        this.$emit('update:value', ev.target.value);
                    }
                }
            });
        }
    }
}
</script>
