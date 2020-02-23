<template>
    <div>
        <div v-if="!contentReady">
            <div
                v-if="!containers.length"
                class="d-flex justify-content-center"
            >
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

                <div v-else class="card mt-2 card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ titleCard }}</h3>
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
                                        <input
                                            v-model="abbreviation"
                                            :class="checkAbbreviation"
                                            type="text"
                                            class="form-control"
                                            placeholder="Nombre corto"
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
                        <th scope="col">#</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Nombre corto</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                    <tbody v-for="container in setPaginate" :key="container.id">
                        <th scope="row">{{ container.id }}</th>
                        <td>{{ container.description }}</td>
                        <td>{{ container.abbreviation }}</td>
                        <td>
                            <span
                                :class="
                                    container.state.id === 1
                                        ? 'badge badge-success'
                                        : 'badge badge-danger'
                                "
                            >
                                {{ container.state.description }}</span
                            >
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(container)"
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
                                    @click.prevent="destroy(container)"
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
export default {
    data() {
        return {
            id: "",
            description: "",
            abbreviation: "",
            selectedState: 0,
            containers: [],
            checkDescription: "",
            checkAbbreviation: "",
            states: [],
            editing: false,
            titleCard: "",
            search_item: "",
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 5,
            disabledPrev: "disabled",
            disabledNext: ""
        };
    },
    created() {
        this.getContainers();
    },
    computed: {
        filterData() {
            const filtered = this.containers.filter(container => {
                return (
                    container.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase()) ||
                    container.abbreviation
                        .toLowerCase()
                        .match(this.search_item.toLowerCase())
                );
            });
            return filtered;
        },
        setPaginate() {
            return this.paginate(this.filterData);
        },
        from() {
            if (this.page === 1 && this.setPaginate.length == 0) {
                return 0;
            } else if (this.page === 1) {
                return 1;
            } else {
                return this.page * this.setPaginate.length - this.perPage;
            }
        },
        to() {
            if (this.page === 1) {
                return this.setPaginate.length;
            }
            return this.page * this.perPage;
        }
    },
    watch: {
        page() {
            this.isPrevDisabled();
            this.isNextDisabled();
        },
        filterData() {
            this.pages = [];
            this.page = 1;
            this.setPages();
        },
        pages() {
            if (this.pages.length <= 1) {
                this.disabledNext = "disabled";
            } else {
                this.disabledNext = "";
            }
        },
        perPage() {
            this.pages = [];
            this.page = 1;
            this.setPages();
        }
    },
    methods: {
        async getContainers() {
            try {
                const response = await fetch("/api/container");
                const json = await response.json();

                this.containers = json.containers;

                this.contentReady = true;
            } catch (e) {
                console.log(e.message);
            }
        },
        async getStates() {
            try {
                const response = await fetch("/api/state");
                const json = await response.json();

                this.states = this.parseSelect(json.states);
            } catch (e) {
                console.log(e);
            }
        },
        async save() {
            if (this.validateInput()) {
                let params = {
                    description: this.description,
                    abbreviation: this.abbreviation,
                    state_id: this.selectedState
                };
                try {
                    const response = await axios.post("/api/container", params);

                    if (response.status === 200) {
                        toast.fire({
                            icon: "success",
                            title: "Contenedor creado exitosamente"
                        });
                        this.containers.push(response.data.container);
                        this.resetForm();
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        },
        async edit() {
            let params = {
                description: this.description,
                abbreviation: this.abbreviation,
                state_id: this.selectedState
            };
            try {
                const response = await axios.patch(
                    `/api/container/${this.id}`,
                    params
                );

                if (response.status === 200) {
                    const index = this.containers.findIndex(
                        find => find.id === response.data.container.id
                    );

                    toast.fire({
                        icon: "success",
                        title: "Contenedor editado exitosamente"
                    });

                    this.containers.splice(index, 1, response.data.container);
                    this.resetForm();
                }
            } catch (e) {
                console.log(e);
            }
        },
        setEdit(container) {
            if (this.states.length === 0) {
                this.getStates();
            }
            this.editing = true;
            this.titleCard = "Editar registro";
            this.formContent = true;
            this.description = container.description;
            this.abbreviation = container.abbreviation;
            this.selectedState = container.state.id;
            this.id = container.id;
        },
        async destroy(container) {
            const confirmation = await swal.fire({
                title: "¿Estás seguro?",
                text: "El contenedor se eliminará permanentemente",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "No, cancelar",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar"
            });

            if (confirmation.value) {
                try {
                    const response = await axios.delete(
                        `/api/container/${container.id}`
                    );

                    if (response.status === 200) {
                        toast.fire({
                            icon: "success",
                            title: "Contenedor eliminado"
                        });
                        const index = this.containers.findIndex(
                            find => find.id === container.id
                        );
                        this.containers.splice(index, 1);
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        },
        cancelButton() {
            this.editing = false;
            this.resetForm();
        },
        resetForm() {
            this.description = "";
            this.abbreviation = "";
            this.selectedState = 0;
            this.id = "";
            this.formContent = false;
            this.editing = false;
            this.states = [];
        },
        validateInput() {
            if (this.selectedState === 0 || this.description === "") {
                if (this.description === "") {
                    this.checkDescription = "is-invalid";
                } else {
                    this.checkDescription = "is-valid";
                }

                if (this.abbreviation === "") {
                    this.checkAbbreviation = "is-invalid";
                } else {
                    this.checkAbbreviation = "is-valid";
                }

                return false;
            } else {
                return true;
            }
        },
        resetCheck() {
            this.checkDescription = "";
            this.checkAbbreviation = "";
        },
        currentPage(page) {
            this.page = page;
        },
        prevPage() {
            this.page--;
        },
        nextPage() {
            this.page++;
        },
        isPrevDisabled() {
            if (this.page !== 1) {
                this.disabledPrev = "";
            } else {
                this.disabledPrev = "disabled";
            }
        },
        isNextDisabled() {
            if (this.page < this.pages.length) {
                this.disabledNext = "";
            } else {
                this.disabledNext = "disabled";
            }
        },
        setPages() {
            let numberOfPages = [];
            numberOfPages = Math.ceil(this.filterData.length / this.perPage);
            for (let i = 1; i <= numberOfPages; i++) {
                this.pages.push(i);
            }
        },
        paginate(array) {
            let page = this.page;
            let perpage = this.perPage;
            let from = page * perpage - perpage;
            let to = page * perpage;

            return array.slice(from, to);
        },
        setFormContent() {
            this.titleCard = "Crear nuevo registro";
            this.formContent = true;
            this.selectedState = 1;
            this.getStates();
        },
        parseSelect: function(array) {
            const res = array.map(function(obj) {
                return {
                    id: obj.id,
                    text: obj.description
                };
            });
            return res;
        }
    }
};
</script>

<style scoped>
.show-select {
    font-size: 14px;
    padding: 1px;
    height: 35px;
    width: 50px;
    margin-left: 5px;
}

h5 {
    font-size: 15px;
}
</style>
