<template>
    <div>
        <div v-if="!contentReady">
            <div class="progress">
                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar"
                     :aria-valuenow="(progress).toFixed(1)" aria-valuemin="0" aria-valuemax="100"
                     :style="{width: (progress).toFixed(1) + '%'}">
                    {{ (progress).toFixed(1) }}%
                    <span class="sr-only">{{ (progress).toFixed(1) }}% Complete (success)</span>
                </div>
            </div>
        </div>
        <div v-if="contentReady">
            <div v-if="formContent" class="card mt-2 card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ titleCard }}</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-8">
                                <input type="hidden" v-model="id">
                                <div class="form-group">
                                    <label>Prueba:</label>
                                    <select2 v-if="tests.length" :options="tests"
                                             v-model="selectedTest"
                                    ></select2>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-2 col-8">
                                <div class="form-group">
                                    <label>Unidad edad:</label>
                                    <select2 v-if="ageUnits.length" :options="ageUnits"
                                             v-model="selectedAgeUnit"
                                    ></select2>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 col-8">
                                <div class="form-group">
                                    <label>Género:</label>
                                    <select2 v-if="genders.length" :options="genders"
                                             v-model="selectedGender"
                                    ></select2>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 col-8">
                                <div class="form-group">
                                    <label>Estado:</label>
                                    <select2 v-if="states.length" :options="states"
                                             v-model="selectedState"
                                    ></select2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-4">
                                <label>Edad: </label>
                            </div>
                            <div class="col-sm-4 col-md-4 col-4">
                                <label>Rango referencia normal: </label>
                            </div>
                            <div class="col-sm-4 col-md-4 col-4">
                                <label>Rango referencia critico </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-4 form-group">
                                <input v-model="ageStart" type="text"
                                       class="form-control mb-1"
                                       placeholder="Edad mínimo"
                                >
                                <input v-model="ageEnd" type="text"
                                       class="form-control"
                                       placeholder="Edad máximo"
                                >
                            </div>
                            <div class="col-sm-4 col-md-4 col-4 form-group">
                                <input v-model="normalMinimun" type="text"
                                       class="form-control mb-1"
                                       placeholder="Valor mínimo"
                                >
                                <input v-model="normalMaximum" type="text"
                                       class="form-control"
                                       placeholder="Valor máximo"
                                >
                            </div>
                            <div class="col-sm-4 col-md-4 col-4 form-group">
                                <input v-model="criticalMinimun" type="text"
                                       class="form-control mb-1"
                                       placeholder="Valor mínimo"
                                >
                                <input v-model="criticalMaximum" type="text"
                                       class="form-control"
                                       placeholder="Valor máximo"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button v-if="!editing" @click.prevent="save"
                                class="btn btn-default float-right ml-2">
                            Guardar
                        </button>
                        <button v-if="editing" @click.prevent="edit"
                                class="btn btn-warning float-right ml-2">
                            Editar
                        </button>
                        <button @click.prevent="cancelButton" class="btn btn-danger float-right ">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
            <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <div class="card-tools">
                        <button v-if="!editing" @click="setFormContent" type="button"
                                class="btn btn-success float-right" data-toggle="tooltip" data-placement="top"
                                title="CREAR REGISTRO">
                            <i class="fas fa-plus"></i>
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
                            <input type="text" v-model="search_item" class="form-control float-right"
                                   placeholder="Buscar">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <th scope="col">#</th>
                            <th scope="col">Prueba</th>
                            <th scope="col">Tipo valor</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Valor normal</th>
                            <th scope="col">Valor crítico</th>
                            <th scope="col">Valor cualitativo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                            </thead>
                            <tbody v-for="(item, index) in setPaginate">
                            <th scope="row">{{ item.id}}</th>
                            <td>{{ item.test.description}}</td>
                            <td>{{ item.type_value }}</td>
                            <td>{{ item.age_start}} a {{ item.age_end}} {{ item.age_unit.description}}</td>
                            <td v-if="item.type_value === 'CUANTITATIVO'">{{ item.normal_minimum}} a {{ item.normal_maximum}} {{ item.test.unit.description}}</td>
                            <td v-else> - </td>
                            <td v-if="item.type_value === 'CUANTITATIVO'"><strong>Mínimo: </strong>{{ item.critical_minimum}} {{ item.test.unit.description}}
                                <br><strong>Máximo: </strong>{{ item.critical_maximum}} {{ item.test.unit.description}}
                            </td>
                            <td v-else> - </td>
                            <td v-if="item.type_value === 'CUANTITATIVO'"> - </td>
                            <td v-else>{{ item.cualitative_value }}</td>
                            <td><span v-if="isNaN(item.state_id)"
                                      :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.description }}</span>
                                <span v-else
                                      :class="item.state.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state.description }}</span>
                            </td>
                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button @click.prevent="setEdit(item)" class="btn btn-warning mx-1"
                                            data-toggle="tooltip" data-placement="top" title="EDITAR REGISTRO"><i
                                        class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger mx-1" data-toggle="tooltip" data-placement="top"
                                            title="ELIMINAR REGISTRO" @click.prevent="destroy(item, index)">
                                        <i
                                            class="fas fa-trash"></i></button>
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
                                            @click="currentPage(pageNumber)"
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

    </div>
