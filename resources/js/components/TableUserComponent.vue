<template>
    <div>
        <!--    card para el registro de secciones-->
        <div v-if="!editing" class="card mt-2 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Crear un nuevo registro</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-tool"
                        data-card-widget="collapse"
                        data-toggle="tooltip"
                        title="Collapse"
                    >
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label
                                    for="description"
                                    v-if="description === ''"
                                    >&nbsp;</label
                                >
                                <label for="description" v-else>NOMBRE:</label>
                                <input
                                    v-model="description"
                                    type="text"
                                    class="form-control"
                                    :class="checkDescription"
                                    id="description"
                                    placeholder="NOMBRE:"
                                    name="description"
                                />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="state_id" v-if="state_id === 0"
                                    >&nbsp;</label
                                >
                                <label for="description" v-else>NOMBRE:</label>
                                <select
                                    v-model="state_id"
                                    class="custom-select"
                                    :class="checkState"
                                    id="state_id"
                                    name="state_id"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option
                                        v-for="state in selectState"
                                        :value="state.id"
                                        >{{ state.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <button
                                @click="save"
                                type="submit"
                                class="btn btn-primary btn-block "
                            >
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--        formulario para la edicion de secciones-->
        <div v-if="editing" class="card mt-2 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Modificar registro</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-tool"
                        data-card-widget="collapse"
                        data-toggle="tooltip"
                        title="Collapse"
                    >
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="hidden" v-model="id" />
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input
                                    v-model="description"
                                    :class="checkDescription"
                                    type="text"
                                    class="form-control"
                                    placeholder="descripcion"
                                />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="state_id">Estado</label>
                                <select
                                    v-model="state_id"
                                    class="custom-select"
                                    :class="checkState"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option
                                        v-for="state in selectState"
                                        :value="state.id"
                                        >{{ state.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <button
                                @click="edit"
                                type="submit"
                                class="btn btn-warning btn-block "
                            >
                                Editar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--lista de secciones-->
        <div class="card mt-2">
            <div class="card-header">
                <h3 class="card-title">Lista general</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table
                    id="tableSection"
                    class="table table-bordered table-hover table-sm"
                >
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Description</th>
                            <th>Estado</th>
                            <th style="width: 15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                            <td>{{ item.id }}</td>
                            <td>{{ item.description }}</td>
                            <td>
                                <span
                                    :class="
                                        item.state_id.id == 1 ||
                                        item.state_id == 1
                                            ? 'badge badge-success'
                                            : 'badge badge-danger'
                                    "
                                >
                                    {{
                                        item.state_id.id == 1 ||
                                        item.state_id == 1
                                            ? 'ACTIVO'
                                            : 'INACTIVO'
                                    }}</span
                                >
                            </td>
                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-info mx-2" href="#"
                                        ><i class="fas fa-eye"></i
                                    ></a>
                                    <a
                                        @click="setEdit(item)"
                                        class="btn btn-warning mx-2"
                                        href="#"
                                        ><i class="fas fa-pencil-alt"></i
                                    ></a>
                                    <a
                                        class="btn btn-danger mx-2"
                                        href="#"
                                        @click="destroy(item, index)"
                                        ><i class="fas fa-trash"></i
                                    ></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item">
                        <a class="page-link" @click="firstPage">&laquo;</a>
                    </li>
                    <!--                    <li class="page-item"><a class="page-link" :disabled="links.prev == null" @click="prevPage">&larr;</a></li>-->
                    <li
                        v-for="(page, index) in meta.last_page"
                        :key="index"
                        class="page-item"
                    >
                        <a class="page-link" @click="getPage(index + 1)">{{
                            index + 1
                        }}</a>
                    </li>
                    <!--                    <li class="page-item"><a class="page-link" :disabled="links.next == null"  @click="nextPage">&rarr;</a></li>-->
                    <li class="page-item">
                        <a class="page-link" @click="lastPage">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: '',
            description: '',
            state_id: 0,
            editing: false,
            items: [],
            checkDescription: '',
            checkState: '',
            selectState: [],
            links: {},
            meta: {},
            prevDisabled: false,
            nextDisabled: false
        }
    },
    created() {
        this.getAll()
    },
    methods: {
        getAll() {
            axios.get('/api/section').then(response => {
                this.items = response.data.data
                this.items.sort((a, b) => a.id - b.id)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
            axios.get('/api/state').then(res => {
                this.selectState = res.data.data
            })
        },
        save(e) {
            e.preventDefault()
            if (this.state_id == 0 || this.description == '') {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })

                if (this.state_id == 0) {
                    this.checkState = 'is-invalid'
                } else {
                    this.checkState = 'is-valid'
                }

                if (this.description == '') {
                    this.checkDescription = 'is-invalid'
                } else {
                    this.checkDescription = 'is-valid'
                }
            } else {
                this.checkDescription = ''
                this.checkState = ''

                axios
                    .post('/admin/section', {
                        description: this.description,
                        state_id: this.state_id
                    })
                    .then(res => {
                        toast.fire({
                            icon: 'success',
                            title: 'Sección creada exitosamente'
                        })

                        this.items.push(res.data)
                        this.description = ''
                        this.state_id = 0
                    })
                    .catch(error => console.log(error))
                    .finally(function() {
                        console.log('fin')
                    })
            }
        },
        edit(e) {
            e.preventDefault()
            const params = {
                description: this.description,
                state_id: this.state_id
            }
            axios
                .patch(`/admin/section/${this.id}`, params)
                .then(res => {
                    const index = this.items.findIndex(
                        section => section.id === res.data.id
                    )
                    toast.fire({
                        icon: 'success',
                        title: 'Sección editada exitosamente'
                    })
                    this.items[index].description = res.data.description
                    this.items[index].state_id = res.data.state_id
                    this.editing = false
                    this.description = ''
                    this.state_id = 0
                })
                .catch(error => console.log(error))
                .finally(function() {
                    console.log('evento terminado')
                })
        },
        setEdit(item) {
            this.editing = true
            this.description = item.description
            this.state_id = item.state_id.id || item.state_id
            this.id = item.id
        },
        destroy(item, index) {
            swal.fire({
                title: '¿Estás seguro?',
                text: 'El registro se eliminará permanentemente',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then(result => {
                if (result.value) {
                    axios
                        .delete(`/admin/section/${item.id}`)
                        .then(res => {
                            toast.fire({
                                icon: 'success',
                                title: 'Sección eliminada exitosamente'
                            })
                            this.getAll()
                        })
                        .catch(error => {
                            console.log(error)
                            toast.fire({
                                icon: 'error',
                                title: 'Ha ocurrido un error'
                            })
                        })
                }
            })
        },
        getPage(index) {
            axios.get('/api/section?page=' + index).then(response => {
                this.items = response.data.data
                console.log(response)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
        },
        firstPage() {
            axios.get('/api/section' + this.links.next).then(response => {
                this.items = response.data.data
                console.log(response)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
        },
        lastPage() {
            axios.get('/api/section' + this.links.last).then(response => {
                this.items = response.data.data
                console.log(response)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
        },
        prevPage() {
            axios.get('/api/section' + this.links.prev).then(response => {
                this.items = response.data.data
                console.log(response)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
        },
        nextPage() {
            axios.get('/api/section' + this.links.next).then(response => {
                this.items = response.data.data
                console.log(response)
                this.links = response.data.links
                this.links = response.data.links
                this.meta = response.data.meta
            })
        }
    }
}
</script>
