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
                            <div class="col-sm-5 col-md-5 col-5">
                                <div class="form-group">
                                    <input type="hidden" v-model="id">
                                    <label>Descripción: </label>
                                    <input v-model="description" :class="checkDescription" type="text"
                                           class="form-control"
                                           placeholder="descripcion"
                                    >
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-4">
                                <div class="form-group">
                                    <label>Estado: </label>
                                    <select2 v-if="states.length" :options="states"
                                             v-model="selectedState"
                                    ></select2>
                                </div>
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
                    <h3 class="card-title">Listado general</h3>
                    <div class="card-tools">
                        <button v-if="!editing" @click="setFormContent" type="button"
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
                            <th scope="col">Descripción</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                            </thead>
                            <tbody v-for="(item, index) in setPaginate">
                            <th scope="row">{{ item.id}}</th>
                            <td>{{ item.description}}</td>
                            <td><span
                                :class="item.state_id.id === 1 ? 'badge badge-success':'badge badge-danger'">
                            {{ item.state_id.description }}</span>
                            </td>
                            <td class="text-center py-1 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button @click.prevent="setEdit(item)" class="btn btn-warning mx-1" href="#"><i
                                        class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger mx-1" href="#" @click.prevent="destroy(item, index)">
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
        name: "GenderComponent",
        data: function () {
            return {
                progress: 0,
                titleCard: '',
                search_item: '',
                states: [],
                selectedState: 1,
                genders: [],
                description: '',
                checkDescription: '',
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
            this.getGender();
            this.getState();

        },
        computed: {
            filterData() {
                const filtered = this.genders.filter((gender) => {
                    return gender.description.toLowerCase().match(this.search_item.toLowerCase());

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
            startProgressiveBar() {
                let width = 0;
                const vm = this
                let progress = setInterval(function () {
                    if (vm.progress <= 99) {
                        vm.progress += width
                        width += 0.1;
                    }
                    if (vm.genders.length) {
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
            async getGender() {
                try {
                    let response = await fetch('/api/gender');
                    let json = await response.json();
                    this.genders = json.genders;

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
                        description: this.description,
                        state_id: this.selectedState
                    };

                    try {
                        const response = await axios.post('/api/gender', params);

                        if (response.status === 200) {
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido creado exitosamente'
                            });
                            this.genders.push(response.data.gender)
                            this.resetForm()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }
            },
            setEdit(item) {

                this.titleCard = 'Editar registro'
                this.id = item.id;
                this.description = item.description;
                this.selectedState = item.state_id.id;
                this.editing = true;
                this.formContent = true;

            },
            async edit() {
                if (this.validateInput()) {
                    const params = {
                        description: this.description,
                        state_id: this.selectedState
                    };

                    try {
                        const response = await axios.put(`/api/gender/${this.id}`, params)

                        if (response.status === 200) {
                            const index = this.genders.findIndex(find => find.id === response.data.gender.id)
                            console.log(index)
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido editado exitosamente'
                            });
                            this.genders.splice(index, 1, response.data.gender)
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
                        const response = await axios.delete(`/api/gender/${item.id}`);

                        if (response.status === 200) {
                            toast.fire({
                                icon: 'success',
                                title: 'El registro ha sido eliminado exitosamente'
                            });
                            this.genders.splice(index, 1);
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }
            },
            resetForm() {
                this.description = '';
                this.selectedState = 1;
                this.id = '';
                this.formContent = false;
                this.editing = false;
            },
            validateInput() {
                if (this.description === '' || this.selectedState === 0) {

                    if (this.description === '') {
                        this.checkDescription = 'is-invalid'
                    } else {
                        this.checkDescription = 'is-valid'
                    }
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
