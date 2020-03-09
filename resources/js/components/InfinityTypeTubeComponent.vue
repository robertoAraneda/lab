<template>

    <div>
        <div
            v-if="!collections.infinityTypeTubes.length"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div
                    v-if="!collections.infinityLabels.length"
                    class="d-flex justify-content-center"
                >
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div v-else class="card mt-2 card-secondary">
                    <div class="card-header">
                        <h3 class="card-title m-2">{{ titleCard }}</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label v-if="infinityTypeTube.description === ''">&nbsp;</label>
                                        <label for="description" v-else>DESCRIPCIÓN:</label>
                                        <input id="description" v-model="infinityTypeTube.description"
                                               :class="checkDescription" type="text"
                                               class="form-control"
                                               placeholder="DESCRIPCIÓN:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTypeTube.abbreviation === ''">&nbsp;</label>
                                        <label for="abbreviation" v-else>NOMBRE CORTO:</label>
                                        <input id="abbreviation" v-model="infinityTypeTube.abbreviation"
                                               :class="checkAbbreviation"
                                               type="text"
                                               class="form-control"
                                               placeholder="NOMBRE CORTO:"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTypeTube.infinitySample.id === 0">&nbsp;</label>
                                        <label v-else>ESTADO:</label>
                                        <select2
                                            name="MUESTRA INFINITY:"
                                            :options="infinitySamples"
                                            v-model="infinityTypeTube.infinitySample.id"
                                        >
                                        </select2>
                                        <label v-if="checkInfinitySample" class="text-danger ml-2">Seleccione una opción
                                            <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTypeTube.infinityLabel.id === 0">&nbsp;</label>
                                        <label v-else>TIPO TUBO:</label>
                                        <select2
                                            name="TIPO TUBO:"
                                            :options="infinityLabels"
                                            v-model="infinityTypeTube.infinityLabel.id "
                                        >
                                        </select2>
                                        <label v-if="checkLabel" class="text-danger ml-2">Seleccione una
                                            opción <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTypeTube.state.id === 0">&nbsp;</label>
                                        <label v-else>ESTADO:</label>
                                        <select2
                                            name="ESTADO:"
                                            :options="states"
                                            v-model="infinityTypeTube.state.id"
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
                            <th scope="col">Nombre corto</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Tipo muestra</th>
                            <th scope="col">Código</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                        <tbody v-for="infinityTypeTube in setPaginate" :key="infinityTypeTube.id">
                        <th scope="row">{{ infinityTypeTube.id }}</th>
                        <td>{{ infinityTypeTube.abbreviation }}</td>
                        <td>{{ infinityTypeTube.description }}</td>
                        <td>{{ infinityTypeTube.infinity_sample.description }}</td>
                        <td v-if="infinityTypeTube.label !== null">{{ infinityTypeTube.label.code }}</td>
                        <td v-else> -</td>
                        <td><span
                            :class="infinityTypeTube.state.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ infinityTypeTube.state.description }}</span>
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(infinityTypeTube)"
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
                                    @click.prevent="destroy(infinityTypeTube)"
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                infinityTypeTube: {
                    id: '',
                    abbreviation: '',
                    description: '',
                    state: {
                        id: 0,
                        description: ''
                    },
                    infinityLabel: {
                        id: 0,
                        description: '',
                    },
                    infinitySample: {
                        id: 0,
                        description: ''
                    }

                },
                collections: {
                    states: [],
                    infinityLabels: [],
                    infinitySamples: [],
                    infinityTypeTubes: []
                },

                checkDescription: '',
                checkAbbreviation: '',
                checkInfinitySample: false,
                checkLabel: false,
                checkState: false,

                editing: false,
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
            this.fetchInfinityLabels();
            this.fetchStates();
            this.fetchInfinityTypeTubes();
        },
        computed: {
            states() {
                return this.parseSelect(this.collections.states);
            },
            infinitySamples() {
                return this.parseSelect(this.collections.infinitySamples);
            },
            infinityLabels() {
                return this.collections.infinityLabels.map(label => {
                    return {
                        id: label.id,
                        text: `${label.description} | (${label.code})`
                    }
                })
            },
            filterData() {
                return this.collections.infinityTypeTubes.filter(infinityTypeTube => {
                    return infinityTypeTube.description
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
            async fetchInfinityTypeTubes() {
                try {
                    const response = await fetch('/api/infinityTypeTube');

                    if (response.status === 200) {
                        const json = await response.json();

                        this.collections.infinityTypeTubes = json.infinityTypeTubes;
                    } else {
                        this.showErrorToast(response)
                    }

                } catch (error) {
                    this.showErrorSwal(error)
                }
            },
            async fetchStates() {
                try {
                    const response = await fetch('/api/state');
                    if (response.status === 200) {
                        const json = await response.json();
                        this.collections.states = json.states;
                    } else {
                        this.showErrorToast(response)
                    }
                } catch (error) {
                    this.showError(error)
                }
            },
            async fetchInfinitySamples() {
                try {
                    const response = await fetch('/api/infinitySample');
                    if (response.status === 200) {
                        const json = await response.json();
                        this.collections.infinitySamples = json.infinitySamples;
                    } else {
                        this.showErrorToast(response)
                    }

                } catch (error) {
                    this.showError(error)
                }
            },
            async fetchInfinityLabels() {
                try {
                    const response = await fetch('/api/label');
                    if (response.status === 200) {
                        const json = await response.json();
                        this.collections.infinityLabels = json.labels;
                    } else {
                        this.showErrorToast(response)
                    }

                } catch (error) {
                    this.showError(error)
                }
            },
            async save() {
                if (this.validateInput()) {
                    let params = {
                        abbreviation: this.infinityTypeTube.abbreviation,
                        description: this.infinityTypeTube.description,
                        state_id: this.infinityTypeTube.state.id,
                        label_id: this.infinityTypeTube.infinityLabel.id,
                        infinity_sample_id: this.infinityTypeTube.infinitySample.id
                    }

                    try {
                        //se obtiene el token de los formularios de laravel para poder realizar
                        //el POST. si no se obtiene error 419 not found
                        const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                        const token = crfToken.getAttribute('content'); //se obtiene el valor de el meta, con el atributo content

                        const url = '/api/infinityTypeTube'

                        const options = {
                            method: 'POST',
                            body: JSON.stringify(params), // se debe enviar como string los parametros
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        }
                        const response = await fetch(url, options)

                        if (response.status >= 200 && response.status < 300) {
                            const json = await response.json();
                            this.collections.infinityTypeTubes.push(json.infinityTypeTube);
                            toast.fire({
                                icon: 'success',
                                title: 'Registro creado exitosamente'
                            });

                            this.resetForm();
                            this.resetCheck();
                        } else {
                            this.showErrorToast(response)
                        }

                    } catch (error) {
                        console.log(error)
                        this.showErrorSwal(error)

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
                    let params = {
                        abbreviation: this.infinityTypeTube.abbreviation,
                        description: this.infinityTypeTube.description,
                        state_id: this.infinityTypeTube.state.id,
                        label_id: this.infinityTypeTube.infinityLabel.id,
                        infinity_sample_id: this.infinityTypeTube.infinitySample.id
                    }

                    try {
                        //se obtiene el token de los formularios de laravel para poder realizar
                        //el POST. si no se obtiene error 419 not found
                        const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                        const token = crfToken.getAttribute('content'); //se obtiene el valor de el meta, con el atributo content

                        const url = `/api/infinityTypeTube/${this.id}`

                        const options = {
                            method: 'PUT',
                            body: JSON.stringify(params), // se debe enviar como string los parametros
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        }

                        const response = await fetch(url, options);

                        if (response.status >= 200 && response.status < 300) {

                            const json = await response.json();

                            const index = this.collections.infinityTypeTubes.findIndex(find => find.id === this.id)

                            console.log(json)
                            this.collections.infinityTypeTubes.splice(index, 1, json.infinityTypeTube);

                            toast.fire({
                                icon: 'success',
                                title: 'Registro editado exitosamente'
                            });

                            this.resetForm();
                            this.resetCheck();
                        } else {
                            this.showErrorToast(response)
                        }
                    } catch (error) {
                        console.log(error)
                        this.showErrorSwal(error)
                    }
                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los datos solicitados'
                    });
                }

            },
            async destroy(selected) {
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

                        const url = `/api/infinityTypeTube/${selected.id}`
                        const options = {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        }

                        const response = await fetch(url, options);

                        if (response.status === 200) {
                            const index = this.collections.infinityTypeTubes.findIndex(find => find.id === selected.id)

                            this.collections.infinityTypeTubes.splice(index, 1)

                            toast.fire({
                                icon: 'success',
                                title: 'Registro eliminado exitosamente'
                            });
                        }else{
                            this.showErrorToast(response)
                        }
                    } catch (error) {

                        this.showErrorSwal(error)
                    }
                }
            },
            setEdit(selected) {
                console.log(selected)
                this.titleCard = "Editar registro";
                this.formContent = true;
                this.editing = true;

                this.infinityTypeTube.abbreviation = selected.abbreviation
                this.infinityTypeTube.description = selected.description
                this.infinityTypeTube.state.id = selected.state.id
                this.infinityTypeTube.infinityLabel.id = selected.label.id
                this.infinityTypeTube.infinitySample.id = selected.infinity_sample.id
                this.infinityTypeTube.id = selected.id
                this.id = selected.id
            },
            resetForm() {
                this.infinityTypeTube.infinityLabel.id = 0
                this.infinityTypeTube.abbreviation = ''
                this.infinityTypeTube.description = ''
                this.infinityTypeTube.infinitySample.id = 0
                this.infinityTypeTube.state.id  = 0
                this.infinityTypeTube.id = ''
                this.id = ''
                this.formContent = false;
                this.editing = false;
            },
            validateInput() {
                if (this.infinityTypeTube.infinityLabel.id === 0 ||
                    this.infinityTypeTube.state.id === 0 ||
                    this.infinityTypeTube.infinitySample.id === 0 ||
                    this.description === '' ||
                    this.abbreviation === '') {

                    this.checkState = this.infinityTypeTube.state.id === 0;
                    this.checkCode = this.infinityTypeTube.infinityLabel.id === 0;
                    this.checkInfinitySample = this.infinityTypeTube.infinitySample.id === 0;

                    if (this.abbreviation === "") {
                        this.checkAbbreviation = 'is-invalid'
                    } else {
                        this.checkAbbreviation = 'is-valid'
                    }

                    if (this.description === "") {
                        this.checkDescription = 'is-invalid'
                    } else {
                        this.checkDescription = 'is-valid'
                    }
                    return false;
                } else {
                    return true;
                }
            },
            resetCheck() {
                this.checkLabel = false
                this.checkAbbreviation = ''
                this.checkDescription = ''
                this.checkState = false
                this.checkInfinitySample = false
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
            },
            parseSelect: function (array) {
                return array.map(function (obj) {
                    return {
                        id: obj.id,
                        text: obj.description
                    };
                });
            },
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
