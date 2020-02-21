<template>
    <div>
        <!--    card para el registro de secciones-->
        <div class="card mt-2 card-secondary">
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
                                <label for="group_id">Grupo infinity</label>
                                <select id="group_id" class="custom-select">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectGroup" :value="item.id">{{ item.code }} - {{
                                        item.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="test_id">Prueba infinity</label>
                                <select v-model="test_id" id="test_id" class="custom-select">
                                    <option value="0">Seleccione:</option>
                                    <option v-for="item in selectTest" :value="item.id">{{ item.code }} - {{
                                        item.description }}
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

        <!--lista de secciones-->
        <div class="card mt-2">
            <div class="card-header">
                <h3 class="card-title">Supergrupo</h3><br>
                <div class="col-sm-4">
                    <div class="form-group">
                        <select v-model="supergroup_id" class="custom-select" @change="onChange($event)">
                            <option value="0">Seleccione:</option>
                            <option v-for="item in selectSupergroups" :value="item.id">{{ item.code }} - {{
                                item.description }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="tableID" class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Descripción Group</th>
                        <th scope="col">Descripción Test</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
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
                test_id: 0,
                supergroup_id: 0,
                items: [],
                selectState: [],
                selectTest: [],
                selectGroup: [],
                selectSupergroups: []
            }
        },
        created() {
            this.getSelect();
            this.setEvent();

        },
        methods: {
            setEvent() {
                $(function () {
                    $('#tableID').on('click', '.edit', function (event) {
                        event.preventDefault();

                        const id = $(this).attr('href')

                        this.editing = true
                        axios.get(`/api/infinityRelGroupTest/${id}`)
                            .then(res => {
                                console.log(res.data.infinity_group_id.id)
                                $('#group_id').val(res.data.infinity_group_id.id).trigger('change')

                                $('#test_id').val(res.data.infinity_test_id.id).trigger('change')
                            })
                    });


                    $('#group_id').on('change', function (event) {
                        console.log(event)
                    })

                    $('#group_id').select2();
                    $('#test_id').select2();
                })
            },
            onChange(event) {
                const id = event.target.value
                axios.get(`/admin/infinityRelGroupTest/${id}`)
                    .then(response => {
                        this.items = response.data

                        this.myTable(this.items);
                    })
            },
            getSelect() {
                axios.get('/api/state')
                    .then(res => {
                        this.selectState = res.data;
                    });
                axios.get('/api/infinitySupergroup')
                    .then(res => {
                        this.selectSupergroups = res.data;
                    });
                axios.get('/api/infinityGroup')
                    .then(res => {
                        this.selectGroup = res.data;
                    })
                axios.get('/api/infinityTest')
                    .then(res => {
                        console.log(res)
                        this.selectTest = res.data;
                    })
            },
            save(e) {
                e.preventDefault();
                if (this.validateInput()) {


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
                        description: this.description,
                        state_id: this.state_id
                    }

                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }

            },
            destroy(id) {
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
                        axios.delete(`/api/infinitySupergroup/${id}`)
                            .then(res => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Registro eliminado exitosamente'
                                });
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
            },
            myTable(data) {
                $(function () {
                    this.table = $('#tableID').DataTable({
                        data: data,
                        columns: [
                            {data: 'rel_id'},
                            {data: 'group_description'},
                            {data: 'test_description'},
                            {data: 'state_option'},
                            {data: 'options'}
                        ],
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
                if (this.state_id == 0) {

                    return false;
                } else {
                    return true;
                }
            }
        }
    }
</script>
