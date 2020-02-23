<template>
    <div>
        <div v-if="!contentReady">
            <div
                v-if="!mainAnalytes.length"
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
                                <div class="col-sm-8">
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea
                                            :class="checkInformation"
                                            v-model="information"
                                            class="form-control"
                                            rows="5"
                                            placeholder="Escriba una breve reseña sobre la utilidad de la prestación..."
                                        ></textarea>
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
                        <th scope="col">Description</th>
                        <th scope="col">Información</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                    <tbody
                        v-for="mainAnalyte in setPaginate"
                        :key="mainAnalyte.id"
                    >
                        <th scope="row">{{ mainAnalyte.id }}</th>
                        <td>{{ mainAnalyte.description }}</td>
                        <td v-if="mainAnalyte.information == null">
                            {{ mainAnalyte.information }}
                        </td>
                        <td v-else        data-toggle="tooltip"
                                    data-placement="top"
                                    :title=mainAnalyte.information>
                            {{ mainAnalyte.information.substr(0, 40) + "..." }}
                        </td>
                        <td>
                            <span
                                :class="
                                    mainAnalyte.state.id === 1
                                        ? 'badge badge-success'
                                        : 'badge badge-danger'
                                "
                            >
                                {{ mainAnalyte.state.description }}</span
                            >
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(mainAnalyte)"
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
                                    @click.prevent="destroy(mainAnalyte)"
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
            selectedState: 0,
            mainAnalytes: [],
            checkDescription: "",
            information: "",
            checkInformation: "",
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
        this.getMainAnalytes();
    },
    computed: {
        filterData() {
            const filtered = this.mainAnalytes.filter(mainAnalyte => {
                return mainAnalyte.description
                    .toLowerCase()
                    .match(this.search_item.toLowerCase());
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
        async getMainAnalytes() {
            try {
                const response = await fetch("/api/mainAnalyte");
                const json = await response.json();

                this.mainAnalytes = json.mainAnalytes;

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
                    information: this.information,
                    state_id: this.selectedState
                };
                try {
                    const response = await axios.post(
                        "/api/mainAnalyte",
                        params
                    );

                    if (response.status === 200) {
                        toast.fire({
                            icon: "success",
                            title: "Prestación creada exitosamente"
                        });
                        this.mainAnalytes.push(response.data.mainAnalyte);
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
                information: this.information,
                state_id: this.selectedState
            };
            try {
                const response = await axios.patch(
                    `/api/mainAnalyte/${this.id}`,
                    params
                );

                if (response.status === 200) {
                    const index = this.mainAnalytes.findIndex(
                        find => find.id === response.data.mainAnalyte.id
                    );

                    toast.fire({
                        icon: "success",
                        title: "Prestación editada exitosamente"
                    });

                    this.mainAnalytes.splice(
                        index,
                        1,
                        response.data.mainAnalyte
                    );
                    this.resetForm();
                }
            } catch (e) {
                console.log(e);
            }
        },
        setEdit(mainAnalyte) {
            if (this.states.length === 0) {
                this.getStates();
            }
            this.editing = true;
            this.titleCard = "Editar registro";
            this.formContent = true;
            this.description = mainAnalyte.description;
            this.information = mainAnalyte.information;
            this.selectedState = mainAnalyte.state.id;
            this.id = mainAnalyte.id;
        },
        async destroy(mainAnalyte) {
            const confirmation = await swal.fire({
                title: "¿Estás seguro?",
                text: "La prestación se eliminará permanentemente",
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
                        `/api/mainAnalyte/${mainAnalyte.id}`
                    );

                    if (response.status === 200) {
                        toast.fire({
                            icon: "success",
                            title: "Prestación eliminada"
                        });
                        const index = this.mainAnalytes.findIndex(
                            find => find.id === mainAnalyte.id
                        );
                        this.mainAnalytes.splice(index, 1);
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
            this.information = "";
            this.selectedState = 0;
            this.id = "";
            this.formContent = false;
            this.editing = false;
            this.states = [];
        },
        validateInput() {
            if (
                this.selectedState == 0 ||
                this.description == "" ||
                this.information === ""
            ) {
                if (this.description == "") {
                    this.checkDescription = "is-invalid";
                } else {
                    this.checkDescription = "is-valid";
                }
                if (this.information == "") {
                    this.checkInformation = "is-invalid";
                } else {
                    this.checkInformation = "is-valid";
                }

                return false;
            } else {
                return true;
            }
        },
        resetCheck() {
            this.checkDescription = "";
            this.checkInformation = "";
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
