<template>
    <v-card>
        <v-card-title class="text-center justify-space-between py-6">
            <h1 class="font-weight-bold headline secondary--text pl-4">
                {{ analyte.description }}
            </h1>
            <div class="justify-space-between">
                <v-chip color="blue darken-2" text-color="white">
                    {{ section.description }}
                </v-chip>
                <v-chip color="orange" text-color="white">
                    {{ work_area.description }}
                </v-chip>

                <v-chip
                    v-if="available.description === 'DISPONIBLE'"
                    color="green darken-2"
                    text-color="white"
                >
                    <v-avatar left>
                        <v-icon>mdi-checkbox-marked-circle</v-icon>
                    </v-avatar>
                    {{ available.description }}
                </v-chip>
                <v-chip v-else color="error" text-color="white">
                    <v-avatar left>
                        <v-icon>mdi-checkbox-marked-circle</v-icon>
                    </v-avatar>
                    {{ available.description }}
                </v-chip>
            </div>
        </v-card-title>
        <v-card class="p-3" flat>
            <v-card-title>
                <h1 class="font-weight-bold subtitle-1 secondary--text">
                    Codificación:
                </h1>
            </v-card-title>
            <v-card-text>
                <v-toolbar dense flat>
                    <v-toolbar-title class="text-body-1"
                        ><strong>LOINC</strong>: {{ loinc.loinc_num }} -
                        {{ loinc.long_common_name }}</v-toolbar-title
                    >

                    <v-spacer></v-spacer>

                    <v-btn icon>
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-toolbar dense flat>
                    <v-toolbar-title class="text-body-1"
                        ><strong>FONASA</strong>: {{ fonasa_test.code }} -
                        {{ fonasa_test.description }}</v-toolbar-title
                    >
                </v-toolbar>
            </v-card-text>
        </v-card>

        <v-tabs
            v-model="tab"
            background-color="orange lighten-3"
            color="secondary lighten-1"
            grow
            class="mt-5"
        >
            <v-tab v-for="item in items" :key="item">
                {{ item }}
            </v-tab>
            <v-tab-item>
                <v-card flat class="mx-10">
                    <v-card-text>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Utilidad clínica</v-subheader
                        >
                        <v-divider class="mt-n3" />
                        <p class="lead text-md" align="justify">
                            {{ analyte_.observation }}
                        </p>

                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Recepción y procesamiento</v-subheader
                        >
                        <v-divider class="mt-n3" />

                        <p class="lead text-md" align="justify">
                            La muestras se recepcionan en ventanilla del
                            laboratorio clínico, 7 Piso Torre Nueva en
                            <span class="font-weight-bold">
                                {{ time_reception.description }}</span
                            >
                            y se procesan en horario
                            <span class="font-weight-bold">
                                {{ time_process.description }}</span
                            >.
                        </p>

                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Tiempo de respuesta</v-subheader
                        >
                        <v-divider class="mt-n3" />

                        <p class="lead text-md" align="justify">
                            El tiempo de respuesta diferenciado es:
                        </p>

                        <v-row
                            class="lead text-md justify-space-between px-5"
                            v-if="analyte.analyte_time_response_detail !== null"
                        >
                            <v-col cols="12" sm="6" md="3" lg="3">
                                <v-card flat outlined>
                                    <v-toolbar dense color="primary" dark flat>
                                        <v-toolbar-title
                                            >Ambulatorio:</v-toolbar-title
                                        >
                                    </v-toolbar>
                                    <v-card-text>
                                        {{
                                            analyte.analyte_time_response_detail
                                                .time_response_amb.description
                                        }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6" md="3" lg="3">
                                <v-card flat outlined>
                                    <v-toolbar dense color="warning" dark flat>
                                        <v-toolbar-title
                                            >Hospitalizado:</v-toolbar-title
                                        >
                                    </v-toolbar>
                                    <v-card-text>
                                        {{
                                            analyte.analyte_time_response_detail
                                                .time_response_hosp.description
                                        }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6" md="3" lg="3">
                                <v-card flat outlined>
                                    <v-toolbar dense color="error" dark flat>
                                        <v-toolbar-title
                                            >Urgencia:</v-toolbar-title
                                        >
                                    </v-toolbar>
                                    <v-card-text>
                                        {{
                                            analyte.analyte_time_response_detail
                                                .time_response_urg.description
                                        }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6" md="3" lg="3">
                                <v-card flat outlined>
                                    <v-toolbar
                                        dense
                                        color="secondary"
                                        dark
                                        flat
                                    >
                                        <v-toolbar-title
                                            >Externo:</v-toolbar-title
                                        >
                                    </v-toolbar>
                                    <v-card-text>
                                        {{
                                            analyte.analyte_time_response_detail
                                                .time_response_ext.description
                                        }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat class="mx-10">
                    <v-card-text>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Tipo de muestra, obtención y
                            contenedor</v-subheader
                        >
                        <v-divider class="mt-n3" />

                        <p class="lead text-md" align="justify">
                            El tipo de muestra necesario para realizar este
                            examen es
                            <span class="font-weight-bold">
                                {{ sample.description }}</span
                            >, cuya obtención es preferentemente
                            <span class="font-weight-bold">
                                {{ collection_method.description }}</span
                            >
                            . La muestra debe ser tomada en un
                            <span class="font-weight-bold">
                                {{ container.description }}</span
                            >
                            .
                        </p>

                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Condiciones de toma de muestra</v-subheader
                        >
                        <v-divider class="mt-n3" />

                        <p class="lead text-md" align="justify">
                            Para una correcta toma de muestra debe considerar:
                        </p>

                        <v-list-item
                            class="lead text-md"
                            v-for="sampleCondition in filteredSampleConditions"
                            :key="sampleCondition.id"
                        >
                            <v-list-item-avatar>
                                <v-icon class="white success--text"
                                    >mdi-check-bold</v-icon
                                >
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ sampleCondition.description }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Solicitud médica</v-subheader
                        >
                        <v-divider class="mt-n3" />
                        <p class="lead text-md" align="justify">
                            Para solicitar el estudio de

                            {{ analyte.description }} es obligatorio completar
                            la
                            <span class="font-weight-bold">
                                {{ medical_order.description }}</span
                            >
                            .
                        </p>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat class="mx-10">
                    <v-card-text>
                        <div v-if="haveCritical.length !== 0">
                            <v-subheader
                                class="font-weight-bold subtitle-1 text-uppercase mt-3"
                                >Valor crítico</v-subheader
                            >
                            <v-divider class="mt-n3" />
                            <p class="lead text-md" align="justify">
                                Por definición, un valor critico es la
                                desviación de la condicion normal de un
                                paciente, reflejado en un resultado de examen de
                                laboratorio, lo suficientemente amplia como para
                                poner en riesgo la vida del paciente si no se
                                realizan acciones correctivas de manera
                                inmediata. Los valores críticos diferenciados
                                por pruebas son:
                            </p>
                            <p class="lead text-md" align="justify">
                                Los valores críticos diferenciados por pruebas
                                son:
                            </p>
                            <v-expansion-panels class="mb-6" flat>
                                <v-expansion-panel
                                    v-for="(test, i) in haveCritical"
                                    :key="i"
                                    class="mb-2"
                                >
                                    <v-expansion-panel-header
                                        color="red"
                                        expand-icon="mdi-menu-down"
                                    >
                                        <v-row
                                            align="center"
                                            class="spacer"
                                            no-gutters
                                        >
                                            <v-col cols="4" sm="2" md="1">
                                                <v-avatar
                                                    size="36px"
                                                    color="red darken-2"
                                                >
                                                    <span class="white--text">
                                                        {{ i + 1 }}</span
                                                    >
                                                </v-avatar>
                                            </v-col>

                                            <v-col sm="8" md="5">
                                                <strong
                                                    class="white--text"
                                                    v-html="test.description"
                                                ></strong>
                                            </v-col> </v-row
                                    ></v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <p class="lead text-md" align="justify">
                                            Valor crítico:
                                        </p>
                                        <v-simple-table>
                                            <template v-slot:default>
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            Genero
                                                        </th>
                                                        <th class="text-left">
                                                            Rango edad
                                                        </th>
                                                        <th class="text-left">
                                                            Rango normal
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(range,
                                                        i) in test.critical_ranges"
                                                        :key="i"
                                                    >
                                                        <td>
                                                            {{
                                                                range.gender
                                                                    .description
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                rangeAge(range)
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                rangeCriticalValue(
                                                                    range,
                                                                    test.unit
                                                                        .description
                                                                )
                                                            }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </template>
                                        </v-simple-table>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Valor normal</v-subheader
                        >
                        <v-divider class="mt-n3" />
                        <p class="lead text-md" align="justify">
                            Los valores de referencia diferenciados por pruebas
                            son:
                        </p>
                        <v-expansion-panels class="mb-6" flat>
                            <v-expansion-panel
                                v-for="(test, i) in tests"
                                :key="i"
                                class="mb-2"
                            >
                                <v-expansion-panel-header
                                    color="success"
                                    expand-icon="mdi-menu-down"
                                >
                                    <v-row
                                        align="center"
                                        class="spacer"
                                        no-gutters
                                    >
                                        <v-col cols="4" sm="2" md="1">
                                            <v-avatar
                                                size="36px"
                                                color="success darken-2"
                                            >
                                                <span class="white--text">
                                                    {{ i + 1 }}</span
                                                >
                                            </v-avatar>
                                        </v-col>

                                        <v-col sm="8" md="5">
                                            <strong
                                                class="white--text"
                                                v-html="test.description"
                                            ></strong>
                                        </v-col> </v-row
                                ></v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-simple-table>
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Genero
                                                    </th>
                                                    <th class="text-left">
                                                        Rango edad
                                                    </th>
                                                    <th class="text-left">
                                                        Rango normal
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(range,
                                                    i) in test.reference_ranges"
                                                    :key="i"
                                                >
                                                    <td>
                                                        {{
                                                            range.gender
                                                                .description
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{ rangeAge(range) }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            rangeValue(
                                                                range,
                                                                test.unit
                                                                    .description
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat class="mx-10">
                    <v-card-text>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Código de ingreso LIS</v-subheader
                        >
                        <v-divider class="mt-n3" />

                        <v-row
                            class="lead text-md justify-space-between px-5"
                            v-if="analyte.analyte_time_response_detail !== null"
                        >
                            <v-col cols="12" sm="6" md="4" lg="4">
                                <v-card flat outlined>
                                    <v-toolbar dense color="primary" dark flat>
                                        <v-spacer />
                                        <v-toolbar-title
                                            >SME HHHA</v-toolbar-title
                                        >
                                        <v-spacer />
                                    </v-toolbar>
                                    <v-card-text
                                        class="lead text-xl text-center"
                                    >
                                        <kbd>{{ loinc.loinc_num }} </kbd>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6" md="4" lg="4">
                                <v-card flat outlined>
                                    <v-toolbar dense color="primary" dark flat>
                                        <v-spacer />
                                        <v-toolbar-title
                                            >Labdate</v-toolbar-title
                                        >
                                        <v-spacer />
                                    </v-toolbar>
                                    <v-card-text
                                        class="lead text-xl text-center"
                                    >
                                        <kbd>{{ lis.code }} </kbd>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6" md="4" lg="4">
                                <v-card flat outlined>
                                    <v-toolbar dense color="primary" dark flat>
                                        <v-spacer />
                                        <v-toolbar-title
                                            >Infinity</v-toolbar-title
                                        >
                                        <v-spacer />
                                    </v-toolbar>
                                    <v-card-text
                                        class="lead text-xl text-center"
                                    >
                                        <kbd>{{ hca.internal_code }} </kbd>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-subheader
                            class="font-weight-bold subtitle-1 text-uppercase mt-3"
                            >Detalle pruebas</v-subheader
                        >
                        <v-divider class="mt-n3" />
                        <p class="lead text-md" align="justify">
                            Detalle pruebas contiene información acerca de la
                            metolología, codigos del estandar LOINC, unidades de
                            medida y relación con códigos de prueba del sistema
                            informático de laboratorio (LIS)
                        </p>

                        <v-expansion-panels class="mb-6">
                            <v-expansion-panel
                                v-for="(test, i) in tests"
                                :key="i"
                                class="mb-2"
                            >
                                <v-expansion-panel-header
                                    color="white"
                                    expand-icon="mdi-menu-down"
                                >
                                    <v-row
                                        align="center"
                                        class="spacer"
                                        no-gutters
                                    >
                                        <v-col cols="4" sm="2" md="1">
                                            <v-avatar
                                                size="36px"
                                                color="warning darken-2"
                                            >
                                                <span class="white--text">
                                                    {{ i + 1 }}</span
                                                >
                                            </v-avatar>
                                        </v-col>

                                        <v-col sm="8" md="5">
                                            <strong
                                                class="secondary--text"
                                                v-html="test.description"
                                            ></strong>
                                        </v-col> </v-row
                                ></v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <h5>
                                        Código LIS asociado:
                                        <span class="lead">{{
                                            test.infinity_test.code
                                        }}</span>
                                    </h5>
                                    <h5>
                                        Nombre LIS asociado:
                                        <span class="lead">{{
                                            test.infinity_test.description
                                        }}</span>
                                    </h5>
                                    <h5>
                                        LOINC:
                                        <span class="lead">{{
                                            test.loinc.long_common_name
                                        }}</span>
                                    </h5>
                                    <h5>
                                        Método:
                                        <span class="lead">{{
                                            test.method.description
                                        }}</span>
                                    </h5>
                                    <h5>
                                        Unidades:
                                        <span class="lead">{{
                                            test.unit.description
                                        }}</span>
                                    </h5>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs>
    </v-card>
</template>

<script>
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import axios from 'axios'

export default {
    props: ['analyte'],
    data() {
        return {
            tab: null,
            items: [
                'Información general',
                'Toma de muestra',
                'Valores de referencia',
                'Detalle laboratorio'
            ],
            text:
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            tests: this.analyte.tests,
            analyte_: this.analyte,
            loinc: this.analyte.loinc,
            main_analyte: this.analyte.analyteSampleContainer.main_analyte,
            sample: this.analyte.analyteSampleContainer.sample_collection_method
                .sample,
            collection_method: this.analyte.analyteSampleContainer
                .sample_collection_method.collection_method,
            container: this.analyte.analyteSampleContainer.container,
            labels: this.analyte.labels,
            indications: this.analyte.indications,
            sampleConditions: this.analyte.sample_conditions,
            hca: this.analyte.hca_laboratory,
            lis: this.analyte.infinity_labdate_test,
            available: this.analyte.available,
            vih_key: this.analyte.vih_key,
            time_process: this.analyte.time_process,
            time_reception: this.analyte.time_reception,
            time_response: this.analyte.time_response,
            medical_order: this.analyte.medical_order,
            fonasa_test: this.analyte.fonasa_test,
            work_area: this.analyte.work_area,
            section: this.analyte.work_area.section,
            state: this.analyte.state,

            testsCualitative: [],
            testsCuantitative: [],
            testsCritical: []
        }
    },
    computed: {
        haveCritical() {
            return this.analyte.tests.filter(
                test => test.critical_ranges.length !== 0
            )
        },
        isCritical() {
            let bool = false
            this.tests.forEach(test => {
                if (test.reference_ranges.length !== 0) {
                    test.reference_ranges.forEach(rangeReference => {
                        if (rangeReference.interpretation === 'VALOR CRITICO') {
                            this.testsCritical.push({
                                id: rangeReference.id,
                                test: rangeReference.test,
                                reference_range: rangeReference
                            })
                            bool = true
                        }
                    })
                }
            })

            return bool
        },
        filteredIndications() {
            return this.indications.sort(function(a, b) {
                if (a.pivot.order > b.pivot.order) {
                    return 1
                }
                if (a.pivot.order < b.pivot.order) {
                    return -1
                }
                return 0
            })
        },
        filteredSampleConditions() {
            return this.sampleConditions.sort(function(a, b) {
                if (a.pivot.order > b.pivot.order) {
                    return 1
                }
                if (a.pivot.order < b.pivot.order) {
                    return -1
                }
                return 0
            })
        },
        filteredTest() {
            let rangeReferenceByTest = []
            this.tests.forEach(test => {
                if (test.reference_ranges.length !== 0) {
                    test.reference_ranges.forEach(element => {
                        rangeReferenceByTest.push({
                            id: element.id,
                            test: element.test,
                            reference_range: element
                        })
                    })
                }
            })

            return rangeReferenceByTest
        },

        isCuantitative() {
            let bool = false
            this.tests.forEach(test => {
                if (test.reference_ranges.length !== 0) {
                    test.reference_ranges.forEach(rangeReference => {
                        if (
                            rangeReference.normal_minimum !== null ||
                            rangeReference.normal_maximum !== null
                        ) {
                            this.testsCuantitative.push({
                                id: rangeReference.id,
                                test: rangeReference.test,
                                reference_range: rangeReference
                            })
                            bool = true
                        }
                    })
                }
            })

            return bool
        },
        isCualitative() {
            let bool = false
            this.tests.forEach(test => {
                if (test.reference_ranges.length !== 0) {
                    test.reference_ranges.forEach(rangeReference => {
                        if (rangeReference.cualitative_value !== null) {
                            this.testsCualitative.push({
                                id: rangeReference.id,
                                test: rangeReference.test,
                                reference_range: rangeReference
                            })
                            bool = true
                        }
                    })
                }
            })

            return bool
        },
        filteredTestByType() {
            return this.analyte.tests.map(test => {
                return test.reference_ranges.reduce((accumulator, object) => {
                    let key = object.type_value
                    if (!accumulator[key]) {
                        accumulator[key] = []
                    }
                    accumulator[key].push(object)
                    return accumulator
                }, {})
            })
        }
    },
    //    async mounted(){

    // const response = await axios.get(`/api/referenceRange/findByTest/${id}`)
    //     },
    methods: {
        rangeAge(range) {
            const start = range.age_start
            const end = range.age_end
            const unit = range.age_unit.description

            if (start === 0 && end === 999) return 'Todas las edades'
            if (start === 0 && end !== 999) return `Menor a ${end} ${unit}`
            if (start !== 0 && end === 999) return `Mayor a ${start} ${unit}`
            if (start !== 0 && end !== 999) return `${start} a ${end} ${unit}`
        },
        rangeValue(range, unit) {
            const start = range.normal_minimum
            const end = range.normal_maximum

            if (start === null || end === null) {
                return range.cualitative_value
            }
            if (start === 0) return `Menor a ${end} ${unit}`
            if (end === 0) return `Mayor a ${start} ${unit}`
            if (start !== 0 && end !== 0) return `${start} a ${end} ${unit}`
        },
        rangeCriticalValue(range, unit) {
            const start = range.critical_minimum
            const end = range.critical_maximum

            if (start === null || end === null) {
                return range.critical_cualitative
            }
            if (start === 0) return `Menor a ${end} ${unit}`
            if (end === 0) return `Mayor a ${start} ${unit}`
            if (start !== 0 && end !== 0) return `${start} a ${end} ${unit}`
        },
        groupBy(objectArray, property) {
            return objectArray.reduce(function(accumulator, object) {
                if (!accumulator[property]) {
                    accumulator[property] = []
                }
                accumulator[property].push(object)
                return accumulator
            }, {})
        },
        downloadPDF() {
            const doc = this.createPDF()

            doc.html(document.getElementById('content'), {
                callback: function(pdf) {
                    var iframe = document.createElement('iframe')
                    iframe.setAttribute(
                        'style',
                        'position:absolute;right:0; top:0; bottom:0; height:100%; width:500px'
                    )
                    document.body.appendChild(iframe)
                    iframe.src = pdf.output('datauristring')
                }
            })
            doc.save('sample.pdf')
        },
        createPDF() {
            const doc = new jsPDF()

            doc.setTextColor(100)
            doc.text(20, 20, this.analyte_.description)

            doc.setTextColor(80)
            doc.text(20, 30, 'INFORMACIÓN CLÍNICA')
            doc.text(20, 40, this.main_analyte.information)

            return doc
        },
        filterCriticalRangeUnit(test) {
            if (test.reference_range.critical_minimum === null) {
                return null
            } else {
                return test.test.unit.description
            }
        }
    }
}
</script>

<style scoped>
.scrollspy-custom {
    position: relative;
}

.spy-over {
    position: relative;
    height: 600px;
    overflow: auto;
}
hr.style-one {
    border: 0;
    height: 2px;
    background: #5bc0de;
    background-image: -webkit-linear-gradient(left, #ccc, #5bc0de, #ccc);
    background-image: -moz-linear-gradient(left, #ccc, #5bc0de, #ccc);
    background-image: -ms-linear-gradient(left, #ccc, #5bc0de, #ccc);
    background-image: -o-linear-gradient(left, #ccc, #5bc0de, #ccc);
}
.my-icon {
    text-shadow: 0 0 1px #000;
}

/* Helper classes */
.basil {
    background-color: #fffbe6 !important;
}
.basil--text {
    color: #356859 !important;
}

hr.v-divider {
    border: orange solid 2px !important;
}

/* kbd {
    background-color: orange lighten-3 !important;
} */
</style>
