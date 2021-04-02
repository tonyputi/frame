<template>
    <table class="table-auto w-full" v-if="hasResources">
        <thead>
            <tr class="bg-gray-800 text-white">
                <!-- Select Checkbox -->
                <th class="w-16" v-if="shouldShowCheckboxes">
                    <jet-checkbox v-model:checked="selectAll" />
                </th>

                <!-- Field Names -->
                <th v-for="field in fields" class="px-2 py-4 text-left" :key="field">
                    {{ field }}
                    <!-- <sortable-icon
                        @sort="requestOrderByChange(field)"
                        @reset="resetOrderBy(field)"
                        :resource-name="resourceName"
                        :uri-key="field.sortableUriKey"
                        v-if="field.sortable"
                    >
                        {{ field.indexName }}
                    </sortable-icon> -->

                    <!-- <span v-else>{{ field.indexName }}</span> -->
                </th>

                <!-- Actions, View, Edit, Delete -->
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="resource in data" :key="resource.attributes.id" class="border border-black-600"> 
                <td class="w-16" v-if="shouldShowCheckboxes">
                    <jet-checkbox :value="resource" v-model:checked="resourcesSelected" />
                </td>

                <td v-for="field in fields" :class="`text-${field.textAlign}`" :key="field">
                    {{ resource.attributes[field] }}
                </td>

                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import JetCheckbox from "@/Jetstream/Checkbox";

export default {
    components: {
        JetCheckbox
    },
    data() {
        return {
            resourcesSelected: []
        }
    },
    props: {
        shouldShowCheckboxes: {
            type: Boolean,
            default: true
        },
        attributes: {
            type: Object,
            default: []
        },
        data: {
            type: Object,
            default: []
        }
    },
    computed: {
        hasResources() {
            return this.data.length > 0
        },
        fields() {
            return _.keys(_.first(this.data).attributes)
        }
    },
    methods: {

    },
    mounted() {
        
    }
}
</script>