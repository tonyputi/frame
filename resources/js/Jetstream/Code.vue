<template>
    <textarea ref="textarea" />
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
                    indentWithTabs: false,
                    lineWrapping: true,
                    lineNumbers: true,
                    theme: 'dracula',
                    ...{ readOnly: this.$refs.textarea.disabled },
                },
                ...{ mode: 'nginx'},
            }

            this.codemirror = CodeMirror.fromTextArea(this.$refs.textarea, config)
            
            this.doc.on('change', (cm, changeObj) => {
                this.$emit('update:modelValue', cm.getValue())
            })

            if(this.modelValue) {
                this.doc.setValue(this.modelValue)
            }

            this.codemirror.setSize('100%', 250)
        },

        methods: {
            focus() {
                this.$refs.textarea.focus()
            }
        },

        computed: {
            doc() {
                return this.codemirror.getDoc()
            },
        },
    }
</script>

