export default {
    methods: {
        datetimeFormat(datetime, format = null) {
            if(datetime) {
                return moment(datetime).format(format)
            }
        }
    }
}