</template>

<script>
    export default {
        name: "ReferenceRangeComponent",
        data: function () {
            return {
                progress: 0,
                titleCard: '',
                search_item: '',
                states: [],
                selectedState: 1,
                ageUnits: [],
                selectedAgeUnit: 0,
                tests: [],
                selectedTest: 0,
                genders: [],
                selectedGender: 0,
                referenceRanges: [],
                normalMinimun: '',
                normalMaximum: '',
                criticalMinimun: '',
                criticalMaximum: '',
                ageStart: '',
                ageEnd: '',
                id: '',
                editing: false,
                formContent: false,
                contentReady: false,
                pages: [],
                page: 1,
                perPage: 5,
                disabledPrev: 'disabled',
                disabledNext: ''
            }
        },
        created: function () {
            this.startProgressiveBar();
            this.getTest();
            this.getReferenceRange();
            this.getAgeUnit();
            this.getGender();
            this.getState();

        },
        computed: {
            filterData() {
                const filtered = this.referenceRanges.filter((referenceRange) => {

                    return referenceRange.test.description.toLowerCase().match(this.search_item.toLowerCase());

                })
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
                    return (this.page * this.setPaginate.length) - this.perPage;
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
                    this.disabledNext = 'disabled';
                } else {
                    this.disabledNext = '';
                }
            },
            perPage() {
                this.pages = [];
                this.page = 1;
                this.setPages();
            }
        },
        methods: {
            setValueResult(selected){
                if(selected.typeValue === 'CUALITATIVO')
                 return selected
            },
            startProgressiveBar() {
                let width = 0;
                const vm = this
                let progress = setInterval(function () {
                    if (vm.progress <= 99) {
                        vm.progress += width
                        width += 0.1;
                    }
                    if (vm.tests.length) {
                        vm.progress = 100
                        clearInterval(progress)
                        vm.contentReady = true;
                    }
                }, 300);

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
                this.titleCard = 'Crear nuevo registro';
                this.formContent = true;
            },
            async getState() {
                try {
                    let response = await fetch('/api/state');
                    let json = await response.json();
                    this.states = this.parseSelect(json);
                } catch (e) {
                    console.log(e);
                }
            },
            async getAgeUnit() {
                try {
                    let response = await fetch('/api/ageUnit');
                    let json = await response.json();
                    this.ageUnits = this.parseSelect(json.ageUnits);

                } catch (error) {
                    console.log(error)
                }

            },
            async getTest() {
                try {
                    let response = await fetch('/api/test');

                    let json = await response.json();

                    this.tests = this.parseSelect(json.tests);

                } catch (error) {
                    console.log(error)
                }

            },
            async getGender() {
                try {
                    let response = await fetch('/api/gender');

                    let json = await response.json();

                    this.genders = this.parseSelect(json.genders);

                } catch (error) {
                    console.log(error)
                }

            },
            async getReferenceRange() {
                try {
                    let response = await fetch('/api/referenceRange');

                    let json = await response.json();
                    this.referenceRanges = json.referenceRanges;

                } catch (error) {
                    console.log(error)
                }

            },
            parseSelect: function (array) {
                const res = array.map(function (obj) {
                    return {
                        id: obj.id,
                        text: obj.description
                    };
                })
                return res;
            },
            async save() {
                if (this.validateInput()) {
                    const params = {
                        test_id: this.selectedTest,
                        age_unit_id: this.selectedAgeUnit,
                        gender_id: this.selectedGender,
                        state_id: this.selectedState,
                        age_start: this.ageStart,
                        age_end: this.ageEnd,
                        normal_minimum: this.normalMinimun,
                        normal_maximum: this.normalMaximum,
                        critical_minimum: this.criticalMinimun,
                        critical_maximum: this.criticalMaximum
                    };

                    try {
                        const response = await axios.post('/api/referenceRange', params);

                        if (response.status === 200) {
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido creado exitosamente'
                            });

                            this.referenceRanges.push(response.data.referenceRange)
                            this.resetForm()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }
            },
            setEdit(item) {
                console.log(item)

                this.titleCard = 'Editar registro'
                this.id = item.id
                this.selectedTest = item.test.id;
                this.selectedAgeUnit = item.age_unit.id;
                this.selectedGender = item.gender.id;
                this.selectedState = item.state.id;
                this.normalMinimun = item.normal_minimum;
                this.normalMaximum = item.normal_maximum;
                this.criticalMinimun = item.critical_minimum;
                this.criticalMaximum = item.critical_maximum;
                this.ageStart = item.age_start;
                this.ageEnd = item.age_end;
                this.editing = true;
                this.formContent = true;

            },
            async edit() {
                if (this.validateInput()) {
                    const params = {
                        test_id: this.selectedTest,
                        age_unit_id: this.selectedAgeUnit,
                        gender_id: this.selectedGender,
                        state_id: this.selectedState,
                        age_start: this.ageStart,
                        age_end: this.ageEnd,
                        normal_minimum: this.normalMinimun,
                        normal_maximum: this.normalMaximum,
                        critical_minimum: this.criticalMinimun,
                        critical_maximum: this.criticalMaximum
                    };

                    try {
                        const response = await axios.put(`/api/referenceRange/${this.id}`, params)

                        if (response.status === 200) {
                            const index = this.referenceRanges.findIndex(find => find.id === response.data.referenceRange.id)
                            console.log(index)
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido editado exitosamente'
                            });
                            this.referenceRanges.splice(index, 1, response.data.referenceRange)
                            this.resetForm()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }
            },
            cancelButton() {
                this.editing = false;
                this.resetForm();
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
                });
                if (confirmation.value) {
                    try {
                        const response = await axios.delete(`/api/referenceRange/${item.id}`);

                        if (response.status === 200) {
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido eliminado exitosamente'
                            });
                            this.referenceRanges.splice(index, 1);
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }
            },
            resetForm() {
                this.id = '';
                this.selectedTest = 0;
                this.selectedAgeUnit = 0;
                this.selectedGender = 0;
                this.selectedState = 1;
                this.normalMinimun = '';
                this.normalMaximum = '';
                this.criticalMinimun = ''
                this.criticalMaximum = '';
                this.ageStart = '';
                this.ageEnd = '';
                this.formContent = false;
                this.editing = false;
            },
            validateInput() {
                if (this.selectedTest === 0 ||
                    this.selectedAgeUnit === 0 ||
                    this.selectedGender === 0 ||
                    this.selectedState === 0) {

                    toast.fire({
                        icon: 'error',
                        title: 'Complete los campos necesarios'
                    });
                    return false;
                } else {
                    return true;
                }
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
