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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type_test_save">Tipo Prueba</label>
                                <select v-model="type_test_id" id="type_test_save" class="custom-select select2" :class="checkTypeTest">
                                    <option value="0">Seleccione:</option>
                                    <option value="Perfiles">Perfiles</option>
                                    <option value="Prueba">Prueba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="description_save">Description</label>
                                <input v-model="description" id="description_save" :class="checkDescription" type="text"
                                       class="form-control"
                                       placeholder="descripcion"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location_save">Localización</label>
                                <select v-model="location_lab" id="location_save" class="custom-select" :class="checkLocationLab">
                                    <option value="0">Seleccione:</option>
                                    <option value="General Lab y Emergency Lab">General Lab y Emergency Lab</option>
                                    <option value="Microbiology">Microbiology</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="internal_code_save">Código interno</label>
                                <input v-model="internal_code" id="internal_code_save" :class="checkInternalCode" type="text"
                                       class="form-control"
                                       placeholder="Código interno"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="external_code_save">Description</label>
                                <input v-model="external_code" id="external_code_save" :class="checkExternalCode" type="text"
                                       class="form-control"
                                       placeholder="Código externo"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
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
                    <button @click="save" type="submit" class="btn btn-default float-right ">
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type_test_save">Tipo Prueba</label>
                                <select v-model="type_test_id" id="type_test_edit" class="custom-select" :class="checkTypeTest">
                                    <option value="0">Seleccione:</option>
                                    <option value="Perfiles<">Perfiles</option>
                                    <option value="Prueba">Prueba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="description_save">Description</label>
                                <input v-model="description" id="description_edit" :class="checkDescription" type="text"
                                       class="form-control"
                                       placeholder="descripcion"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location_save">Localización</label>
                                <select v-model="location_lab" id="location_edit" class="custom-select" :class="checkLocationLab">
                                    <option value="0">Seleccione:</option>
                                    <option value="General Lab y Emergency Lab">General Lab y Emergency Lab</option>
                                    <option value="Microbiology">Microbiology</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="internal_code_save">Código interno</label>
                                <input v-model="internal_code" id="internal_code_edit" :class="checkInternalCode" type="text"
                                       class="form-control"
                                       placeholder="Código interno"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="external_code_save">Description</label>
                                <input v-model="external_code" id="external_code_edit" :class="checkExternalCode" type="text"
                                       class="form-control"
                                       placeholder="Código externo"
                                >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="state_id_save">Estado</label>
                                <select v-model="state_id" id="state_id_edit" class="custom-select" :class="checkState">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="state in selectState" :value="state.id">{{ state.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button @click="edit" type="submit" class="btn btn-warning float-right ">
                        Editar
                    </button>

                </div>
            </form>
        </div>

        <!--lista de secciones-->
        <div class="card mt-2">
            <div class="card-header">
                <h3 class="card-title">Lista general</h3>
                <button @click="refreshTable" type="submit" class="btn btn-warning float-right">
                    <i class="fas fa-sync"></i>
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="tableID" class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tipo prueba</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Código interno</th>
                        <th scope="col">Código externo</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index ) in items" :key="item.id">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{ item.type_test }}</td>
                        <td>{{ item.description }}</td>
                        <td>{{ item.internal_code }}</td>
                        <td>{{ item.external_code }}</td>
                        <td><span
                            :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.description }}</span>
                        </td>

                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info mx-1" href="#"><i class="fas fa-eye"></i></a>
                                <a @click="setEdit(item)" class="btn btn-warning mx-1" href="#" data-toggle="tooltip"
                                   data-placement="bottom" title="Editar"><i
                                    class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-danger mx-1" href="#" @click="destroy(item, index)"
                                   data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i
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
                type_test_id: '',
                location_lab: '',
                internal_code: '',
                external_code: '',
                description: '',
                state_id: 0,
                editing: false,
                items: [],
                checkDescription: '',
                checkTypeTest: '',
                checkInternalCode: '',
                checkExternalCode: '',
                checkLocationLab: '',
                checkState: '',
                selectState: [],
                table: []
            }
        },
        created() {
            this.getAll();
            this.getSelect();

        },
        methods: {
            getAll() {
                axios.get('/api/hcaLaboratory')
                    .then(response => {
                        this.items = response.data
                        console.log(this.items)
                        this.myTable();
                        this.getData();
                    })
            },
            getSelect() {
                axios.get('/api/state')
                    .then(res => {
                        this.selectState = res.data;
                    });
            },
            save(e) {
                e.preventDefault();
                if (this.validateInput()) {

                    let params = {
                        type_test_id: this.type_test_id,
                        location_lab: this.location_lab,
                        internal_code: this.internal_code,
                        external_code: this.external_code,
                        description: this.description,
                        state_id: this.state_id
                    }
                    console.log(params)
                    axios.post('/api/hcaLaboratory', params)
                        .then(res => {
                            console.log(res)
                            toast.fire({
                                icon: 'success',
                                title: 'Registro creado exitosamente'
                            });

                            this.items.push(res.data);

                            this.resetForm();
                            this.resetCheck();
                            // this.refreshTable();


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

                if (this.validateInput()) {
                    const params = {
                        type_test_id: this.type_test_id,
                        location_lab: this.location_lab,
                        internal_code: this.internal_code,
                        external_code: this.external_code,
                        description: this.description,
                        state_id: this.state_id
                    }

                    console.log(params)
                    axios.put(`/api/hcaLaboratory/${this.id}`, params)
                        .then(res => {
                            const index = this.items.findIndex(find => find.id === res.data.id)
                            toast.fire({
                                icon: 'success',
                                title: 'Registro editado exitosamente'
                            });

                            this.items[index].type_test_id = res.data.type_test_id
                            this.items[index].location_lab = res.data.location_lab
                            this.items[index].internal_code = res.data.internal_code
                            this.items[index].external_code = res.data.external_code
                            this.items[index].description = res.data.description
                            this.items[index].state_id = res.data.state_id
                            this.editing = false
                            this.resetForm();
                            this.resetCheck();
                        })
                        .catch(error => console.log(error))
                        .finally(function () {
                            console.log('evento terminado')
                        })
                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }

            },
            setEdit(item) {
                this.editing = true;
                this.type_test_id = item.type_test_id
                this.location_lab = item.location_lab
                this.internal_code = item.internal_code
                this.external_code = item.external_code
                this.description = item.description
                this.state_id = item.state_id.id || item.state_id
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
                        axios.delete(`/api/hcaLaboratory/${item.id}`)
                            .then(res => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Registro eliminado exitosamente'
                                });
                                this.items.splice(index, 1);
                                // this.getAll();
                                //this.refreshTable();
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
                this.type_test_id = 0
                this.location_lab = 0
                this.internal_code = ''
                this.external_code = ''
                this.description = ''
                this.state_id = 0
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
            validateInput() {
                if (this.state_id == 0 || this.description == '' || this.code == '') {

                    if (this.state_id == 0) {
                        this.checkState = 'is-invalid'
                    } else {
                        this.checkState = 'is-valid'
                    }

                    if (this.description == "") {
                        this.checkDescription = 'is-invalid'
                    } else {
                        this.checkDescription = 'is-valid'
                    }

                    if (this.code == "") {
                        this.checkCode = 'is-invalid'
                    } else {
                        this.checkCode = 'is-valid'
                    }
                    return false;
                } else {
                    return true;
                }
            },
            resetCheck() {
                this.checkCode = ''
                this.checkDescription = ''
                this.checkState = ''
            },
            refreshTable() {
                location.reload()
            },
            getData() {
                this.items.forEach(item => {
                    var dataPush = [item.id, item.description, item.state_id.description]
                    this.table.push(dataPush)
                })

                console.log(this.table)
            },
            addSelectStyle(){
                $(function () {
                    $('.select2').select2();
                })

            }
        }
    }
</script>

