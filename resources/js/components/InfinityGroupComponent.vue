<template>
    <div>
        <div
            v-if="!infinityGroups.length"
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
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label
                                            v-if="
                                                infinityGroup.description === ''
                                            "
                                            >&nbsp;</label
                                        >
                                        <label for="description" v-else
                                            >NOMBRE:</label
                                        >
                                        <input
                                            id="description"
                                            v-model="infinityGroup.description"
                                            :class="checkDescription"
                                            type="text"
                                            class="form-control"
                                            placeholder="NOMBRE:"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label v-if="infinityGroup.code === ''"
                                            >&nbsp;</label
                                        >
                                        <label for="code" v-else
                                            >NOMBRE CORTO:</label
                                        >
                                        <input
                                            id="code"
                                            v-model="infinityGroup.code"
                                            :class="checkCode"
                                            type="text"
                                            class="form-control"
                                            placeholder="NOMBRE CORTO:"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label
                                            v-if="
                                                infinityGroup.infinitySupergroup
                                                    .id === 0
                                            "
                                            >&nbsp;</label
                                        >
                                        <label v-else>SUPERGRUPO:</label>
                                        <select2
                                            name="SUPERGRUPO:"
                                            :options="infinitySupergroup"
                                            v-model="
                                                infinityGroup.infinitySupergroup
                                                    .id
                                            "
                                        >
                                        </select2>
                                        <label
                                            v-if="checkSupergroup"
                                            class="text-danger ml-2"
                                            >Seleccione una opción
                                            <i
                                                class="fas fa-exclamation text-danger"
                                            ></i
                                        ></label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label
                                            v-if="infinityGroup.state.id === 0"
                                            >&nbsp;</label
                                        >
                                        <label v-else>ESTADO:</label>
                                        <select2
                                            name="ESTADO:"
                                            :options="states"
                                            v-model="infinityGroup.state.id"
                                        >
                                        </select2>
                                        <label
                                            v-if="checkState"
                                            class="text-danger ml-2"
                                            >Seleccione una opción
                                            <i
                                                class="fas fa-exclamation text-danger"
                                            ></i
                                        ></label>
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
                            <th scope="col">Nombre</th>
                            <th scope="col">Código</th>
                            <th scope="col">Supergrupo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                        <tbody
                            v-for="infinityGroup in setPaginate"
                            :key="infinityGroup.id"
                        >
                            <th scope="row">{{ infinityGroup.id }}</th>
                            <td>{{ infinityGroup.description }}</td>
                            <td>{{ infinityGroup.code }}</td>
                            <td>
                                {{
                                    infinityGroup.infinity_supergroup
                                        .description
                                }}
                            </td>
                            <td>
                                <span
                                    :class="
                                        infinityGroup.state.id === 1
                                            ? 'badge badge-success'
                                            : 'badge badge-danger'
                                    "
                                >
                                    {{ infinityGroup.state.description }}</span
                                >
                            </td>
                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        @click.prevent="setEdit(infinityGroup)"
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
                                        @click.prevent="destroy(infinityGroup)"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tbody>
                    </table>
                    <div v-if="!setPaginate.length" class="mt-3 text-center">
                        <h4>
                            <span class="lead text-secondary"
                                >No existen registros</span
                            >
                        </h4>
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
                infinityGroups: [],
                states: [],
                infinitySupergroups: []
            },
            infinityGroup: {
                id: '',
                description: '',
                code: '',
                state: {
                    id: 0,
                    description: ''
                },
                infinitySupergroup: {
                    id: 0,
                    description: ''
                }
            },

            checkDescription: '',
            checkCode: '',
            checkSupergroup: false,
            checkState: false,

            editing: false,
            dmlOperation: false,
            titleCard: '',
            search_item: '',
            formContent: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: ''
        }
    },
    created() {
        this.fetchInfinityGroups()
        this.fetchStates()
        this.fetchInfinitySupergroup()
    },
    computed: {
        infinityGroups() {
            return this.collections.infinityGroups
        },
        states() {
            return this.collections.states.map(state => {
                return {
                    id: state.id,
                    text: state.description
                }
            })
        },
        infinitySupergroup() {
            return this.collections.infinitySupergroups.map(
                infinitySupergroup => {
                    return {
                        id: infinitySupergroup.id,
                        text: `${infinitySupergroup.description}`
                    }
                }
            )
        },
        filterData() {
            return this.infinityGroups.filter(infinityGroup => {
                return infinityGroup.description
                    .toLowerCase()
                    .match(this.search_item.toLowerCase())
            })
        },
        setPaginate() {
            return this.paginate(this.filterData)
        },
        from() {
            if (this.page === 1 && this.setPaginate.length === 0) {
                return 0
            } else if (this.page === 1) {
                return 1
            } else {
                return this.page * this.setPaginate.length - this.perPage
            }
        },
        to() {
            if (this.page === 1) {
                return this.setPaginate.length
            }
            return this.page * this.perPage
        }
    },
    watch: {
        page() {
            this.isPrevDisabled()
            this.isNextDisabled()
        },
        filterData() {
            this.pages = []
            this.page = 1
            this.setPages()
        },
        pages() {
            if (this.pages.length <= 1) {
                this.disabledNext = 'disabled'
            } else {
                this.disabledNext = ''
            }
        },
        perPage() {
            this.pages = []
            this.page = 1
            this.setPages()
        }
    },

    methods: {
        async fetchInfinityGroups() {
            try {
                const response = await fetch('/api/infinityGroup')

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json()
                    this.collections.infinityGroups = json.infinityGroups
                } else {
                    this.showErrorToast(response)
                }
            } catch (error) {
                console.log(error)
                this.showErrorSwal(error)
            }
        },
        async fetchInfinitySupergroup() {
            try {
                const response = await fetch('/api/infinitySupergroup')

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json()
                    this.collections.infinitySupergroups =
                        json.infinitySupergroups
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
                const response = await fetch('/api/state')

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json()
                    this.collections.states = json.states
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
                this.dmlOperation = true
                const params = {
                    code: this.infinityGroup.code,
                    description: this.infinityGroup.description,
                    state_id: this.infinityGroup.state.id,
                    infinity_supergroup_id: this.infinityGroup
                        .infinitySupergroup.id
                }

                const crfToken = document.head.querySelector(
                    'meta[name="csrf-token"]'
                )
                const token = crfToken.getAttribute('content')
                const url = '/api/infinityGroup'

                const options = {
                    method: 'POST',
                    body: JSON.stringify(params),
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                }
                const saveResponse = await fetch(url, options)

                if (saveResponse.status === 200) {
                    const json = await saveResponse.json()

                    this.collections.infinityGroups.push(json.infinityGroup)
                    toast.fire({
                        icon: 'success',
                        title: 'Registro creado exitosamente'
                    })

                    this.resetForm()
                    this.resetCheck()
                    this.dmlOperation = false
                } else {
                    this.showErrorToast(saveResponse)
                }
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })
            }
        },
        async edit() {
            if (this.validateInput()) {
                const params = {
                    code: this.infinityGroup.code,
                    description: this.infinityGroup.description,
                    state_id: this.infinityGroup.state.id,
                    infinity_supergroup_id: this.infinityGroup
                        .infinitySupergroup.id
                }

                const crfToken = document.head.querySelector(
                    'meta[name="csrf-token"]'
                )
                const token = crfToken.getAttribute('content')

                const url = `/api/infinityGroup/${this.id}`

                const options = {
                    method: 'PUT',
                    body: JSON.stringify(params),
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                }
                try {
                    const updateResponse = await fetch(url, options)

                    if (updateResponse.status === 200) {
                        const json = await updateResponse.json()

                        const index = this.collections.infinityGroups.findIndex(
                            find => find.id === json.infinityGroup.id
                        )

                        this.collections.infinityGroups.splice(
                            index,
                            1,
                            json.infinityGroup
                        )
                        toast.fire({
                            icon: 'success',
                            title: 'Registro editado exitosamente'
                        })

                        this.resetForm()
                        this.resetCheck()
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
                })
            }
        },
        setEdit(selected) {
            this.editing = true
            this.titleCard = 'Editar registro'
            this.formContent = true
            this.infinityGroup.code = selected.code
            this.infinityGroup.description = selected.description
            this.infinityGroup.state.id = selected.state.id
            this.infinityGroup.infinitySupergroup.id =
                selected.infinity_supergroup.id
            this.infinityGroup.id = selected.id
            this.id = selected.id
        },
        async destroy(item) {
            const confirmation = await swal.fire({
                title: '¿Estás seguro?',
                text: 'El registro se eliminará permanentemente',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            })

            if (confirmation.value) {
                try {
                    const crfToken = document.head.querySelector(
                        'meta[name="csrf-token"]'
                    )
                    const token = crfToken.getAttribute('content') //se obtiene el valor de el meta, con el atributo content

                    const url = `/api/infinityGroup/${item.id}`
                    const options = {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    }
                    const deleteResponse = await fetch(url, options)

                    if (deleteResponse.status === 200) {
                        const index = this.collections.infinityGroups.findIndex(
                            find => find.id === item.id
                        )
                        this.collections.infinityGroups.splice(index, 1)

                        toast.fire({
                            icon: 'success',
                            title: 'Registro eliminado exitosamente'
                        })
                        this.resetForm()
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
            this.infinityGroup.code = ''
            this.infinityGroup.description = ''
            this.infinityGroup.state.id = 0
            this.infinityGroup.infinitySupergroup.id = 0
            this.id = ''
            this.formContent = false
            this.editing = false
        },
        currentPage(page) {
            this.page = page
        },
        prevPage() {
            this.page--
        },
        nextPage() {
            this.page++
        },
        isPrevDisabled() {
            if (this.page !== 1) {
                this.disabledPrev = ''
            } else {
                this.disabledPrev = 'disabled'
            }
        },
        isNextDisabled() {
            if (this.page < this.pages.length) {
                this.disabledNext = ''
            } else {
                this.disabledNext = 'disabled'
            }
        },
        setPages() {
            const numberOfPages = Math.ceil(
                this.filterData.length / this.perPage
            )
            for (let i = 1; i <= numberOfPages; i++) {
                this.pages.push(i)
            }
        },
        paginate(array) {
            let page = this.page
            let perpage = this.perPage
            let from = page * perpage - perpage
            let to = page * perpage

            return array.slice(from, to)
        },
        setFormContent() {
            this.titleCard = 'Crear nuevo registro'
            this.formContent = true
        },
        validateInput() {
            if (
                this.infinityGroup.state.id === 0 ||
                this.infinityGroup.infinitySupergroup.id === 0 ||
                this.infinityGroup.code === '' ||
                this.infinityGroup.description === ''
            ) {
                this.checkState = this.infinityGroup.state.id === 0
                this.checkSupergroup =
                    this.infinityGroup.infinitySupergroup.id === 0

                if (this.infinityGroup.description === '') {
                    this.checkDescription = 'is-invalid'
                } else {
                    this.checkDescription = 'is-valid'
                }

                if (this.infinityGroup.code === '') {
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
            this.checkSupergroup = ''
            this.checkState = false
        },
        cancelButton() {
            this.editing = false
            this.resetForm()
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
