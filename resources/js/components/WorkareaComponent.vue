<template>
    <div>
        <!--    card para el registro de secciones-->
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
                        <div class="col-sm-3">
                            <input type="hidden" v-model="id">
                            <div class="form-group">
                                <label for="description_save">Description</label>
                                <input v-model="description" id="description_save" :class="checkDescription" type="text"
                                       class="form-control"
                                       placeholder="descripcion"
                                >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="section_id_save">Sección</label>
                                <select v-model="section_id" id="section_id_save" class="custom-select"
                                        :class="checkSection">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectSection" :value="item.id">{{ item.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="chief_user_id_save">Encargado de área</label>
                                <select v-model="chief_user_id" id="chief_user_id_save" class="custom-select"
                                        :class="checkChiefUser">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectUser" :value="item.id">{{ item.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="state_id_save">Estado</label>
                                <select v-model="state_id" id="state_id_save" class="custom-select" :class="checkState">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="state in selectState" :value="state.id">{{ state.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                            <button @click="save" type="submit" class="btn btn-primary float-right ">
                                Guardar
                            </button>

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
                        <div class="col-sm-3">
                            <input type="hidden" v-model="id">
                            <div class="form-group">
                                <label for="description_edit">Description</label>
                                <input v-model="description" id="description_edit" :class="checkDescription" type="text"
                                       class="form-control"
                                       placeholder="descripcion"
                                >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="section_id_edit">Sección</label>
                                <select v-model="section_id" id="section_id_edit" class="custom-select"
                                        :class="checkSection">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectSection" :value="item.id">{{ item.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="chief_user_id_edit">Encargado de área</label>
                                <select v-model="chief_user_id" id="chief_user_id_edit" class="custom-select"
                                        :class="checkChiefUser">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectUser" :value="item.id">{{ item.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="state_id_edit">Estado</label>
                                <select v-model="state_id" id="state_id_edit" class="custom-select" :class="checkState">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="state in selectState" :value="state.id">{{ state.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 float-right">
                            <label>&nbsp;</label>
                            <button @click="edit" type="submit" class="btn btn-warning btn-block ">
                                Guardar
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
                <table id="tableID" class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Sección</th>
                        <th scope="col">Encargado</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index ) in items" :key="index">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{ item.description }}</td>
                        <td>{{ item.section_id.description }}</td>
                        <td>{{ item.chief_user_id.name }}</td>
                        <td><span
                            :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.description }}</span>
                        </td>

                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info mx-1" href="#"><i class="fas fa-eye"></i></a>
                                <a @click="setEdit(item)" class="btn btn-warning mx-1" href="#"><i
                                    class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-danger mx-1" href="#" @click="destroy(item, index)"><i
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
    import datatables from 'datatables';

    export default {
        data() {
            return {
                id: '',
                description: '',
                state_id: 0,
                section_id: 0,
                chief_user_id: 0,
                editing: false,
                items: [],
                checkDescription: '',
                checkState: '',
                checkSection: '',
                checkChiefUser: '',
                selectState: [],
                selectUser: [],
                selectSection: [],
                table:''
            }
        },
        created() {
            this.getAll();
            this.getSelect();
        },
        methods: {
            getAll() {
                axios.get('/api/workarea')
                    .then(response => {
                        this.items = response.data
                        this.myTable();
                    })
            },
            getSelect(){
                axios.get('/api/state')
                    .then(res => {
                        this.selectState = res.data;
                    });
                axios.get('/api/user')
                    .then(res => {
                        this.selectUser = res.data;
                    })
                axios.get('/api/section')
                    .then(res => {
                        this.selectSection = res.data;
                    })
            },
            save(e) {
                e.preventDefault();
                if (this.validateInput()) {
                    let params = {
                        description: this.description,
                        state_id: this.state_id,
                        section_id: this.section_id,
                        chief_user_id: this.chief_user_id
                    }
                    console.log(params)
                    axios.post('/api/workarea', params)
                        .then(res => {
                            console.log(res)
                            toast.fire({
                                icon: 'success',
                                title: 'Registro creado exitosamente'
                            });

                            this.items.push(res.data);

                            this.resetForm();
                            this.resetCheck();

                        })
                        .catch(error => console.log(error))
                        .finally(function () {
                            console.log('fin');
                        })

                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }
            },
            edit(e) {
                e.preventDefault();
                const params = {
                    description: this.description,
                    state_id: this.state_id,
                    section_id: this.section_id,
                    chief_user_id: this.chief_user_id

                }

                console.log(params)
                axios.put(`/api/workarea/${this.id}`, params)
                    .then(res => {
                        const index = this.items.findIndex(section => section.id === res.data.id)
                        toast.fire({
                            icon: 'success',
                            title: 'Registro editado exitosamente'
                        });
                        this.items[index].description = res.data.description
                        this.items[index].state_id = res.data.state_id
                        this.items[index].section_id = res.data.section_id
                        this.items[index].chief_user_id = res.data.chief_user_id
                        this.editing = false
                        this.resetForm();
                    })
                    .catch(error => console.log(error))
                    .finally(function () {
                        console.log('evento terminado')
                    })
            },
            setEdit(item) {
                this.editing = true;
                this.description = item.description
                this.state_id = item.state_id.id || item.state_id
                this.section_id = item.section_id.id || item.section_id
                this.chief_user_id = item.chief_user_id.id || item.chief_user_id
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
                        axios.delete(`/api/workarea/${item.id}`)
                            .then(res => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Registro eliminado exitosamente'
                                });
                                this.items.splice(index, 1);
                               // this.getAll();
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
            },
            resetForm() {
                this.description = ''
                this.state_id = 0
                this.section_id = 0
                this.chief_user_id = 0
            },
            myTable() {
                $(function () {
                    this.table = $('#tableID').DataTable({
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
                                last: "&Uacute;ltimo"
                            },
                            aria: {
                                sortAscending: ": orden ascentente",
                                sortDescending: ": orden descendente"
                            }
                        },
                        destroy: true
                    });
                });
            },
            validateInput(){
                if (this.state_id == 0 || this.description == '' || this.section_id == 0 || this.chief_user_id == 0) {

                    if (this.state_id == 0) {
                        this.checkState = 'is-invalid'
                    } else {
                        this.checkState = 'is-valid'
                    }

                    if (this.section_id == 0) {
                        this.checkSection = 'is-invalid'
                    } else {
                        this.checkSection = 'is-valid'
                    }

                    if (this.chief_user_id == 0) {
                        this.checkChiefUser = 'is-invalid'
                    } else {
                        this.checkChiefUser = 'is-valid'
                    }

                    if (this.description == '') {
                        this.checkDescription = 'is-invalid'

                    } else {
                        this.checkDescription = 'is-valid'
                    }
                    return false;
                } else {
                    return true;
                }
            },
            resetCheck(){
                this.checkDescription = ''
                this.checkState = ''
                this.checkSection = ''
                this.checkChiefUser = ''
            }
        }
    }
</script>
