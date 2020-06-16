<template>
    <div class="card my-2">
        <div class="card-header bg-secondary">
            <div
                class="input-group input-group-sm card-title"
                style="width: 150px;"
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
                        v-model="search_analyte"
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
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Pruebas</th>
                        <th scope="col">Area de trabajo</th>
                        <th scope="col">Creado por</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in setPaginate" :key="item.id">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{ item.description }}</td>
                        <td>
                            <div v-for="test in item.tests" :key="test.id">
                                {{ test.description }}
                            </div>
                        </td>
                        <td>{{ item.work_area.description }}</td>
                        <td>{{ item.updated_user.name }}</td>
                        <td>{{ item.updated_at }}</td>

                        <td class="text-center py-1 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a
                                    @click.prevent="seeMore(item)"
                                    class="btn btn-warning mx-1"
                                    data-toggle="modal"
                                    data-target="#exampleModalCenter"
                                    href="#"
                                    ><i class="fas fa-eye"></i
                                ></a>
                            </div>
                        </td>
                    </tr>
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

        <!-- Modal -->
        <div
            class="modal fade"
            id="exampleModalCenter"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-centered"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            {{ analyte.description }}
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>DATOS EXAMEN</h5>
                        <ul>
                            <li>
                                <p>
                                    <b>PRESTACIÓN PRINCIPAL: </b>
                                    {{
                                        analyte.analyte_sample_container
                                            .main_analyte.description
                                    }}
                                </p>
                            </li>
                            <li>
                                <dt>DATOS LOINC</dt>
                                <dd>
                                    <b>Código: </b>
                                    {{ analyte.loinc.loinc_num }}
                                </dd>
                                <dd>
                                    <b>Nombre: </b>
                                    {{ analyte.loinc.long_common_name }}
                                </dd>
                            </li>
                            <li>
                                <dt>DATOS FONASA</dt>
                                <dd>
                                    <b>Código: </b>
                                    {{ analyte.fonasa_test.code }}
                                    <b>Nombre: </b>
                                    {{ analyte.fonasa_test.description }}
                                </dd>
                            </li>
                            <li>
                                <p>
                                    <b>TIPO MUESTRA: </b>
                                    {{
                                        analyte.analyte_sample_container
                                            .sample_collection_method.sample
                                            .description
                                    }}
                                </p>
                            </li>
                            <li>
                                <p>
                                    <b>OBTENCIÓN: </b>
                                    {{
                                        analyte.analyte_sample_container
                                            .sample_collection_method
                                            .collection_method.description
                                    }}
                                </p>
                            </li>
                            <li>
                                <dt>INFORMACIÓN CLÍNICA</dt>
                                <dd alig="justify">
                                    {{ analyte.observation }}
                                </dd>
                            </li>
                            <li>
                                <dt>DATOS LIS</dt>
                                <dd>
                                    <b>Código HCA: </b>
                                    Interno:
                                    {{ analyte.hca_laboratory.internal_code }} |
                                    Externo:
                                    {{ analyte.hca_laboratory.external_code }} |
                                    Nombre:
                                    {{ analyte.hca_laboratory.description }}
                                </dd>
                                <dd>
                                    <b>Código Labdate </b>
                                    {{ analyte.infinity_labdate_test.code }} |
                                    {{
                                        analyte.infinity_labdate_test
                                            .description
                                    }}
                                </dd>
                            </li>
                            <li>
                                <p>
                                    <b>CONTENEDOR:</b>
                                    {{
                                        analyte.analyte_sample_container
                                            .container.description
                                    }}
                                </p>
                            </li>

                            <li>
                                <p>
                                    <b>TIEMPO DE PROCESO:</b>
                                    {{ analyte.time_process.description }}
                                </p>
                            </li>

                            <li>
                                <p>
                                    <b>TIEMPO DE RECEPCIÓN:</b>
                                    {{ analyte.time_reception.description }}
                                </p>
                            </li>

                            <li>
                                <p>
                                    <b>TIEMPO DE RESPUESTA:</b>
                                    {{ analyte.time_response.description }}
                                </p>
                            </li>
                            <li>
                                <b>Condiciones toma de muestra</b>
                                <p
                                    v-for="(sampleCondition,
                                    index) in analyte.sample_conditions"
                                >
                                    {{ index + 1 }} -
                                    {{ sampleCondition.description }}
                                </p>
                            </li>

                            <li>
                                <p>
                                    <b>AREA DE TRABAJO:</b>
                                    {{ analyte.work_area.description }}
                                </p>
                            </li>

                            <li>
                                <p>
                                    <b>¿REQUIERE CLAVE VIH?</b>
                                    {{ analyte.vih_key.description }}
                                </p>
                            </li>
                        </ul>

                        <h5>DATOS PRUEBAS</h5>
                        <ol>
                            <li v-for="test in analyte.tests" :key="test.id">
                                <dt>{{ test.description }}</dt>
                                <ul>
                                    <li>
                                        <p>
                                            <b>MÉTODO: </b>
                                            {{ test.method.description }}
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <b>UNIDAD: </b>
                                            {{ test.unit.description }}
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <b>LOINC: </b>
                                            {{ test.loinc.loinc_num }} |
                                            {{ test.loinc.long_common_name }}
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <b>PRUEBA LIS: </b>
                                            {{ test.infinity_test.code }} |
                                            {{ test.infinity_test.description }}
                                        </p>
                                    </li>
                                    <li v-if="test.reference_ranges.length > 0">
                                        <dt>RANGO REFERENCIA:</dt>
                                        <ol>
                                            <li
                                                v-for="reference in test.reference_ranges"
                                                :key="reference.id"
                                            >
                                                <p>
                                                    <span
                                                        >{{
                                                            reference.type_value
                                                        }}
                                                        |</span
                                                    >
                                                    <span>
                                                        {{
                                                            reference.gender
                                                                .description
                                                        }}
                                                        |
                                                    </span>

                                                    <span
                                                        v-if="
                                                            reference.age_start !==
                                                                0 &&
                                                                reference.age_end !==
                                                                    999
                                                        "
                                                    >
                                                        {{
                                                            reference.age_start
                                                        }}
                                                        -
                                                        {{ reference.age_end }}
                                                    </span>
                                                    <span
                                                        >TODAS LAS EDADES</span
                                                    >
                                                    <span
                                                        v-if="
                                                            reference.age_start !==
                                                                0 &&
                                                                reference.age_end !==
                                                                    999
                                                        "
                                                    >
                                                        {{
                                                            reference.age_unit
                                                                .description
                                                        }}
                                                        |
                                                    </span>
                                                    <span> | </span>
                                                    <span
                                                        v-if="
                                                            reference.type_value ===
                                                                'CUALITATIVO'
                                                        "
                                                    >
                                                        {{
                                                            reference.cualitative_value
                                                        }}
                                                        |

                                                        {{
                                                            reference.test.unit
                                                                .description
                                                        }}
                                                    </span>
                                                    <span v-else>
                                                        <p>
                                                            <b>VR Normal: </b
                                                            >{{
                                                                reference.normal_minimum
                                                            }}
                                                            -
                                                            {{
                                                                reference.normal_maximum
                                                            }}

                                                            {{
                                                                reference.test
                                                                    .unit
                                                                    .description
                                                            }}
                                                        </p>
                                                        <p
                                                            v-if="
                                                                reference.critical_minimum
                                                            "
                                                        >
                                                            <b>VR crítico:</b>
                                                            {{
                                                                reference.critical_minimum
                                                            }}
                                                            -
                                                            {{
                                                                reference.critical_maximum
                                                            }}
                                                            {{
                                                                reference.test
                                                                    .unit
                                                                    .description
                                                            }}
                                                        </p>
                                                        <p
                                                            v-if="
                                                                reference.test
                                                                    .interpretation
                                                            "
                                                        >
                                                            <b
                                                                >Interpretación:
                                                            </b>
                                                            {{
                                                                reference.test
                                                                    .interpretation
                                                            }}
                                                        </p>
                                                    </span>
                                                </p>
                                            </li>
                                        </ol>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button
                            id="closeModalButton"
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            CERRAR
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="validateAnalyte"
                        >
                            VALIDAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            collections: {
                analytes: []
            },
            analyte: {
                fonasa_test: {},
                loinc: {},
                analyte_sample_container: {
                    sample_collection_method: {
                        sample: {},
                        collection_method: {}
                    },
                    main_analyte: {},
                    container: {}
                },
                hca_laboratory: {},
                infinity_labdate_test: {},
                work_area: {},
                time_response: {},
                time_reception: {},
                time_process: {},
                vih_key: {},
                sample_conditions: [],
                tests: [
                    {
                        description: '',
                        infinity_test: {},
                        loinc: {},
                        method: {},
                        pivot: {},
                        unit: {},
                        reference_ranges: [
                            {
                                age_unit: {},
                                gender: {},
                                test: {
                                    unit: {}
                                }
                            }
                        ]
                    }
                ]
            },
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: '',
            search_analyte: ''
        }
    },
    mounted: function() {
        this.fetchAnalyteTest()
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
    computed: {
        setPaginate() {
            return this.paginate(this.filterData)
        },
        filterData() {
            return this.collections.analytes.filter(analyte => {
                console.log(analyte)
                return (
                    analyte.description
                        .toLowerCase()
                        .match(this.search_analyte.toLowerCase()) &&
                    analyte.is_checked === 0
                )
            })
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
    methods: {
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
            let numberOfPages = Math.ceil(this.filterData.length / this.perPage)
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
        fetchAnalyteTest: async function() {
            try {
                const response = await fetch('/api/analyte')

                if (response.status === 200) {
                    const json = await response.json()

                    this.collections.analytes = json.analytes
                }
            } catch (error) {
                console.log(error)
            }
        },
        seeMore(item) {
            this.analyte = item
        },
        validateAnalyte(item) {
            const button = document.getElementById('closeModalButton')

            console.log(button)
            // is_checked: 2 eliminado
            // is_checked: 1 aprobado
            // is_checked: 0 en revisión
            const analyteParams = {
                is_checked: 1
            }

            const responseAnalyte = axios
                .put(`/api/analyte/check/${this.analyte.id}`, analyteParams)
                .then(response => {
                    this.analyte.is_checked = 1
                    button.click()
                    console.log(response)
                })
        }
    }
}
</script>

<style scoped></style>
