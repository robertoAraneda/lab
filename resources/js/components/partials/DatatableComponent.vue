<template>
    <div class="card-body table-responsive">
        <table id="tableID" class="table table-hover">
            <thead>
            <tr v-for="column in columns">
                <th scope="col">{{ column }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index ) in data " :key="index">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.description }}</td>
                <td>{{ item.workarea_id.description }}</td>
                <td>{{ item.available_id.description }}</td>
                <td><span
                    :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.description }}</span>
                </td>
                <td class="text-center py-1 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-info mx-1" href="#"><i class="fas fa-eye"></i></a>
                        <a @click.prevent="setEdit(item)" class="btn btn-warning mx-1" href="#"><i
                            class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger mx-1" href="#" @click="destroy(item, index)"><i
                            class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ["columns", 'data']
    }
</script>

<style scoped>

</style>
