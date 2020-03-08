<template>
    <div>
        <div
            v-if="!infinitySamples.length"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div class="card mt-2 card-secondary">
                    <div v-if="dmlOperation" class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title m-2">{{ titleCard }}</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label v-if="infinitySample.description === ''">&nbsp;</label>
                                        <label for="description" v-else>DESCRIPCIÓN:</label>
                                        <input id="description" v-model="infinitySample.description"
                                               :class="checkDescription" type="text"
                                               class="form-control"
                                               placeholder="DESCRIPCIÓN:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label v-if="infinitySample.abbreviature === ''">&nbsp;</label>
                                        <label for="abbreviature" v-else>NOMBRE CORTO:</label>
                                        <input id="abbreviature" v-model="infinitySample.abbreviature"
                                               :class="checkAbbreviature"
                                               type="text"
                                               class="form-control"
                                               placeholder="NOMBRE CORTO:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label v-if="infinitySample.state.id === 0">&nbsp;</label>
                                        <label v-else>ESTADO:</label>
                                        <select2
                                            name="ESTADO:"
                                            :options="states"
                                            v-model="infinitySample.state.id"
                                        >
                                        </select2>
                                        <label v-if="checkState" class="text-danger ml-2">Seleccione una opción <i
                                            class="fas fa-exclamation text-danger"></i></label>
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
                            <th scope="col">Descripción</th>
                            <th scope="col">Nombre corto</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                        <tbody v-for="infinitySample in setPaginate" :key="infinitySample.id">
                        <th scope="row">{{ infinitySample.id }}</th>
                        <td>{{ infinitySample.description }}</td>
                        <td>{{ infinitySample.abbreviature }}</td>
                        <td><span
                            :class="infinitySample.state.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ infinitySample.state.description }}</span>
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(infinitySample)"
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
                                    @click.prevent="destroy(infinitySample)"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        </tbody>
                    </table>
                    <div v-if="!setPaginate.length" class="mt-3 text-center">
                        <h4><span class="lead text-secondary">No existen registros</span></h4>
                    </div>
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
    </div>

</template>


