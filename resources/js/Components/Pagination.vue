<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Previous
            </a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Next
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">1</span>
                    to
                    <span class="font-medium">10</span>
                    of
                    <span class="font-medium">97</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        1
                    </a>

<!--                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        1-->
<!--                    </a>-->
<!--                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        2-->
<!--                    </a>-->
<!--                    <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        3-->
<!--                    </a>-->
<!--                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">-->
<!--                    ...-->
<!--                    </span>-->
<!--                    <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        8-->
<!--                    </a>-->
<!--                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        9-->
<!--                    </a>-->
<!--                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">-->
<!--                        10-->
<!--                    </a>-->
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>


<!--<template>-->
<!--    <div id="pagination" class="w-full flex justify-center border-t border-gray-100 pt-4 items-center">-->

<!--        <div @click="goToFirst" class="pagination-link">-->
<!--            <p class="leading-relaxed cursor-pointer mx-2 text-gray-500 hover:text-blue-600 text-sm font-semibold">-->
<!--                First</p>-->
<!--        </div>-->

<!--        <div :class="data.prev_page_url === null ? 'isDisabled' : null"-->
<!--             class="pagination-link"-->
<!--             v-if="page > 1"-->
<!--             @click="goToPrevious">-->
<!--            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
<!--                 xmlns="http://www.w3.org/2000/svg">-->
<!--                <path fill-rule="evenodd" clip-rule="evenodd"-->
<!--                      d="M9 12C9 12.2652 9.10536 12.5196 9.29289 12.7071L13.2929 16.7072C13.6834 17.0977 14.3166 17.0977 14.7071 16.7072C15.0977 16.3167 15.0977 15.6835 14.7071 15.293L11.4142 12L14.7071 8.70712C15.0977 8.31659 15.0977 7.68343 14.7071 7.29289C14.3166 6.90237 13.6834 6.90237 13.2929 7.29289L9.29289 11.2929C9.10536 11.4804 9 11.7348 9 12Z"-->
<!--                      fill="#18A0FB"/>-->
<!--            </svg>-->
<!--        </div>-->

<!--        <p class="leading-relaxed cursor-pointer mx-2 text-blue-600 hover:text-blue-600 text-sm">-->
<!--            {{ data.current_page }}</p>-->

<!--        <div :class="data.next_page_url === null ? 'isDisabled' : null"-->
<!--             class="pagination-link"-->
<!--             v-if="page < data.last_page"-->
<!--             @click="goToNext">-->
<!--            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
<!--                 xmlns="http://www.w3.org/2000/svg">-->
<!--                <path fill-rule="evenodd" clip-rule="evenodd"-->
<!--                      d="M15 12C15 11.7348 14.8946 11.4804 14.7071 11.2929L10.7071 7.2929C10.3166 6.9024 9.6834 6.9024 9.2929 7.2929C8.9024 7.6834 8.9024 8.3166 9.2929 8.7071L12.5858 12L9.2929 15.2929C8.9024 15.6834 8.9024 16.3166 9.2929 16.7071C9.6834 17.0976 10.3166 17.0976 10.7071 16.7071L14.7071 12.7071C14.8946 12.5196 15 12.2652 15 12Z"-->
<!--                      fill="#18A0FB"/>-->
<!--            </svg>-->
<!--        </div>-->

<!--        <div @click="goToLast" class="pagination-link">-->
<!--            <p class="leading-relaxed cursor-pointer mx-2 text-gray-500 hover:text-blue-500 text-sm font-semibold">-->
<!--                Last-->
<!--            </p>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<script>
export default {
    props: {
        meta: Object
    },

    computed: {
        params() {
            const search = location.search.substring(1);
            if (search && search.length) {
                return JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
            }

            return {};
        },

        page() {
            return this.meta.current_page;
        }
    },

    methods: {
        goToFirst($event) {
            $event.preventDefault();
            this.goToPage(1);
        },

        goToLast($event) {
            $event.preventDefault();
            this.goToPage(this.meta.last_page);
        },

        goToPrevious($event) {
            $event.preventDefault();
            if (this.page > 1) {
                this.goToPage(this.page - 1);
            }
        },

        goToNext($event) {
            $event.preventDefault();
            if (this.meta.last_page > this.page) {
                this.goToPage(this.page + 1);
            }
        },

        goToPage(page) {
            this.$inertia.replace(
                window.location.pathname,
                {
                    meta: {
                        ...this.params,
                        page: page
                    }
                }
            );
        }
    }
};
</script>
