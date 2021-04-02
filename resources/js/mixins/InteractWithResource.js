export default {
    props: {
        data: {
            type: Object,
            default: {}
        },
        meta: {
            type: Object,
            default: {}
        }
    },
    computed: {
        attributes() {
            return this.data.attributes || {}
        },
        permissions() {
            return this.data.permissions || {}
        }
    }
}