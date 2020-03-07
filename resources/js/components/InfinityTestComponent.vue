<template>
    <div>
        <div
            v-if="!collections.infinityTests.length"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div
                    v-if="!collections.infinityTypeTubes.length"
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label v-if="infinityTest.description === ''">&nbsp;</label>
                                        <label for="description" v-else>DESCRIPCIÓN:</label>
                                        <input id="description" v-model="infinityTest.description"
                                               :class="checkDescription" type="text"
                                               class="form-control"
                                               placeholder="DESCRIPCIÓN:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label v-if="infinityTest.abbreviation === ''">&nbsp;</label>
                                        <label for="abbreviation" v-else>NOMBRE CORTO:</label>
                                        <input id="abbreviation" v-model="infinityTest.abbreviation"
                                               :class="checkAbbreviation"
                                               type="text"
                                               class="form-control"
                                               placeholder="NOMBRE CORTO:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label v-if="infinityTest.code === ''">&nbsp;</label>
                                        <label for="code" v-else>CÓDIGO:</label>
                                        <input id="code" v-model="infinityTest.code" :class="checkCode"
                                               type="text"
                                               class="form-control"
                                               placeholder="CÓDIGO:"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTest.createdAt === ''">&nbsp;</label>
                                        <label for="infinityCreatedAt" v-else>FECHA CREACIÓN INFINITY:</label>
                                        <input id="infinityCreatedAt" v-model="infinityTest.createdAt"
                                               :class="checkCreatedInfinityAt" type="date"
                                               class="form-control"
                                               placeholder="FECHA CREACIÓN INFINITY:"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTest.state.id === 0">&nbsp;</label>
                                        <label v-else>ESTADO:</label>
                                        <select2
                                            name="ESTADO:"
                                            :options="collections.states"
                                            v-model="infinityTest.state.id"
                                        >
                                        </select2>
                                        <label v-if="checkState" class="text-danger ml-2">Seleccione una opción <i
                                            class="fas fa-exclamation text-danger"></i></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label v-if="infinityTest.infinityTypeTube.id === 0">&nbsp;</label>
                                        <label v-else>TIPO TUBO:</label>
                                        <select2
                                            name="TIPO TUBO:"
                                            :options="collections.infinityTypeTubes"
                                            v-model="infinityTest.infinityTypeTube.id"
                                        >
                                        </select2>
                                        <label v-if="checkInfinityTypeTube" class="text-danger ml-2">Seleccione una
                                            opción <i
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
                            <th scope="col">#</th>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre corto</th>
                            <th scope="col">Description</th>
                            <th scope="col">Tipo tubo</th>
                            <th scope="col">Extensión</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                        <tbody v-for="infinityTest in setPaginate" :key="infinityTest.id">
                        <th scope="row">{{ infinityTest.id }}</th>
                        <td>{{ infinityTest.code }}</td>
                        <td>{{ infinityTest.abbreviation }}</td>
                        <td>{{ infinityTest.description }}</td>
                        <td>{{ infinityTest.infinity_type_tube.description }}</td>
                        <td v-if="infinityTest.infinity_type_tube.label !== null">{{
                            infinityTest.infinity_type_tube.label.code }}
                        </td>
                        <td v-else> -</td>
                        <td><span
                            :class="infinityTest.state.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ infinityTest.state.description }}</span>
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(infinityTest)"
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
                                    @click.prevent="destroy(infinityTest)"
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
                infinityTest: {
                    id: '',
                    abbreviation: '',
                    description: '',
                    code: '',
                    createdAt: '',
                    infinityTypeTube: {
                        id: 0,
                        description: ''
                    },
                    state: {
                        id: 0,
                        description: ''
                    }
                },
                collections: {
                    states: [],
                    infinityTests: [],
                    infinityTypeTubes: [],
                },
                selectedState: 0,
                selectedInfinityTypeTubes: 0,
                checkDescription: '',
                checkAbbreviation: '',
                checkInfinityTypeTube: false,
                checkCreatedInfinityAt: '',
                checkCode: '',
                checkState: false,

                editing: false,
                titleCard: "",
                search_item: "",
                formContent: false,
                pages: [],
                page: 1,
                perPage: 5,
                disabledPrev: "disabled",
                disabledNext: ""
            }
        },
        created() {

            this.getInfinityTypeTubes();
            this.getStates();
            this.getInfinityTests();

        },
        computed: {
            filterData() {
                return this.collections.infinityTests.filter(infinityTest => {
                    return infinityTest.description
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
            async getInfinityTests() {
                try {
                    const infinityTests = await fetch('/api/infinityTest');
                    const json = await infinityTests.json();
                    this.collections.infinityTests = json.infinityTests;

                } catch (error) {
                    swal.fire({
                        icon: 'error',
                        title: error.message,
                        text: 'Error grave. Contacte a desarrollo informático'
                    })
                }
            },
            async getStates() {
                try {
                    const states = await fetch('/api/state');
                    const jsonResponse = await states.json()
                    this.collections.states = jsonResponse.states.map(state => {
                        return {
                            id: state.id,
                            text: state.description
                        }
                    })

                } catch (error) {
                    swal.fire({
                        icon: 'error',
                        title: error.message,
                        text: 'Error grave. Contacte a desarrollo informático'
                    })
                }
            },
            async getInfinityTypeTubes() {
                try {
                    const infinityTypeTubes = await fetch('/api/infinityTypeTube');
                    const jsonResponse = await infinityTypeTubes.json()
                    this.collections.infinityTypeTubes = jsonResponse.map(tube => {
                        return {
                            id: tube.id,
                            text: tube.description
                        }
                    });
                } catch (error) {
                    swal.fire({
                        icon: 'error',
                        title: error.message,
                        text: 'Error grave. Contacte a desarrollo informático'
                    })
                }
            },
            async save() {
                if (this.validateInput()) {
                    let params = {
                        infinity_type_tube_id: this.infinityTest.infinityTypeTube.id,
                        created_infinity_at: this.infinityTest.createdAt,
                        code: this.infinityTest.code,
                        abbreviation: this.infinityTest.abbreviation,
                        description: this.infinityTest.description,
                        state_id: this.selectedState,
                    }
                    try {

                        //se obtiene el token de los formularios de laravel para poder realizar
                        //el POST. si no se obtiene error 419 not found
                        const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                        const token = crfToken.getAttribute('content'); //se obtiene el valor de el meta, con el atributo content

                        const url = '/api/infinityTest'

                        const init = {
                            method: 'POST',
                            body: JSON.stringify(params), // se debe enviar como string los parametros
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        }
                        const saveInfinityTest = await fetch(url, init);

                        console.log(saveInfinityTest)
                        if (saveInfinityTest.ok) {
                            const json = await saveInfinityTest.json();
                            this.collections.infinityTests.push(json.infinityTest);
                            toast.fire({
                                icon: 'success',
                                title: 'Registro creado exitosamente'
                            });

                            this.resetForm();
                            this.resetCheck();
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
            async edit() {
                if (this.validateInput()) {
                    let params = {
                        infinity_type_tube_id: this.infinityTest.infinityTypeTube.id,
                        created_infinity_at: this.infinityTest.createdAt,
                        code: this.infinityTest.code,
                        abbreviation: this.infinityTest.abbreviation,
                        description: this.infinityTest.description,
                        state_id: this.infinityTest.state.id,
                    }
                    try {

                        //se obtiene el token de los formularios de laravel para poder realizar
                        //el POST. si no se obtiene error 419 not found
                        const crfToken = document.head.querySelector('meta[name="csrf-token"]');
                        const token = crfToken.getAttribute('content'); //se obtiene el valor de el meta, con el atributo content

                        const url = `/api/infinityTest/${this.id}`

                        const init = {
                            method: 'PUT',
                            body: JSON.stringify(params), // se debe enviar como string los parametros
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        }
                        const updateInfinityTest = await fetch(url, init);

                        if (updateInfinityTest.ok) {
                            const json = await updateInfinityTest.json();

                            const index = this.collections.infinityTests.findIndex(find => find.id === json.infinityTest.id)

                            this.collections.infinityTests.splice(index, 1, json.infinityTest);
                            toast.fire({
                                icon: 'success',
                                title: 'Registro editado exitosamente'
                            });

                            this.resetForm();
                            this.resetCheck();
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
                this.infinityTest.infinityTypeTube.id = selected.infinity_type_tube.id
                this.infinityTest.createdAt = selected.created_infinity_at
                this.infinityTest.code = selected.code
                this.infinityTest.abbreviation = selected.abbreviation
                this.infinityTest.description = selected.description
                this.infinityTest.state.id = selected.state.id
                this.id = selected.id
            },
            async destroy(item, index) {
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

                        const url = `/api/infinityTest/${item.id}`
                        const init = {
                            method: 'DELETE',
                            headers:{
                                'X-CSRF-TOKEN': token
                            }
                        }
                        const deleteInfinityTest = await fetch(url, init);
                        console.log(deleteInfinityTest)

                        if (deleteInfinityTest.status === 200) {

                            const index = this.collections.infinityTests.findIndex(find => find.id === item.id)

                            this.collections.infinityTests.splice(index, 1);

                            toast.fire({
                                icon: 'success',
                                title: 'Registro eliminado exitosamente'
                            });
                        } else {
                            toast.fire({
                                icon: 'error',
                                title: `Error: ${deleteInfinityTest.status}: ${deleteInfinityTest.statusText} |`,
                                text: 'No se ha podido eliminar el registro'
                            });
                        }
                    } catch (error) {
                        this.showError(error)
                    }
                }
            },
            validateInput() {
                if (this.infinityTest.state.id === 0 ||
                    this.infinityTest.infinityTypeTube.id === 0 ||
                    this.infinityTest.createdAt === '' ||
                    this.infinityTest.code === '' ||
                    this.infinityTest.description === '' ||
                    this.infinityTest.abbreviation === '') {

                    if (this.infinityTest.state.id === 0) {
                        this.checkState = true
                    } else {
                        this.checkState = false
                    }

                    if (this.infinityTest.infinityTypeTube.id === 0) {
                        this.checkInfinityTypeTube = true
                    } else {
                        this.checkInfinityTypeTube = false
                    }

                    if (this.infinityTest.code === "") {
                        this.checkCode = 'is-invalid'
                    } else {
                        this.checkCode = 'is-valid'
                    }

                    if (this.infinityTest.createdAt === "") {
                        this.checkCreatedInfinityAt = 'is-invalid'
                    } else {
                        this.checkCreatedInfinityAt = 'is-valid'
                    }

                    if (this.infinityTest.abbreviation === "") {
                        this.checkAbbreviation = 'is-invalid'
                    } else {
                        this.checkAbbreviation = 'is-valid'
                    }

                    if (this.infinityTest.description === "") {
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
                this.checkCode = ''
                this.checkCreatedInfinityAt = ''
                this.checkInfinityTypeTube = ''
                this.checkAbbreviation = ''
                this.checkDescription = ''
                this.checkState = ''
            },
            cancelButton() {
                this.editing = false;
                this.resetForm();
            },
            resetForm() {
                this.infinityTest.description = "";
                this.infinityTest.id = "";
                this.infinityTest.code = "";
                this.infinityTest.abbreviation = "";
                this.infinityTest.state.id = 0;
                this.infinityTest.infinityTypeTube.id = 0
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
            },
            parseSelect: function (array) {
                return array.map(function (obj) {
                    return {
                        id: obj.id,
                        text: obj.description
                    };
                });
            },
            showError(error) {
                swal.fire({
                    icon: 'error',
                    title: error.message,
                    text: 'Error grave. Contacte a desarrollo informático'
                })
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

