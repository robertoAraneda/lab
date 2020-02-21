
<template>
    <table class="table table-hover">
        <thead>
        <tr>
            <th v-for="column in columns" :key="columns.name" @click="$emit('sort', column.name)"
                :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc': 'sorting_desc') : 'sorting'"
                :style="'width:'+column.width+';'+'cursor:pointer;'">
                {{ column.label }}
            </th>
            <th></th>
        </tr>
        </thead>
        <slot></slot>
    </table>

</template>

<script>
    export default {
        props: ['columns', 'sortKey', 'sortOrders']
    }
</script>

