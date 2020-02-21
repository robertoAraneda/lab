<template>
    <div>
        <!--    card para el registro de estados-->
        <div v-if="!editing" class="card mt-2 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Crear un nuevo registro</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">

                                <label for="description">Description</label>
                                <input v-model="description" type="text" class="form-control" :class="checkDescription"
                                       id="description"
                                       placeholder="descripcion"
                                       name="description">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <button @click="save" type="submit" class="btn btn-primary btn-block ">
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
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="hidden" v-model="id">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input v-model="description" :class="checkDescription" type="text" class="form-control"
                                       placeholder="descripcion"
                                >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <button @click="edit" type="submit" class="btn btn-warning btn-block ">
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
            <div class="card-body table-responsive">
                <table id="tableSection" class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index ) in items" :key="index">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{item.description }}</td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info mx-2" href="#"><i class="fas fa-eye"></i></a>
                                <a @click="setEdit(item)" class="btn btn-warning mx-2" href="#"><i
                                    class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-danger mx-2" href="#" @click="destroy(item, index)"><i
                                    class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                editing: false,
                items: [],
                checkDescription: '',
                links: {},
                meta: {},
                prevDisabled: false,
                nextDisabled: false
            }
        },
        created() {
            this.getAll();
        },
        methods: {
            myTable(){
                $(function () {
                    $('#tableSection').DataTable({
                        language: {
                            processing: "Completado en curso...",
                            search: "Buscar&nbsp;:",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            infoEmpty: "Mostrando 0 a 0 de 0 registros",
                            infoFiltered: "(filtrado de _MAX_ registros totales)",
                            infoPostFix: "",
                            loadingRecords: "Cargando registros...",
                            zeroRecords: "No se encontraron registros para la b&uacute;squeda",
                            emptyTable: "No hay registros para mostrar",
                            paginate: {
                                first: "Primero",
                                previous: "Anterior",
                                next: "Siguiente",
                                last: "6Uacute;ltimo"
                            },
                            aria: {
                                sortAscending: ": orden ascentente",
                                sortDescending: ": orden descendente"
                            }
                        },
                        destroy: true
                    });
                }) ;
            },
            getAll() {
                axios.get('/api/state')
                    .then(response => {
                        this.items = response.data
                        // this.items.sort(((a, b) => a.id - b.id))
                        // this.links = response.data.links
                        // this.links = response.data.links
                        // this.meta = response.data.meta
                        this.myTable();
                    });
            },
            save(e) {
                e.preventDefault();
                if (this.description == '') {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });

                    if (this.description == '') {
                        this.checkDescription = 'is-invalid'
                    } else {
                        this.checkDescription = 'is-valid'
                    }
                } else {
                    this.checkDescription = ''

                    axios.post('/api/state', {
                        description: this.description,
                    })
                        .then(res => {
                            console.log(res)
                            toast.fire({
                                icon: 'success',
                                title: 'Registro creado exitosamente'
                            });

                            this.items.push(res.data);
                            this.description = ''

                        })
                        .catch(error => console.log(error))
                        .finally(function () {
                            console.log('fin');
                        })
                }
            },
            edit(e) {
                e.preventDefault();
                const params = {
                    description: this.description
                }
                axios.patch(`/api/state/${this.id}`, params)
                    .then(res => {
                        const index = this.items.findIndex(section => section.id === res.data.id)
                        toast.fire({
                            icon: 'success',
                            title: 'Registro editado exitosamente'
                        });
                        this.items[index].description = res.data.description
                        this.editing = false
                        this.description = ''
                    })
                    .catch(error => console.log(error))
                    .finally(function () {
                        console.log('evento terminado')
                    })
            },
            setEdit(item) {
                this.editing = true;
                this.description = item.description
                this.id = item.id
            },
            destroy(item, index) {
                swal.fire({
                    title: '¿Estás seguro?',
                    text: "El registro se eliminará permanentemente",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'No, cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/api/state/${item.id}`)
                            .then(res => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Registro eliminado exitosamente'
                                });
                                this.getAll();
                            })
                            .catch(error => {
                                console.log(error)
                                toast.fire({
                                    icon: 'error',
                                    title: 'Ha ocurrido un error'
                                });
                            })
                    }
                })
            }
        }
    }
</script>

