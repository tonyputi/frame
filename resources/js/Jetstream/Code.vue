<template>
    <textarea 
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="textarea" />
</template>

<script>
    import CodeMirror from 'codemirror'
    import 'codemirror/mode/nginx/nginx'

    import 'codemirror/lib/codemirror.css'
    import 'codemirror/theme/dracula.css'

    CodeMirror.defineMode('htmltwig', function (config, parserConfig) {
        return CodeMirror.overlayMode(
            CodeMirror.getMode(config, parserConfig.backdrop || 'text/html'),
            CodeMirror.getMode(config, 'twig')
        )
    })

    export default {
        props: ['modelValue'],

        emits: ['update:modelValue'],
        data: () => ({ codemirror: null }),
        mounted() {
            const config = {
                ...{
                    tabSize: 4,
                    indentWithTabs: true,
                    lineWrapping: true,
                    lineNumbers: true,
                    theme: 'dracula',
                    ...{ readOnly: this.$refs.textarea.disabled },
                },
                ...{ mode: 'nginx'},
            }

            this.codemirror = CodeMirror.fromTextArea(this.$refs.textarea, config)
            this.codemirror.setSize('100%', 250)
        },

        methods: {
            focus() {
                this.$refs.textarea.focus()
            }
        }
    }
</script>

