<template>
    <div>
        <div v-if="!contentReady">
            <div v-if="!states.length" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div class="card mt-2 card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ titleCard }}</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" v-model="id" />
                                    <div class="form-group">
                                        <label
                                            for="description"
                                            v-if="description === ''"
                                            >&nbsp;</label
                                        >
                                        <label for="description" v-else
                                            >NOMBRE:</label
                                        >
                                        <input
                                            v-model="description"
                                            :class="checkDescription"
                                            type="text"
                                            class="form-control"
                                            placeholder="NOMBRE:"
                                        />
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Opciones</th>
                    </tr>
                    <tbody v-for="state in setPaginate" :key="state.id">
                        <th scope="row">{{ state.id }}</th>
                        <td>{{ state.description }}</td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button
                                    @click.prevent="setEdit(state)"
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
                                    @click.prevent="destroy(state)"
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
            id: '',
            description: '',
            checkDescription: '',
            states: [],
            editing: false,
            titleCard: '',
            search_item: '',
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: ''
        }
    },
    created() {
        this.getStates()
    },
    computed: {
        filterData() {
            const filtered = this.states.filter(state => {
                return state.description
                    .toLowerCase()
                    .match(this.search_item.toLowerCase())
            })
            return filtered
        },
        setPaginate() {
            return this.paginate(this.filterData)
        },
        from() {
            if (this.page === 1 && this.setPaginate.length == 0) {
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
        async getStates() {
            try {
                const response = await fetch('/api/state')
                const json = await response.json()

                this.states = json.states

                this.contentReady = true
            } catch (e) {
                console.log(e.message)
            }
        },
        async save() {
            if (this.validateInput()) {
                let params = {
                    description: this.description
                }
                try {
                    const response = await axios.post('/api/state', params)

                    if (response.status === 200) {
                        toast.fire({
                            icon: 'success',
                            title: 'Estado creado exitosamente'
                        })

                        this.states.push(response.data.state)
                        this.resetForm()
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        async edit() {
            let params = {
                description: this.description
            }
            try {
                const response = await axios.patch(
                    `/api/state/${this.id}`,
                    params
                )

                if (response.status === 200) {
                    const index = this.states.findIndex(
                        find => find.id === response.data.state.id
                    )

                    toast.fire({
                        icon: 'success',
                        title: 'Estado editado exitosamente'
                    })

                    this.states.splice(index, 1, response.data.state)
                    this.resetForm()
                }
            } catch (e) {
                console.log(e)
            }
        },
        setEdit(state) {
            if (this.states.length === 0) {
                this.getStates()
            }
            this.editing = true
            this.titleCard = 'Editar registro'
            this.formContent = true
            this.description = state.description
            this.id = state.id
        },
        async destroy(state) {
            const confirmation = await swal.fire({
                title: '¿Estás seguro?',
                text: 'El área de trabajo se eliminará permanentemente',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            })

            if (confirmation.value) {
                try {
                    const response = await axios.delete(
                        `/api/state/${state.id}`
                    )

                    if (response.status === 200) {
                        toast.fire({
                            icon: 'success',
                            title: 'Estado eliminado'
                        })
                        const index = this.states.findIndex(
                            find => find.id === state.id
                        )
                        this.states.splice(index, 1)
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        cancelButton() {
            this.editing = false
            this.resetForm()
        },
        resetForm() {
            this.description = ''
            this.id = ''
            this.formContent = false
            this.editing = false
        },
        validateInput() {
            if (this.description == '') {
                if (this.description == 0) {
                    this.checkDescription = 'is-invalid'
                } else {
                    this.checkDescription = 'is-valid'
                }

                return false
            } else {
                return true
            }
        },
        resetCheck() {
            this.checkDescription = ''
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
            let numberOfPages = []
            numberOfPages = Math.ceil(this.filterData.length / this.perPage)
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
            this.getStates()
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
