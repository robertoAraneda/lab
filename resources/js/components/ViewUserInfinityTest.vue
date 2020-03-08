<template>
    <div>
        <div class="card mt-2 card-primary card-outline ">
            <div class="card-header">
                <h3 class="card-title">
                    Seleccione un supergrupo
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-10 col-sm-10">
                        <div class="form-group">
                            <label>
                                Supergrupo
                            </label>
                            <select2
                                name="SUPERGRUPO:"
                                :options="selectSupergroup"
                                v-model="supergroup"
                            >
                            </select2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 col-sm-10">
                        <div class="form-group">
                            <label v-if="infinityGroups.length">
                                Grupo
                            </label>
                            <select2 v-if="infinityGroups.length" name="GRUPO:" :options="infinityGroups"
                                     v-model="group">
                            </select2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12"></div>
                </div>
            </div>
        </div>
        <div
            v-if="infinityTests.length"
            class="card card-primary card-outline card-outline-tabs"
        >
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Listado de pruebas
                </h3>
                <span class="float-right text-bold">Registros totales: {{ infinityTests.length }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-sm-5">
                        <div
                            class="nav flex-column nav-tabs h-100"
                            id="vert-tabs-tab"
                            role="tablist"
                            aria-orientation="vertical"
                        >
                            <a
                                v-for="infinityTest in displayedData"
                                :key="infinityTest.id"
                                @click="showTest($event, infinityTest.id)"
                                class="nav-link navlink"
                                href="#"
                                data-toggle="pill"
                                role="tab"
                                :aria-controls="'vert-tabs-' + infinityTest.id"
                                :aria-selected="ariaSelected"
                            >{{ infinityTest.code }} -
                                {{ infinityTest.description }}</a
                            >
                        </div>
                    </div>
                    <div class="col-7 col-sm-7">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            <div
                                v-for="infinityTest in displayedData"
                                :key="infinityTest.id"
                                class="tab-pane fade"
                                :id="'vert-tabs-' + infinityTest.id"
                                role="tabpanel"
                            >
                                <dl class="dl-horizontal">
                                    <dt>Nombre</dt>
                                    <dd>
                                        {{ infinityTest.description }}
                                    </dd>
                                    <dt>Código</dt>
                                    <dd>
                                        {{ infinityTest.code }}
                                    </dd>
                                    <dt>Tipo de tubo</dt>
                                    <dd>
                                        {{
                                        infinityTest
                                        .infinity_type_tube
                                        .description
                                        }}
                                    </dd>
                                    <dt>
                                        Tipo de muestra
                                    </dt>
                                    <dd>
                                        {{
                                        infinityTest
                                        .infinity_type_tube
                                        .infinity_sample.description
                                        }}
                                    </dd>
                                    <dt>
                                        Código Etiqueta
                                    </dt>
                                    <dd v-if="infinityTest
                                        .infinity_type_tube.label !== null">
                                        {{
                                        infinityTest
                                        .infinity_type_tube.label
                                        .code
                                        }}
                                    </dd>
                                    <dd v-else> -</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
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
                                page - 1,
                                page + 5
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
        </div>
        <div v-else>
            <div v-if="infinityGroups.length && group !== 0" class="d-flex justify-content-center">
                <p class="lead">No existen pruebas asociadas al grupo seleccionado</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                supergroup: "",
                group: 0,
                collections: {
                    infinitySuperGroups: [],
                    infinityGroups: [],
                    infinityTests: []
                },
                selectSupergroup: [],
                ariaSelected: false,
                pages: [],
                page: 1,
                perPage: 5,
                disabledPrev: 'disabled',
                disabledNext: ''
            };
        },
        watch: {
            supergroup() {
                this.getInfinityGroupBySuperGroup();
                this.collections.infinityGroups = [];
                this.collections.infinityTests = [];
                this.pages = [];
                this.page = 1;
                this.group = 0;
            },
            group() {
                this.getInfinityTestByGroup();
                this.pages = [];
                this.page = 1;
            },
            infinityTests() {
                if (this.infinityTests.length !== 0) {
                    this.setPages();
                }

            },
            page() {
                this.isPrevDisabled();
                this.isNextDisabled();
            }
        },
        created() {
            this.getSupergroup();
        },
        computed: {
            displayedData() {
                return this.paginate(this.infinityTests);
            },
            infinityGroups() {
                return this.collections.infinityGroups.map(infinityGroup => {
                    return {
                        id: infinityGroup.id,
                        text: `${infinityGroup.code} | ${infinityGroup.description}`
                    }
                });
            },
            infinityTests() {
                return this.collections.infinityTests;
            }
        },
        methods: {
            async getInfinityGroupBySuperGroup() {

                try {
                    const response = await fetch(`/api/infinitySupergroup/${this.supergroup}`);
                    const json = await response.json()
                    this.collections.infinityGroups = json.infinitySuperGroup.infinity_groups;
                } catch (error) {
                    swal.fire({
                        icon: 'error',
                        title: error.message,
                        text: 'Error grave. Contacte a desarrollo informático'
                    })
                }
            },
            async getInfinityTestByGroup() {

                try {
                    const response = await fetch(`/api/infinityGroup/${this.group}`);

                    const json = await response.json();

                    if (json.infinityGroup.length) {
                        const infinityTests = await json.infinityGroup[0].infinity_tests;

                        if (infinityTests.length) {
                            this.collections.infinityTests = infinityTests
                        } else {
                            this.collections.infinityTests = []
                        }
                    } else {
                        this.collections.infinityTests = []
                    }
                } catch (error) {
                    swal.fire({
                        icon: 'error',
                        title: error.message,
                        text: 'Error grave. Contacte a desarrollo informático'
                    })
                }


            },
            currentPage(event, page) {
                console.log(event)
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
            getSupergroup() {
                const data = axios.get("/api/infinitySupergroup").then(response => {

                    this.selectSupergroup = this.parseSelect(response.data);
                }).catch(error => console.log(error));
            },
            setPages() {
                let numberOfPages = [];
                numberOfPages = Math.ceil(this.infinityTests.length / this.perPage);
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
            showTest(event, test) {
                let tabcontent, navlink;

                tabcontent = document.getElementsByClassName("tab-pane");

                for (let i = 0; i < tabcontent.length; i++) {

                    tabcontent[i].classList.remove("text-left");
                    tabcontent[i].classList.remove("show");
                    tabcontent[i].classList.remove("active");
                }

                navlink = document.getElementsByClassName("navlink");

                for (let i = 0; i < navlink.lenght; i++) {
                    navlink[i].className = element.className.replace(" active", "");
                }

                const div = document.getElementById("vert-tabs-" + test);
                div.classList.add("text-left");
                div.classList.add("show");
                div.classList.add("active");
                this.ariaSelected = true;
            },
            parseSelect(data) {
                let newData = [];
                newData.push({
                    id: 0,
                    text: "Seleccione:"
                });
                if (data) {
                    const setdata = data.forEach(element => {
                        let obj = null;
                        if (element.code === undefined) {
                            obj = {
                                id: element.id,
                                text: element.description
                            };
                        } else {
                            obj = {
                                id: element.id,
                                text: element.code + " - " + element.description
                            };
                        }

                        newData.push(obj);
                    });
                }
                return newData;
            },
            getPages(array) {
                const perpage = array / this.perPage;
                return perpage;
            }
        }
    };
</script>

<style scoped></style>
