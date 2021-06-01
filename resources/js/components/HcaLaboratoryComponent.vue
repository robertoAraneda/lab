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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type_test_save">Tipo Prueba</label>
                                <select
                                    v-model="editedItem.type_test"
                                    id="type_test_save"
                                    class="custom-select"
                                    :class="checkTypeTest"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option value="Perfiles">Perfiles</option>
                                    <option value="Prueba">Prueba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="description_save"
                                    >Description</label
                                >
                                <input
                                    v-model="editedItem.description"
                                    id="description_save"
                                    :class="checkDescription"
                                    type="text"
                                    class="form-control"
                                    placeholder="descripcion"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location_save">Localización</label>
                                <select
                                    v-model="editedItem.location"
                                    id="location_save"
                                    class="custom-select"
                                    :class="checkLocationLab"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option value="General Lab y Emergency Lab"
                                        >General Lab y Emergency Lab</option
                                    >
                                    <option value="Microbiology"
                                        >Microbiology</option
                                    >
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="internal_code_save"
                                    >Código interno</label
                                >
                                <input
                                    v-model="editedItem.internal_code"
                                    id="internal_code_save"
                                    :class="checkInternalCode"
                                    type="text"
                                    class="form-control"
                                    placeholder="Código interno"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="external_code_save"
                                    >Description</label
                                >
                                <input
                                    v-model="editedItem.external_code"
                                    id="external_code_save"
                                    :class="checkExternalCode"
                                    type="text"
                                    class="form-control"
                                    placeholder="Código externo"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="state_id_save">Estado</label>
                                <select
                                    v-model="editedItem.state_id"
                                    id="state_id_save"
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
                    </div>
                    <button
                        @click="save"
                        type="submit"
                        class="btn btn-default float-right "
                    >
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type_test_save">Tipo Prueba</label>
                                <select
                                    v-model="editedItem.type_test"
                                    id="type_test_edit"
                                    class="custom-select"
                                    :class="checkTypeTest"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option value="Perfiles">Perfiles</option>
                                    <option value="Prueba">Prueba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="description_save"
                                    >Description</label
                                >
                                <input
                                    v-model="editedItem.description"
                                    id="description_edit"
                                    :class="checkDescription"
                                    type="text"
                                    class="form-control"
                                    placeholder="descripcion"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location_save">Localización</label>
                                <select
                                    v-model="editedItem.location"
                                    id="location_edit"
                                    class="custom-select"
                                    :class="checkLocationLab"
                                >
                                    <option value="0">Seleccione:</option>
                                    <option value="General Lab y Emergency Lab"
                                        >General Lab y Emergency Lab</option
                                    >
                                    <option value="Microbiology"
                                        >Microbiology</option
                                    >
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="internal_code_save"
                                    >Código interno</label
                                >
                                <input
                                    v-model="editedItem.internal_code"
                                    id="internal_code_edit"
                                    :class="checkInternalCode"
                                    type="text"
                                    class="form-control"
                                    placeholder="Código interno"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="external_code_save"
                                    >Description</label
                                >
                                <input
                                    v-model="editedItem.external_code"
                                    id="external_code_edit"
                                    :class="checkExternalCode"
                                    type="text"
                                    class="form-control"
                                    placeholder="Código externo"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="state_id_save">Estado</label>
                                <select
                                    v-model="editedItem.state_id"
                                    id="state_id_edit"
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
                    </div>
                    <button
                        @click="edit"
                        type="submit"
                        class="btn btn-warning float-right "
                    >
                        Editar
                    </button>
                </div>
            </form>
        </div>

        <v-data-table
            :headers="headers"
            :items="items"
            sort-by="description"
            class="elevation-1"
            :search="search"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Lista de códigos HCA</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Buscar"
                        hide-details
                        outlined
                        dense
                    ></v-text-field>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <p>No existen elementos</p>
            </template>
        </v-data-table>
        <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
                <v-card-title class="text-h5"
                    >¿Estás seguro de eliminar este registro?</v-card-title
                >
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete"
                        >Cancelar</v-btn
                    >
                    <v-btn
                        dark
                        color="blue darken-1"
                        depressed
                        @click="deleteItemConfirm"
                        >Aceptar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- 
        <div class="card mt-2">
            <div class="card-header">
                <h3 class="card-title">Lista general</h3>
                <button
                    @click="refreshTable"
                    type="submit"
                    class="btn btn-warning float-right"
                >
                    <i class="fas fa-sync"></i>
                </button>
            </div>

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
                        <tr v-for="(item, index) in items" :key="item.id">
                            <th scope="row">{{ item.id }}</th>
                            <td>{{ item.type_test }}</td>
                            <td>{{ item.description }}</td>
                            <td>{{ item.internal_code }}</td>
                            <td>{{ item.external_code }}</td>
                            <td>
                                <span
                                    :class="
                                        item.state_id.id === 1
                                            ? 'badge badge-success'
                                            : 'badge badge-danger'
                                    "
                                >
                                    {{ item.state_id.description }}</span
                                >
                            </td>

                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-info mx-1" href="#"
                                        ><i class="fas fa-eye"></i
                                    ></a>
                                    <a
                                        @click="setEdit(item)"
                                        class="btn btn-warning mx-1"
                                        href="#"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Editar"
                                        ><i class="fas fa-pencil-alt"></i
                                    ></a>
                                    <a
                                        class="btn btn-danger mx-1"
                                        href="#"
                                        @click="destroy(item, index)"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Eliminar"
                                        ><i class="fas fa-trash"></i
                                    ></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
    </div>
