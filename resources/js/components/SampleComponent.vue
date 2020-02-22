<template>
    <div>
        <div v-if="!contentReady">
            <div v-if="!samples.length" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div
                    v-if="!states.length"
                    class="d-flex justify-content-center"
                >
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

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
                                    <input type="hidden" v-model="id" />
                                    <div class="form-group">
                                        <input
                                            v-model="description"
                                            :class="checkDescription"
                                            type="text"
                                            class="form-control"
                                            placeholder="Descripción"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select2
                                            name="ESTADO"
                                            :options="states"
                                            v-model="selectedState"
                                        ></select2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <button
                                v-if="!editing"
                                @click.prevent="save"
                                class="btn btn-default float-right ml-2"
                            >
                                Guardar
                            </button>
                            <button
                                v-if="editing"
                                @click.prevent="edit"
                                class="btn btn-warning float-right ml-2"
                            >
                                Editar
                            </button>
                            <button
                                @click.prevent="cancelButton"
                                class="btn btn-danger float-right "
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header bg-secondary">
                <div class="card-tools">
                    <button
                        v-if="!editing"
                        @click="setFormContent"
                        type="button"
                        class="btn btn-success float-right"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="CREAR REGISTRO"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-header">
                <div
                    class="input-group input-group-sm card-title"
                    style="width: 250px;"
                >
                    <h5 class="mt-2">Mostrar</h5>
                    <div class="input-group-append">
                        <select
                            class="card-title form-control show-select"
                            v-model="perPage"
                        >
                            <option value="20">20</option>
                            <option value="10">10</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <h5 class="mt-2 ml-2">registros</h5>
                    </div>
                </div>
                <div class="card-tools">
                    <div class="input-group mb-2 mt-1">
                        <input
                            type="text"
                            v-model="search_item"
                            class="form-control float-right"
                            placeholder="Buscar"
                        />
                        <div class="input-group-append">
                            <span class="input-group-text"
                                ><i class="fas fa-search"></i
                            ></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                    <tbody v-for="sample in setPaginate" :key="sample.id">
                        <th scope="row">{{ sample.id }}</th>
                        <td>{{ sample.description }}</td>
                        <td>
                            <span
                                :class="
                                    item.state.id === 1
                                        ? 'badge badge-success'
                                        : 'badge badge-danger'
                                "
                            >
                                {{ item.state.description }}</span
                            >
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(workarea)"
                                    class="btn btn-warning mx-1"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="EDITAR REGISTRO"
                                >
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button
                                    class="btn btn-danger mx-1"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="ELIMINAR REGISTRO"
                                    @click.prevent="destroy(workarea)"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center bg-white">
                <div class="float-right">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" :class="disabledPrev">
                                <button @click="prevPage" class="page-link">
                                    Anterior
                                </button>
                            </li>
                            <li
                                v-for="pageNumber in pages.slice(
                                    page - 1,
                                    page + 4
                                )"
                                :key="pageNumber"
                                class="page-item"
                            >
                                <button
                                    @click="currentPage(pageNumber)"
                                    class="page-link"
                                >
                                    {{ pageNumber }}
                                </button>
                            </li>
                            <li class="page-item" :class="disabledNext">
                                <button @click="nextPage" class="page-link">
                                    Siguiente
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="float-left mt-2">
                    <h5>
                        Mostrando {{ from }} a {{ to }} de
                        {{ setPaginate.length }} registros
                    </h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import datatables from "datatables";

export default {
    data() {
        return {
            id: "",
            description: "",
            state_id: 0,
            editing: false,
            items: [],
            checkDescription: "",
            checkState: "",
            selectState: [],
            table: []
        };
    },
    created() {
        this.getAll();
        this.getSelect();
    },
    methods: {
        getAll() {
            axios.get("/api/sample").then(response => {
                this.items = response.data;
                this.myTable();
                this.getData();
            });
        },
        getSelect() {
            axios.get("/api/state").then(res => {
                this.selectState = res.data;
            });
        },
        save(e) {
            e.preventDefault();
            if (this.validateInput()) {
                let params = {
                    description: this.description,
                    state_id: this.state_id
                };
                console.log(params);
                axios
                    .post("/api/sample", params)
                    .then(res => {
                        console.log(res);
                        toast.fire({
                            icon: "success",
                            title: "Registro creado exitosamente"
                        });

                        this.items.push(res.data);

                        this.resetForm();
                        this.resetCheck();
                    })
                    .catch(error => console.log(error))
                    .finally(function() {
                        console.log("fin");
                    });
            } else {
                toast.fire({
                    icon: "error",
                    title: "Complete los datos solicitados"
                });
            }
        },
        edit(e) {
            e.preventDefault();
            const params = {
                description: this.description,
                state_id: this.state_id
            };

            console.log(params);
            axios
                .put(`/api/sample/${this.id}`, params)
                .then(res => {
                    const index = this.items.findIndex(
                        find => find.id === res.data.id
                    );
                    toast.fire({
                        icon: "success",
                        title: "Registro editado exitosamente"
                    });
                    this.items[index].description = res.data.description;
                    this.items[index].state_id = res.data.state_id;
                    this.editing = false;
                    this.resetForm();
                })
                .catch(error => console.log(error))
                .finally(function() {
                    console.log("evento terminado");
                });
        },
        setEdit(item) {
            this.editing = true;
            this.description = item.description;
            this.state_id = item.state_id.id || item.state_id;
            this.id = item.id;
        },
        destroy(item, index) {
            swal.fire({
                title: "¿Estás seguro?",
                text: "El registro se eliminará permanentemente",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "No, cancelar",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete(`/api/sample/${item.id}`)
                        .then(res => {
                            toast.fire({
                                icon: "success",
                                title: "Registro eliminado exitosamente"
                            });
                            this.items.splice(index, 1);
                            // this.getAll();
                        })
                        .catch(error => {
                            console.log(error);
                            toast.fire({
                                icon: "error",
                                title: "Ha ocurrido un error"
                            });
                        });
                }
            });
        },
        resetForm() {
            this.description = "";
            this.state_id = 0;
        },
        myTable() {
            $(function() {
                this.table = $("#tableID").DataTable({
                    language: {
                        processing: "Completado en curso...",
                        search: "Buscar&nbsp;:",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 a 0 de 0 registros",
                        infoFiltered: "(filtrado de _MAX_ registros totales)",
                        infoPostFix: "",
                        loadingRecords: "Cargando registros...",
                        zeroRecords:
                            "No se encontraron registros para la b&uacute;squeda",
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
            if (this.state_id == 0 || this.description == "") {
                if (this.state_id == 0) {
                    this.checkState = "is-invalid";
                } else {
                    this.checkState = "is-valid";
                }

                if (this.section_id == 0) {
                    this.checkSection = "is-invalid";
                } else {
                    this.checkSection = "is-valid";
                }
                return false;
            } else {
                return true;
            }
        },
        resetCheck() {
            this.checkDescription = "";
            this.checkState = "";
        },
        refreshTable() {
            this.getAll();
        },
        getData() {
            this.items.forEach(item => {
                var dataPush = [
                    item.id,
                    item.description,
                    item.state_id.description
                ];
                this.table.push(dataPush);
            });

            console.log(this.table);
        }
    }
};
</script>
