<template>
    <div>
        <div v-if="!contentReady">
            <div class="progress">
                <div
                    class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    :aria-valuenow="progress.toFixed(1)"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    :style="{ width: progress.toFixed(1) + '%' }"
                >
                    {{ progress.toFixed(1) }}%
                    <span class="sr-only"
                        >{{ progress.toFixed(1) }}% Complete (success)</span
                    >
                </div>
            </div>
        </div>
        <div v-if="contentReady">
            <div v-if="formContent" class="card mt-2 card-secondary">
                <div class="card-header">
                    <h3 class="card-title">CREAR NUEVO REGISTRO</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Examen: </label>
                                <select2
                                    v-if="analytes.length"
                                    :options="analytes"
                                    v-model="selectedAnalyte"
                                ></select2>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Estado: </label>
                                <select2
                                    v-if="states.length"
                                    :options="states"
                                    v-model="selectedState"
                                ></select2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 col-md-5 col-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">PRUEBA</h3>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <input
                                            v-model="search_test"
                                            type="text"
                                            class="form-control"
                                            placeholder="Buscar"
                                        />
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                ><i class="fas fa-search"></i
                                            ></span>
                                        </div>
                                    </div>
                                    <div
                                        class="list-group list-group-flush overflow-auto"
                                    >
                                        <button
                                            @dblclick.prevent="selectTest(test)"
                                            v-for="test in filteredList"
                                            :key="test.id"
                                            type="button"
                                            class="list-group-item list-group-item-action"
                                        >
                                            {{ test.description }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 col-md-7 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">SELECCIÓN</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div
                                            v-for="(selectedTest,
                                            index) in selectedTests"
                                            :key="selectedTest.id"
                                            class="col-md-12 col-sm-12 col-12"
                                        >
                                            <div class="info-box">
                                                <div
                                                    class="info-box-content overflow-hidden"
                                                >
                                                    <span class="info-box-text"
                                                        ><strong>{{
                                                            index + 1 + '.  '
                                                        }}</strong
                                                        >{{
                                                            selectedTest.description
                                                        }}</span
                                                    >
                                                </div>
                                                <button
                                                    @click="
                                                        removeSelected(
                                                            selectedTest
                                                        )
                                                    "
                                                    class=" btn btn-info info-box-icon"
                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button
                        v-if="!editing"
                        @click.prevent="save"
                        type="submit"
                        class="btn btn-default float-right ml-2"
                    >
                        Guardar
                    </button>
                    <button
                        v-if="editing"
                        @click.prevent="edit"
                        type="submit"
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
            </div>
            <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Listado general</h3>
                    <div class="card-tools">
                        <button
                            v-if="!editing"
                            @click="setFormContent"
                            type="button"
                            class="btn btn-success float-right"
                        >
                            <i class="fas fa-plus"></i> Crear nuevo registro
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
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Examen</th>
                            <th scope="col">N° pruebas</th>
                            <th scope="col">Opciones</th>
                        </thead>
                        <tbody
                            v-for="(item, index) in setPaginate"
                            :key="item.id"
                        >
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ item.analyte.description }}</td>
                            <td>
                                <span class="badge badge-success">
                                    {{ item.tests.length }}
                                </span>
                            </td>
                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        @click.prevent="setEdit(item)"
                                        class="btn btn-warning mx-1"
                                        href="#"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button
                                        class="btn btn-danger mx-1"
                                        href="#"
                                        @click.prevent="destroy(item)"
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
    name: 'RelAnalyteTestComponent',
    data: function() {
        return {
            progress: 0,
            search_test: '',
            search_item: '',
            tests: [],
            selectedTests: [],
            analytes: [],
            selectedAnalyte: 0,
            states: [],
            selectedState: 1,
            analyteTests: [],
            editing: false,
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: ''
        }
    },
    created: async function() {
        this.startProgressiveBar()
        await this.getAnalyteTest()
        await this.getTest()
        await this.getAnalyte()
        await this.getState()
    },
    mounted: function() {},
    computed: {
        filteredList: function() {
            return this.tests.filter(test => {
                return (
                    test.description
                        .toLowerCase()
                        .match(this.search_test.toLowerCase()) &&
                    test.selected == false
                )
            })
        },
        filterData() {
            const filtered = this.analyteTests.filter(analyteTest => {
                return analyteTest.analyte.description
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
        startProgressiveBar() {
            let width = 0
            const vm = this
            let progress = setInterval(function() {
                if (vm.progress <= 99) {
                    vm.progress += width
                    width += 0.1
                }
                if (vm.analytes.length) {
                    vm.progress = 100
                    clearInterval(progress)
                    vm.contentReady = true
                }
            }, 300)
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
            this.formContent = true
        },
        getAnalyte: function() {
            fetch('/api/analyte')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.analytes = this.parseSelect(json.analytes)
                })
                .catch(error => console.log(error))
        },
        getState() {
            fetch('/api/state')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.states = this.parseSelect(json.states)
                })
                .catch(error => console.log(error))
        },
        getTest: function() {
            fetch('/api/test')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.tests = json.tests.map(test => {
                        test.selected = false
                        return test
                    })
                })
                .catch(error => console.log(error.message))
        },
        getAnalyteTest: function() {
            fetch('/api/analyteTestGroup')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.analyteTests = json.json.filter(item => {
                        return item.tests.length != 0
                    })
                })
                .catch(error => console.log(error))
        },
        selectTest: function(test) {
            test.selected = true

            this.tests.map(test_ => {
                if (test.id === test_.id) {
                    test_.selected = true
                }

                return test_
            })

            this.selectedTests.push(test)

            this.search_test = ''
        },
        removeSelected: function(test) {
            test.selected = false

            this.tests.map(test_ => {
                if (test.id === test_.id) {
                    test_.selected = false
                }

                return test_
            })

            const index = this.selectedTests.findIndex(
                find => find.id === test.id
            )

            this.selectedTests.splice(index, 1)
        },
        parseSelect: function(array) {
            const res = array.map(function(obj) {
                let newObj = {}
                newObj['id'] = obj.id
                newObj['text'] = obj.description

                return newObj
            })
            return res
        },
        save: function() {
            if (this.validateInput()) {
                let arr = []
                this.selectedTests.forEach(selectedTest => {
                    arr.push(selectedTest.id)
                })
                const params = {
                    tests: arr,
                    analyte_id: this.selectedAnalyte,
                    state_id: this.selectedState
                }
                const analyteParams = {
                    is_checked: 0
                }

                const responseAnalyte = axios
                    .put(
                        `/api/analyte/check/${this.selectedAnalyte}`,
                        analyteParams
                    )
                    .then(response => {
                        console.log(response)
                    })

                const response = axios
                    .post('/api/analyteTest', params)
                    .then(response => {
                        toast.fire({
                            icon: 'success',
                            title: 'El registro ha sido creado exitosamente'
                        })
                        this.resetForm()
                        this.getAnalyteTest()
                    })
            }
        },
        setEdit(item) {
            console.log(item)
            this.setSelectedFalse()

            this.tests.map(test => {
                item.tests.forEach(element => {
                    if (element.id === test.id) {
                        test.selected = true
                    }
                })
                return test
            })

            this.selectedTests = item.tests
            this.selectedAnalyte = item.analyte.id
            this.selectedState = 1
            this.editing = true
            this.formContent = true
        },
        edit() {
            let arr = []
            this.selectedTests.forEach(selectedTest => {
                arr.push(selectedTest.id)
            })
            const params = {
                tests: arr,
                analyte_id: this.selectedAnalyte,
                state_id: this.selectedState
            }

            // is_checked: 2 eliminado
            // is_checked: 1 aprobado
            // is_checked: 0 en revisión
            const analyteParams = {
                is_checked: 0
            }

            const responseAnalyte = axios
                .put(
                    `/api/analyte/check/${this.selectedAnalyte}`,
                    analyteParams
                )
                .then(response => {
                    console.log(response)
                })

            const response = axios
                .put(`/api/analyteTest/${this.selectedAnalyte}`, params)
                .then(response => {
                    toast.fire({
                        icon: 'success',
                        title: 'El registro ha sido editado exitosamente'
                    })
                    this.resetForm()
                    this.getAnalyteTest()
                    this.editing = false
                })
        },
        cancelButton() {
            this.editing = false
            this.resetForm()
        },
        destroy(item) {
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
                    // is_checked: 2 eliminado
                    // is_checked: 1 aprobado
                    // is_checked: 0 en revisión
                    const analyteParams = {
                        is_checked: 2
                    }

                    const responseAnalyte = axios
                        .put(
                            `/api/analyte/check/${item.analyte.id}`,
                            analyteParams
                        )
                        .then(response => {
                            console.log(response)
                        })

                    const response = axios
                        .delete(`/api/analyteTest/${item.analyte.id}`)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title:
                                    'El registro ha sido eliminado exitosamente'
                            })
                            this.getAnalyteTest()
                        })
                }
            })
        },
        setSelectedFalse() {
            this.tests.map(test => {
                test.selected = false
                return test
            })
        },
        resetForm() {
            this.setSelectedFalse()
            this.selectedAnalyte = 0
            this.selectedState = 1
            this.selectedTests = []
            this.formContent = false
        },
        validateInput() {
            if (
                this.selectedAnalyte === 0 ||
                this.selectedState === 0 ||
                this.selectedTests.length === 0
            ) {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los campos necesarios'
                })
                return false
            } else {
                return true
            }
        }
    }
}
</script>

<style scoped>
.list-group {
    max-height: 400px;
}

.info-box-icon {
    font-size: 1em;
    max-height: 30px;
    max-width: 25px;
}

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

.badge {
    font-size: 1.2em;
}

.info-box {
    min-height: 0px;
}
</style>
