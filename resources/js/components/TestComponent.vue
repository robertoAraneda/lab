<template>
    <div>
        <div v-if="createRegister && !editing" class="card mt-2 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Crear un nuevo registro</h3>
            </div>
            <div class="card-body">
                <h5 class="text-blue">Datos LOINC</h5>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Código</label>
                            <input v-model="loinc_code" @keypress.enter.prevent="search_loinc"
                                   :class="check.loinc.code" type="text"
                                   class="form-control" placeholder="Ingrese código"
                            >
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" v-model="loinc_id">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input readonly v-model="loinc_name" :class="check.loinc.name"
                                   type="text"
                                   class="form-control"
                            >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo muestra</label>
                            <input readonly v-model="loinc_sample" :class="check.loinc.sample"
                                   type="text"
                                   class="form-control"
                            >
                        </div>
                    </div>
                </div>
                <h5 class="text-blue">Datos prueba</h5>
                <div class="row">
                    <div class="col-8 col-sm-8">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input v-model="description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4 col-sm-4">
                        <div class="form-group">
                            <label>Prueba infinity</label>
                            <select2
                                v-if="selectInfinityTest.length" :options="selectInfinityTest"
                                v-model="infinity_test_id"
                            ></select2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Unidades</label>
                            <select2
                                v-if="selectUnit.length" :options="selectUnit" v-model="unit_id"
                            ></select2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Método</label>
                            <select2
                                v-if="selectMethod.length" :options="selectMethod" v-model="method_id"
                            ></select2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <select2
                                v-if="selectState.length" :options="selectState" v-model="state_id"
                            ></select2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button @click.prevent="save" type="submit" class="btn btn-default float-right ml-2">
                    Guardar
                </button>
                <button @click.prevent="cancelCreate" class="btn btn-danger float-right ">
                    Cancelar
                </button>
            </div>
        </div>
        <div v-if="!createRegister && editing" class="card mt-2 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Modificar registro</h3>
            </div>
            <div class="card-body">
                <h5 class="text-blue">Datos LOINC</h5>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Código</label>
                            <input v-model="loinc_code" @keypress.enter.prevent="search_loinc"
                                   :class="check.loinc.code" type="text"
                                   class="form-control" placeholder="Ingrese código"
                            >
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" v-model="loinc_id">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input readonly v-model="loinc_name" :class="check.loinc.name"
                                   type="text"
                                   class="form-control"
                            >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo muestra</label>
                            <input readonly v-model="loinc_sample" :class="check.loinc.sample"
                                   type="text"
                                   class="form-control"
                            >
                        </div>
                    </div>
                </div>
                <h5 class="text-blue">Datos prueba</h5>
                <div class="row">
                    <div class="col-8 col-sm-8">
                        <div class="form-group">
                            <input type="hidden" v-model="id">
                            <label>Descripción</label>
                            <input v-model="description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4 col-sm-4">
                        <div class="form-group">
                            <label>Prueba infinity</label>
                            <select2
                                v-if="selectInfinityTest.length" :options="selectInfinityTest"
                                v-model="infinity_test_id"
                            ></select2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Unidades</label>
                            <select2
                                v-if="selectUnit.length" :options="selectUnit" v-model="unit_id"
                            ></select2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Método</label>
                            <select2
                                v-if="selectMethod.length" :options="selectMethod" v-model="method_id"
                            ></select2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <select2
                                v-if="selectState.length" :options="selectState" v-model="state_id"
                            ></select2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button @click.prevent="edit" type="submit" class="btn btn-warning float-right ml-2">
                    Editar
                </button>
                <button @click.prevent="cancelCreate" class="btn btn-danger float-right ">
                    Cancelar
                </button>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header bg-secondary">
                <h3 class="card-title">Listado general de pruebas</h3>
                <div class="card-tools">
                    <button v-if="!editing" @click="setCreateRegister" type="button"
                            class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Crear nuevo registro
                    </button>
                </div>
            </div>
            <div class="card-header">
                <div class="input-group input-group-sm card-title" style="width: 250px;">
                    <h5 class="mt-2">Mostrar </h5>
                    <div class="input-group-append">
                        <select class="card-title form-control show-select" v-model="perPage">
                            <option value="20">20</option>
                            <option value="10">10</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <h5 class="mt-2 ml-2"> registros</h5>
                    </div>
                </div>
                <div class="card-tools">
                    <div class="input-group mb-2 mt-1">
                        <input type="text" v-model="search_item" class="form-control float-right" placeholder="Buscar">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                        <th scope="col">ID</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Prueba infinity</th>
                        <th scope="col">Método</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                        </thead>
                        <tbody v-for="(item, index) in setPaginate" :key="item.id">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{ item.description }}</td>
                        <td>{{ item.infinity_test_id.code }} - {{ item.infinity_test_id.description }}</td>
                        <td>{{ item.method_id.description }}</td>
                        <td>{{ item.unit_id.description }}</td>
                        <td><span
                            :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                                {{ item.state_id.description }}</span>
                        </td>
                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button data-toggle="tooltip" data-placement="top" title="Editar registro"
                                        @click.prevent="setEdit(item)" class="btn btn-warning mx-1"><i
                                    class="fas fa-pencil-alt"></i></button>
                                <button data-toggle="tooltip" data-placement="top" title="Eliminar registro"
                                        class="btn btn-danger mx-1" @click.prevent="destroy(item, index)"><i
                                    class="fas fa-trash"></i></button>
                            </div>
                        </td>
                        </tbody>
                    </table>

                </div>
                <div class="card-footer text-center">
                    <div class="float-right">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" :class="disabledPrev">
                                    <button @click="prevPage" class="page-link"
                                    >Anterior
                                    </button
                                    >
                                </li>
                                <li
                                    v-for="pageNumber in pages.slice(
                                page - 1 ,
                                page + 4
                            )"
                                    :key="pageNumber"
                                    class="page-item"
                                >
                                    <button
                                        @click="currentPage($event, pageNumber)"
                                        class="page-link"

                                    >
                                        {{ pageNumber }}
                                    </button
                                    >
                                </li>
                                <li class="page-item" :class="disabledNext">
                                    <button @click="nextPage" class="page-link"
                                    >Siguiente
                                    </button
                                    >
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="float-left mt-2">
                        <h5>Mostrando {{ from }} a {{ to }} de {{ setPaginate.length }} registros</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "TestComponent",
        data: function () {
            return {
                search_item: '',
                editing: false,
                createRegister: false,
                id: '',
                description: '',
                loinc_id: '',
                loinc_code: '',
                loinc_name: '',
                loinc_sample: '',
                check: {
                    loinc: {
                        code: '',
                        name: '',
                        sample: ''
                    }
                },
                selectInfinityTest: [],
                infinity_test_id: '',
                selectMethod: [],
                method_id: '',
                selectUnit: [],
                unit_id: '',
                selectState: [],
                state_id: 1,
                tests: [],
                pages: [],
                page: 1,
                perPage: 10,
                disabledPrev: 'disabled',
                disabledNext: ''
            }
        },
        created() {
            this.getTest()
            this.getInfinityTest()
            this.getMethod()
            this.getUnit()
            this.getState()

        },
        mounted() {

        },
        watch: {
            loinc_code() {
                if (!this.editing) {
                    this.loinc_id = ''
                    this.loinc_name = ''
                    this.loinc_sample = ''
                }
            },
            page() {
                this.isPrevDisabled();
                this.isNextDisabled();

            },
            filterData() {

                this.pages = []
                this.page = 1
                this.setPages();
            },
            pages() {
                if (this.pages.length <= 1) {
                    this.disabledNext = 'disabled'
                } else {
                    this.disabledNext = ''
                }
            }
        },
        computed: {
            filterData() {
                const filtered = this.tests.filter((test) => {
                    const test_infinity = test.infinity_test_id.description + " - " + test.infinity_test_id.code
                    return test.description.toLowerCase().match(this.search_item.toLowerCase()) ||
                        test_infinity.toLowerCase().match(this.search_item.toLowerCase()) ||
                        test.method_id.description.toLowerCase().match(this.search_item.toLowerCase()) ||
                        test.unit_id.description.toLowerCase().match(this.search_item.toLowerCase()) ||
                        test.state_id.description.toLowerCase().match(this.search_item.toLowerCase())

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
                    return (this.page * this.setPaginate.length) - this.perPage
                }

            },
            to() {
                if (this.page === 1) {

                    return this.setPaginate.length

                }
                return this.page * this.perPage
            }

        },
        methods: {
            currentPage(event, page) {
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
                    this.disabledPrev = ""
                } else {
                    this.disabledPrev = "disabled"
                }
            },
            isNextDisabled() {
                if (this.page < this.pages.length) {
                    this.disabledNext = ""
                } else {
                    this.disabledNext = "disabled"
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
            setCreateRegister() {
                this.createRegister = true
            },
            async save() {
                if (this.validateInput()) {
                    const params = {
                        'loinc_id': this.loinc_id,
                        'description': this.description,
                        'infinity_test_id': this.infinity_test_id,
                        'method_id': this.method_id,
                        'unit_id': this.unit_id,
                        'state_id': this.state_id
                    }
                    const response = await axios.post('/api/test', params)
                    toast.fire({
                        icon: 'success',
                        title: 'Registro creado exitosamente'
                    });

                    this.tests.push(response.data.test)
                    this.createRegister = false
                    this.resetForm();
                }
            },
            async edit() {
                if (this.validateInput()) {
                    const params = {
                        'id': this.id,
                        'loinc_id': this.loinc_id,
                        'description': this.description,
                        'infinity_test_id': this.infinity_test_id,
                        'method_id': this.method_id,
                        'unit_id': this.unit_id,
                        'state_id': this.state_id
                    }

                    const response = await axios.put(`/api/test/${this.id}`, params)

                    if (response.status === 200) {
                        console.log(response)
                        toast.fire({
                            icon: 'success',
                            title: 'El registro ha sido editado exitosamente'
                        });

                        const index = this.tests.findIndex(find => find.id === response.data.id)
                        this.tests.splice(index, 1, response.data)

                        this.resetForm()

                        this.editing = false
                    } else {
                        toast.fire({
                            icon: 'error',
                            title: 'Ha ocurrido un error. Contacte al administrador'
                        });
                    }
                }
            },
            cancelCreate() {
                this.createRegister = false
                this.editing = false
                this.resetForm()
            },
            resetForm() {
                this.id = ''
                this.description = ''
                this.loinc_code = ''
                this.loinc_id = ''
                this.loinc_name = ''
                this.loinc_sample = ''
                this.infinity_test_id = ''
                this.method_id = ''
                this.unit_id = ''
                this.state_id = 1

            },
            validateInput() {
                if (this.description === '' ||
                    this.loinc_id === '' ||
                    this.infinity_test_id === '' ||
                    this.method_id === '' ||
                    this.unit_id === ''
                ) {
                    toast.fire({
                        icon: 'error',
                        title: 'Complete los campos necesarios'
                    });
                    return false;
                } else {
                    return true;
                }
            },
            setEdit(item) {
                this.id = item.id
                this.description = item.description
                this.infinity_test_id = item.infinity_test_id.id
                this.method_id = item.method_id.id
                this.unit_id = item.unit_id.id
                this.state_id = item.state_id.id
                this.loinc_code = item.loinc_id.loinc_num
                this.loinc_id = item.loinc_id.id
                this.loinc_name = item.loinc_id.long_common_name
                this.loinc_sample = item.loinc_id.system_
                this.editing = true
            },
            async destroy(item, index) {
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
                        axios.delete(`/api/test/${item.id}`)
                            .then(res => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Registro eliminado exitosamente'
                                });
                                const response = this.tests.filter(function (obj) {
                                    if (obj.id !== item.id) {
                                        return obj
                                    }
                                })

                                this.tests = response;

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
            getTest() {
                fetch('/api/test')
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('Error en el backend')
                        }
                    })
                    .then(json => {
                        this.tests = json.tests
                    })
                    .catch(error => console.log(error))
            },
            getState() {
                fetch('/api/state')
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('Error en el backend')
                        }
                    }).then(json => {
                    const res = json.map(function (obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    console.log(res)
                    this.selectState = res
                }).catch(error => console.log(error))
            },
            getUnit() {
                fetch('/api/unit')
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('Error en el backend')
                        }
                    }).then(json => {
                    const res = json.map(function (obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    this.selectUnit = res;
                }).catch(error => console.log(error))
            },
            getInfinityTest() {
                fetch('/api/infinityTest')
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('Error en el backend')
                        }
                    }).then(json => {
                    let res = json.map(function (obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.code + ' - ' + obj.description
                        return newObj;
                    })

                    this.selectInfinityTest = res;
                }).catch(error => {
                    console.log(error.message)
                })

            },
            getMethod() {
                fetch('/api/method')
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('Error en el backend')
                        }
                    }).then(json => {
                    const res = json.map(function (obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    this.selectMethod = res;
                }).catch(error => console.log(error.message))
            },
            search_loinc() {
                fetch(`/api/loinc/${this.loinc_code}`)
                    .then(res => {
                        if (res.ok) {
                            return res.json()
                        } else {
                            throw Error('No se encuentra el código')
                        }

                    }).then(json => {
                    this.loinc_name = json.long_common_name;
                    this.loinc_sample = json.system_;
                    this.loinc_id = json.id

                }).catch(error => {
                    toast.fire({
                        icon: 'error',
                        title: 'Código LOINC no encontrado'
                    });
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
