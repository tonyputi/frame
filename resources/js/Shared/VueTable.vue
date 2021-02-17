<template>
    <table>
        <thead>
        <tr>
            <th v-for="(th, index) in header" :key="index"> {{ th }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(line, li) in content" :key="li" :id="li">
            <td
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
