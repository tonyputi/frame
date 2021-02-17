<template>
    <div id="pagination" class="w-full flex justify-center border-t border-gray-100 pt-4 items-center">

        <inertia-link @click="goToFirst">
            <p class="leading-relaxed cursor-pointer mx-2 text-gray-500 hover:text-blue-600 text-sm font-semibold">
                First</p>
        </inertia-link>

        <inertia-link :class="data.prev_page_url === null ? 'isDisabled' : null"
                      v-if="page > 1"
                      @click="goToPrevious">
            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M9 12C9 12.2652 9.10536 12.5196 9.29289 12.7071L13.2929 16.7072C13.6834 17.0977 14.3166 17.0977 14.7071 16.7072C15.0977 16.3167 15.0977 15.6835 14.7071 15.293L11.4142 12L14.7071 8.70712C15.0977 8.31659 15.0977 7.68343 14.7071 7.29289C14.3166 6.90237 13.6834 6.90237 13.2929 7.29289L9.29289 11.2929C9.10536 11.4804 9 11.7348 9 12Z"
                      fill="#18A0FB"/>
            </svg>
        </inertia-link>

        <p class="leading-relaxed cursor-pointer mx-2 text-blue-600 hover:text-blue-600 text-sm">
            {{ data.current_page }}</p>

        <inertia-link :class="data.next_page_url === null ? 'isDisabled' : null"
                      v-if="page < data.last_page"
                      @click="goToNext">
            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M15 12C15 11.7348 14.8946 11.4804 14.7071 11.2929L10.7071 7.2929C10.3166 6.9024 9.6834 6.9024 9.2929 7.2929C8.9024 7.6834 8.9024 8.3166 9.2929 8.7071L12.5858 12L9.2929 15.2929C8.9024 15.6834 8.9024 16.3166 9.2929 16.7071C9.6834 17.0976 10.3166 17.0976 10.7071 16.7071L14.7071 12.7071C14.8946 12.5196 15 12.2652 15 12Z"
                      fill="#18A0FB"/>
            </svg>
        </inertia-link>

        <inertia-link @click="goToLast">
            <p class="leading-relaxed cursor-pointer mx-2 text-gray-500 hover:text-blue-500 text-sm font-semibold">
                Last</p>
        </inertia-link>
    </div>
</template>
<script>
export default {
    props: {
        data: Object
    },

    computed: {
        params() {
            const search = location.search.substring(1);
            return JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
        },

        page() {
            return this.data.current_page;
        }
    },

    methods: {
        goToFirst($event) {
            $event.preventDefault();
            this.goToPage(1);
        },

        goToLast($event) {
            $event.preventDefault();
            this.goToPage(this.data.last_page);
        },

        goToPrevious($event) {
            $event.preventDefault();
            if (this.page > 1) {
                this.goToPage(this.page - 1);
            }
        },

        goToNext($event) {
            $event.preventDefault();
            if (this.data.last_page > this.page) {
                this.goToPage(this.page + 1);
            }
        },

        goToPage(page) {
            this.$inertia.replace(
                window.location.pathname,
                {
                    data: {
                        ...this.params,
                        page: page
                    }
                }
            );
        }
    }
};
</script>
