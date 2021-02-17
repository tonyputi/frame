<template>
    <table class="table-auto w-full">
        <thead class="justify-between">
            <tr class="bg-gray-800 text-white">
                <th v-for="(th, index) in header" :key="index" class="px-2 text-center"> {{ th }}</th>
            </tr>
        </thead>
        <tbody class="bg-gray-200">
            <tr v-for="(line, li) in content" :key="li" :id="li" class="bg-white border-4 border-gray-200">
                <td
                    class="px-2 py-2 text-sm text-center"
                    v-for="(column, key) in line"
                    :key="key"
                    :data-label="header[key]"
                >
                    <div v-html="column"/>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>

export default {

    props: {
        header: Array,
        content: Array
    }
};
</script>
