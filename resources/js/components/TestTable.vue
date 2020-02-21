<template>
    <div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody>
            <tr v-for="(item, index ) in items" :key="index">
                <td>{{ item.id }}</td>
                <td>{{item.description }}</td>
                <td><span
                    :class="item.state_id.id == 1 ||item.state_id == 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.id == 1 ||item.state_id == 1 ? 'ACTIVO':'INACTIVO'}}</span>
                </td>
                <td class="text-center py-1 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-info mx-2" href="#"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-warning mx-2" href="#"><i
                            class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger mx-2" href="#"><i
                            class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getProjects(pagination.prevPageUrl)"
                    @next="getProjects(pagination.nextPageUrl)">
        </pagination>
    </div>
</template>

<script>
    import Datatable from './partials/Datatable.vue';
    import Pagination from './partials/Pagination.vue';

    export default {

        components: {datatable: Datatable, pagination: Pagination},
        created() {
            this.getProjects();
        },
        data() {
            let sortOrders = {};
            let columns = [
                {width: '33%', label: 'ID', name: 'id'},
                {width: '33%', label: 'Descripcion', name: 'description'},
                {width: '33%', label: 'Estado', name: 'state'}
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                items: [],
                url: '/api/section/',
                columns: columns,
                sortKey: 'id',
                sortOrders: sortOrders,
                perPage: ['10', '20', '30'],
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
            }
        },
        methods: {
            getProjects(url = '/api/section/') {

                axios.get(url)
                    .then(response => {
                        console.log(response)
                        let data = response.data;

                        this.items = data.data;
                        this.configPagination(data);

                        console.log(this.items)


                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            configPagination(data) {

                this.pagination.lastPage = data.meta.last_page;
                this.pagination.currentPage = data.meta.current_page;
                this.pagination.total = data.meta.total;
                this.pagination.lastPageUrl = this.url + data.links.last;
                this.pagination.nextPageUrl = this.url + data.links.next;
                this.pagination.prevPageUrl = this.url + data.links.prev;
                this.pagination.from = data.meta.from;
                this.pagination.to = data.meta.to;
                console.log(this.pagination)
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getProjects();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
        }
    }
</script>

<style scoped>

</style>
