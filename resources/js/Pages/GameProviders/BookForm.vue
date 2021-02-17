<template>
    <form @submit="submit">
        <div class="bg-white m-auto">
            <div class="py-4 px-8 rounded-xl">
                <h1 class="font-medium text-2xl mt-3 text-center">Book {{ provider.name }}</h1>
                <form action="" class="mt-6">
                    <div class="my-5 text-sm">
                        <label class="block text-black">Start At</label>
                        <input type="text"
                               v-model="startAt"
                               class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" />
                    </div>
                    <div class="my-5 text-sm">
                        <label class="block text-black">End At</label>
                        <input type="text"
                               v-model="endAt"
                               class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" />
                    </div>

                    <div class="my-5 text-sm">
                        <label class="block text-black">Notes</label>
                        <textarea rows="7"
                                  v-model="notes"
                                  class="w-full border-2 border-gray-300 bg-white px-5 pr-16 rounded-lg text-sm focus:outline-none" />
                    </div>

                    <button class="justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 w-full">Book</button>
                </form>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: {
        provider: Object
    },

    data() {
        const now = new Date();
        const oneHourFromNow = new Date(now.setHours(now.getHours() + 1));
        const locale = 'en-UK';

        return {
            startAt: (new Date()).toLocaleString(locale),
            endAt: oneHourFromNow.toLocaleString(locale),
            notes: ''
        }
    },

    methods: {
        submit($event) {
            $event.preventDefault();
            this.$emit('success');
        }
    }
}
</script>
