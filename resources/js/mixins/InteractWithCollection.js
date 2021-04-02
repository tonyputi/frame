export default {
    props: {
        data: {
            type: Object,
            default: {}
        },
        meta: {
            type: Object,
            default: {}
        },
        permissions: {
            type: Object,
            default: {}
        }
    },
    methods: {
        filter(ev) {
            this.$inertia.reload({data: { search: ev.target.value, page: 1 }})
        }
    }
}