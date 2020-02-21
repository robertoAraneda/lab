<template>
    <nav class="pagination">
        <span class="page-stats">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
        <a v-if="pagination.prevPageUrl" class="btn btn-info mx-2 text-white pagination-previous" @click="$emit('prev')">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="btn btn-info mx-2 text-white pagination-previous" v-else :disabled="true">
            <i class="fas fa-chevron-left"></i>
        </a>

        <a v-if="pagination.nextPageUrl" class="btn btn-info mx-2 text-white pagination-next" @click="$emit('next')">
            <i class="fas fa-chevron-right"></i>
        </a>
        <a class="btn btn-info mx-2 pagination-next text-white" v-else :disabled="true">
            <i class="fas fa-chevron-right"></i>
        </a>
    </nav>
</template>

<script>
    export default {
            props: ['pagination', 'client', 'filtered']

    }
</script>

<style lang="scss">
    .pagination {
        justify-content: flex-end !important;

        .page-stats {
            align-items: center;
            margin-right: 5px;
        }
    }
</style>