<script>

    export default {
        data() {
            return {
                id: '',
                collections: {
                    infinitySamples: [],
                    states: []
                },
                infinitySample: {
                    id: '',
                    description: '',
                    abbreviature: '',
                    state: {
                        id: 0,
                        description: ''
                    }
                },

                checkDescription: '',
                checkAbbreviature: '',
                checkState: '',

                editing: false,
                dmlOperation: false,
                titleCard: "",
                search_item: "",
                formContent: false,
                pages: [],
                page: 1,
                perPage: 10,
                disabledPrev: "disabled",
                disabledNext: ""
            }
        },
        created() {

            this.fetchInfinitySamples();
            this.fetchStates();

        },
        computed: {
            infinitySamples() {
                return this.collections.infinitySamples;
            },
            states() {
                return this.collections.states.map(state => {
                    return {
                        id: state.id,
                        text: state.description
                    }
                })
            },
            filterData() {
                return this.infinitySamples.filter(infinitySample => {
                    return infinitySample.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase());
                });
            },
            setPaginate() {
                return this.paginate(this.filterData);
            },
            from() {
                if (this.page === 1 && this.setPaginate.length === 0) {
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
            async fetchInfinitySamples() {
                try {
                    const response = await fetch('/api/infinitySample');

                    if (response.status >= 200 && response.status < 300) {
                        const json = await response.json();
                        this.collections.infinitySamples = json.infinitySamples;
                    } else {
                        this.showErrorToast(response)
                    }
                } catch (error) {
                    console.log(error)
                    this.showErrorSwal(error)
                }
            },
            async fetchStates() {
                try {
                    const response = await fetch('/api/state');

                    if (response.status >= 200 && response.status < 300) {

                        const json = await response.json();
                        this.collections.states = json.states;

                    } else {
                        this.showErrorToast(response)
                    }

                } catch (error) {
                    console.log(error)
                    this.showErrorSwal(error)
                }
            },
            async save() {
                if (this.validateInput()) {
                    this.dmlOperation = true;
                    const params = {
                        abbreviature: this.infinitySample.abbreviature,
                        description: this.infinitySample.description,
                        state_id: this.infinitySample.state.id
                    }

                    const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                    const token = crfToken.getAttribute('content');
                    const url = '/api/infinitySample'

                    const options = {
                        method: 'POST',
                        body: JSON.stringify(params),
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        }
                    }
                    const saveResponse = await fetch(url, options);

                    if (saveResponse.status === 200) {
                        const json = await saveResponse.json();

                        this.collections.infinitySamples.push(json.infinitySample)
                        toast.fire({
                            icon: 'success',
                            title: 'Registro creado exitosamente'
                        });

                        this.resetForm();
                        this.resetCheck();
                        this.dmlOperation = false;
                    } else {
                        this.showErrorToast(saveResponse)
                    }
                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }
            },
            async edit() {
                if (this.validateInput()) {
                    const params = {
                        abbreviature: this.infinitySample.abbreviature,
                        description: this.infinitySample.description,
                        state_id: this.infinitySample.state.id
                    }

                    const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                    const token = crfToken.getAttribute('content');

                    const url = `/api/infinitySample/${this.id}`

                    const options = {
                        method: 'PUT',
                        body: JSON.stringify(params),
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        }
                    }
                    try {
                        const updateResponse = await fetch(url, options);

                        if (updateResponse.status === 200) {

                            const json = await updateResponse.json();

                            const index = this.collections.infinitySamples.findIndex(find => find.id === json.infinitySample.id)

                            this.collections.infinitySamples.splice(index, 1, json.infinitySample)
                            toast.fire({
                                icon: 'success',
                                title: 'Registro editado exitosamente'
                            });

                            this.resetForm();
                            this.resetCheck();

                        } else {
                            this.showErrorToast(updateResponse)
                        }
                    } catch (error) {
                        console.log(error)
                        this.showError(error)
                    }
                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }
            },
            setEdit(selected) {
                this.editing = true
                this.titleCard = "Editar registro";
                this.formContent = true;
                this.infinitySample.abbreviature = selected.abbreviature
                this.infinitySample.description = selected.description
                this.infinitySample.state.id = selected.state.id
                this.infinitySample.id = selected.id
                this.id = selected.id
            },
            async destroy(item) {

                const confirmation = await swal.fire({
                    title: '¿Estás seguro?',
                    text: "El registro se eliminará permanentemente",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'No, cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                })

                if (confirmation.value) {
                    try {
                        const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                        const token = crfToken.getAttribute('content'); //se obtiene el valor de el meta, con el atributo content

                        const url = `/api/infinitySample/${item.id}`
                        const options = {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        }
                        const deleteResponse = await fetch(url, options);

                        if (deleteResponse.status === 200) {

                            const index = this.collections.infinitySamples.findIndex(find => find.id === item.id)
                            this.collections.infinitySamples.splice(index, 1);

                            toast.fire({
                                icon: 'success',
                                title: 'Registro eliminado exitosamente'
                            });
                            this.resetForm();
                        } else {
                            this.showErrorToast(deleteResponse)
                        }

                    } catch (error) {
                        console.log(error)
                        this.showError(error)
                    }
                }
            },
            resetForm() {
                this.infinitySample.abbreviature = ''
                this.infinitySample.description = ''
                this.infinitySample.state.id = 0
                this.id = "";
                this.formContent = false;
                this.editing = false;
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
                const numberOfPages = Math.ceil(this.filterData.length / this.perPage);
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
            },
            validateInput() {
                if (this.infinitySample.state.id === 0 ||
                    this.infinitySample.abbreviature === '' ||
                    this.infinitySample.description === '') {

                    this.checkState = this.infinitySample.state.id === 0;

                    if (this.infinitySample.description === "") {
                        this.checkDescription = 'is-invalid'
                    } else {
                        this.checkDescription = 'is-valid'
                    }

                    if (this.infinitySample.abbreviature === "") {
                        this.checkAbbreviature = 'is-invalid'
                    } else {
                        this.checkAbbreviature = 'is-valid'
                    }
                    return false;
                } else {
                    return true;
                }
            },
            resetCheck() {
                this.checkabbreviature = ''
                this.checkDescription = ''
                this.checkState = false
            },
            cancelButton() {
                this.editing = false;
                this.resetForm();
            },
            showErrorSwal(error) {
                swal.fire({
                    icon: 'error',
                    title: error.message,
                    text: 'Error grave. Contacte a desarrollo informático'
                })
            },
            showErrorToast(response) {
                toast.fire({
                    icon: 'error',
                    title: `Error: ${response.status}: ${response.statusText}`
                });
            }
        }
    }
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