</template>

<script>
import datatables from 'datatables'

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
            table: [],
            dialog: false,
            dialogDelete: false,
            search: '',
            headers: [
                {
                    text: 'Tipo de prueba',
                    align: 'start',
                    sortable: false,
                    value: 'type_test'
                },
                { text: 'Nombre', value: 'description' },
                { text: 'Código interno', value: 'internal_code' },
                { text: 'Código externo', value: 'external_code' },
                { text: 'Estado', value: 'state.description' },
                { text: 'Actions', value: 'actions', sortable: false }
            ],
            editedIndex: -1,
            editedItem: {
                id: '',
                type_test: 0,
                location: 0,
                internal_code: '',
                external_code: '',
                description: '',
                state_id: 0
            },
            defaultItem: {
                id: '',
                type_test: 0,
                location: 0,
                internal_code: '',
                external_code: '',
                description: '',
                state_id: 0
            }
        }
    },
    created() {
        this.getAll()
        this.getSelect()
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        }
    },
    methods: {
        getAll() {
            axios.get('/api/hcaLaboratory').then(response => {
                this.items = response.data.hcaLaboratories
                console.log(this.items)
                //this.myTable()
                //this.getData()
            })
        },
        getSelect() {
            axios.get('/api/state').then(res => {
                console.log(res)
                this.selectState = res.data.states
            })
        },
        save(e) {
            e.preventDefault()
            if (this.validateInput()) {
                let params = {
                    type_test_id: this.editedItem.type_test,
                    location_lab: this.editedItem.location,
                    internal_code: this.editedItem.internal_code,
                    external_code: this.editedItem.external_code,
                    description: this.editedItem.description,
                    state_id: this.editedItem.state_id
                }
                console.log(params)
                axios
                    .post('/api/hcaLaboratory', params)
                    .then(res => {
                        console.log(res)
                        toast.fire({
                            icon: 'success',
                            title: 'Registro creado exitosamente'
                        })

                        this.items.push(res.data.hcaLaboratory)

                        this.resetForm()
                        this.resetCheck()
                        // this.refreshTable();
                    })
                    .catch(error => console.log(error))
                    .finally(function() {
                        console.log('fin')
                    })
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })
            }
        },
        edit(e) {
            e.preventDefault()

            if (this.validateInput()) {
                const params = {
                    type_test_id: this.editedItem.type_test,
                    location_lab: this.editedItem.location,
                    internal_code: this.editedItem.internal_code,
                    external_code: this.editedItem.external_code,
                    description: this.editedItem.description,
                    state_id: this.editedItem.state_id
                }
                axios
                    .put(`/api/hcaLaboratory/${this.editedItem.id}`, params)
                    .then(res => {
                        console.log('res', res)
                        Object.assign(
                            this.items[this.editedIndex],
                            res.data.hcaLaboratory
                        )
                        toast.fire({
                            icon: 'success',
                            title: 'Registro editado exitosamente'
                        })

                        this.editing = false
                        this.resetForm()
                        this.resetCheck()
                    })
                    .catch(error => console.log(error))
                    .finally(function() {
                        console.log('evento terminado')
                    })
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })
            }
        },
        setEdit(item) {
            this.editing = true
            this.type_test_id = item.type_test_id
            this.location_lab = item.location_lab
            this.internal_code = item.internal_code
            this.external_code = item.external_code
            this.description = item.description
            this.this.state_id = item.state.id || item.state_id
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
                        .delete(`/api/hcaLaboratory/${item.id}`)
                        .then(res => {
                            toast.fire({
                                icon: 'success',
                                title: 'Registro eliminado exitosamente'
                            })
                            this.items.splice(index, 1)
                            // this.getAll();
                            //this.refreshTable();
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
        resetForm() {
            this.editedItem.type_test = 0
            this.editedItem.location = 0
            this.editedItem.internal_code = ''
            this.editedItem.external_code = ''
            this.editedItem.description = ''
            this.editedItem.state_id = 0
        },
        myTable() {
            $(function() {
                this.table = $('#tableID').DataTable({
                    language: {
                        processing: 'Completado en curso...',
                        search: 'Buscar&nbsp;:',
                        lengthMenu: 'Mostrar _MENU_ registros',
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                        infoFiltered: '(filtrado de _MAX_ registros totales)',
                        infoPostFix: '',
                        loadingRecords: 'Cargando registros...',
                        zeroRecords:
                            'No se encontraron registros para la b&uacute;squeda',
                        emptyTable: 'No hay registros para mostrar',
                        paginate: {
                            first: 'Primero',
                            previous: 'Anterior',
                            next: 'Siguiente',
                            last: '&Uacute;ltimo'
                        },
                        aria: {
                            sortAscending: ': orden ascentente',
                            sortDescending: ': orden descendente'
                        }
                    },
                    destroy: true
                })
            })
        },
        validateInput() {
            if (
                this.editedItem.state_id == 0 ||
                this.editedItem.description == '' ||
                this.editedItem.internal_code == ''
            ) {
                if (this.editedItem.state_id == 0) {
                    this.checkState = 'is-invalid'
                } else {
                    this.checkState = 'is-valid'
                }

                if (this.editedItem.description == '') {
                    this.checkDescription = 'is-invalid'
                } else {
                    this.checkDescription = 'is-valid'
                }

                if (this.editedItem.internal_code == '') {
                    this.checkCode = 'is-invalid'
                } else {
                    this.checkCode = 'is-valid'
                }
                return false
            } else {
                return true
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
                var dataPush = [
                    item.id,
                    item.description,
                    item.state_id.description
                ]
                this.table.push(dataPush)
            })

            console.log('table', this.table)
        },
        addSelectStyle() {
            $(function() {
                $('.select2').select2()
            })
        },
        editItem(item) {
            this.editedIndex = this.items.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.editing = true
            //this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.items.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm() {
            axios
                .delete(`/api/hcaLaboratory/${this.editedItem.id}`)
                .then(res => {
                    toast.fire({
                        icon: 'success',
                        title: 'Registro eliminado exitosamente'
                    })

                    this.items.splice(this.editedIndex, 1)
                    this.closeDelete()
                    // this.getAll();
                    //this.refreshTable();
                })
                .catch(error => {
                    console.log(error)
                    toast.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error'
                    })
                })
        },

        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        }

        /*       save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      }, */
    }
}
</script>
