<template>
    <section class="p-5">
        <v-toolbar v-if="latestUpload" color="primary" dark dense>
            <v-toolbar-title class="subtitle-1"
                >Última actualización: {{ latestUpload.created_at }}
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-title class="subtitle-1"
                >Responsable:
                {{ latestUpload.created_user.name }}</v-toolbar-title
            >

            <v-spacer></v-spacer>
            <v-toolbar-title class="subtitle-1"
                >Nombre archivo: {{ latestUpload.file_name }}</v-toolbar-title
            >
        </v-toolbar>
        <!-- 
        <v-sheet
            class="v-sheet--offset mx-auto"
            color="white"
            elevation="12"
            max-width="calc(100% - 32px)"
        >
            <v-sparkline
                :labels="labels"
                :value="value"
                color="primary"
                line-width="1"
                padding="16"
            ></v-sparkline>
        </v-sheet> -->
        <v-card class="my-3">
            <v-toolbar color="primary" dark>
                <v-toolbar-title>
                    Frecuencia registro formularios COVID-19 en SMD
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-col cols="12" sm="6" md="4">
                    <v-dialog
                        ref="dialog"
                        v-model="modal"
                        :return-value.sync="date"
                        transition="scale-transition"
                        persistent
                        width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                class="mt-6"
                                v-model="date"
                                dense
                                solo-inverted
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            :allowed-dates="allowedDates"
                            v-model="date"
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="modal = false">
                                Cancelar
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="
                                    $refs.dialog.save(date)
                                    getChartRegisterRequest()
                                "
                            >
                                aceptar
                            </v-btn>
                        </v-date-picker>
                    </v-dialog>
                </v-col>
            </v-toolbar>
            <v-card-text>
                <tat-line-chart
                    :style="{ height: '250px' }"
                    v-if="loaded"
                    :chartdata="chartdata"
                    :options="options"
                ></tat-line-chart>
            </v-card-text>
        </v-card>

        <v-card class="my-3">
            <v-toolbar color="primary" dark>
                <v-toolbar-title>
                    Frecuencia validaciones COVID-19 en LIS
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-col cols="12" sm="6" md="4">
                    <v-dialog
                        ref="dialog2"
                        v-model="modal2"
                        :return-value.sync="date2"
                        transition="scale-transition"
                        persistent
                        width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                class="mt-6"
                                v-model="date2"
                                dense
                                solo-inverted
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            :allowed-dates="allowedDates"
                            v-model="date2"
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="modal2 = false">
                                Cancelar
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="
                                    $refs.dialog2.save(date2)
                                    getChartValidatedRequest()
                                "
                            >
                                aceptar
                            </v-btn>
                        </v-date-picker>
                    </v-dialog>
                </v-col>
            </v-toolbar>
            <v-card-text>
                <tat-line-chart
                    :style="{ height: '250px' }"
                    v-if="loaded2"
                    :chartdata="chartdata2"
                    :options="options2"
                ></tat-line-chart>
            </v-card-text>
        </v-card>
        <v-card class="mt-5" v-if="generalLaboratoriesPresidency.length !== 0">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title>Reporte presidencia </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title>Análisis diario corte 16:00</v-toolbar-title>
            </v-toolbar>
            <v-card>
                <v-tabs v-model="tab" color="deep-purple accent-4" right>
                    <v-tab
                        v-for="(laboratory,
                        index) in generalLaboratoriesPresidency"
                        :key="index"
                    >
                        {{ laboratory.processing_laboratory.description }}
                    </v-tab>
                    <v-tab-item
                        class="p-5"
                        v-for="(laboratory,
                        index) in generalLaboratoriesPresidency"
                        :key="index"
                    >
                        <v-row>
                            <v-card
                                elevation="5"
                                class="mx-auto mb-2"
                                max-width="320"
                                color="grey lighten-3"
                                v-for="(status, index) in laboratory.detail"
                                :key="index"
                            >
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-4">
                                            ESTADO
                                        </div>
                                        <v-list-item-title
                                            class="headline mb-1"
                                        >
                                            {{ status.description }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle
                                            >RT-PCR para
                                            SARS-CoV2</v-list-item-subtitle
                                        >
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="blue darken-2"
                                        class="headline white--text"
                                    >
                                        {{ status.count }}
                                    </v-list-item-avatar>
                                </v-list-item>
                            </v-card>
                        </v-row>
                    </v-tab-item>
                </v-tabs>
                <v-card-actions>
                    <v-spacer />
                    <span class="caption">
                        *El total de muestras notificadas, no incluye las
                        muestras rechazadas.</span
                    >
                </v-card-actions>
            </v-card>
        </v-card>

        <v-card v-if="notifiedDetailByLaboratoryArray" class="mt-5">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title
                    >ANALISIS POR RESULTADO MUESTRAS PROCESADAS</v-toolbar-title
                >
                <v-spacer></v-spacer>
                <v-toolbar-title>FECHA: {{ currentDate }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title>CORTE: 16:00 HORAS</v-toolbar-title>
            </v-toolbar>
            <v-card flat>
                <v-tabs v-model="tab2" color="deep-purple accent-4" right>
                    <v-tab
                        v-for="(laboratory, index) in notifiedAllLaboratories"
                        :key="index"
                    >
                        {{ laboratory.description }}
                    </v-tab>
                    <v-tab-item
                        class="p-5"
                        v-for="(laboratory, index) in notifiedAllLaboratories"
                        :key="index"
                    >
                        <v-toolbar class="mb-5">
                            <v-spacer></v-spacer>
                            <v-toolbar-title
                                >TOTAL NOTIFICADAS:</v-toolbar-title
                            >
                            <v-avatar color="blue darken-2" size="48">
                                <span class="white--text headline">{{
                                    laboratory.days.sum
                                }}</span>
                            </v-avatar>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-row>
                            <v-card
                                elevation="5"
                                class="mx-auto mb-2"
                                max-width="320"
                                color="grey lighten-3"
                                v-for="(detail, index) in laboratory.days.group"
                                :key="index"
                            >
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-4">
                                            RESULTADO
                                        </div>
                                        <v-list-item-title
                                            class="subtitle-1 mb-1"
                                        >
                                            {{ detail.result }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle
                                            >RT-PCR para
                                            SARS-CoV2</v-list-item-subtitle
                                        >
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        :color="setDayColor(detail)"
                                        class="headline white--text"
                                    >
                                        {{ detail.count }}
                                    </v-list-item-avatar>
                                </v-list-item>
                            </v-card>
                        </v-row>
                    </v-tab-item>
                </v-tabs>
            </v-card>
        </v-card>

        <v-card class="mt-5">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title
                    >INGRESOS A SOLICITUD DE MEDIOS DIAGNÓSTICOS (OA) HHHA
                </v-toolbar-title>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-row>
                        <v-card
                            elevation="5"
                            class="mx-auto mb-2"
                            max-width="300"
                            color="grey lighten-3"
                            v-for="(day, index) in statusByDayArray"
                            :key="index"
                            @click.stop="showInformation(day)"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="overline mb-4">
                                        {{ day.date }}
                                    </div>

                                    <v-list-item-title class="h2 mb-1">
                                        {{ day.total - day.pending }} /
                                        {{ day.total }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle
                                        >Índice de
                                        cumplimiento</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    :color="setDayColor(index)"
                                    class="headline white--text"
                                >
                                    {{ day.percent }}
                                </v-list-item-avatar>
                            </v-list-item>
                        </v-card>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card>

        <v-dialog v-if="dataDialog" v-model="dialog" max-width="600">
            <v-card>
                <v-card-title class="subtitle">
                    Resultados en {{ dataDialog.date }}
                </v-card-title>

                <v-card-text class="py-0">
                    <v-timeline align-top dense>
                        <v-timeline-item
                            v-for="(item, index) in dataDialog.group"
                            :key="index"
                            :color="
                                item.status === 'EN PROCESO' ? 'red' : 'blue'
                            "
                            small
                        >
                            <v-row class="pt-1">
                                <v-col cols="3">
                                    <strong>{{ item.count }}</strong>
                                    <div class="caption">
                                        muestras
                                    </div>
                                </v-col>
                                <v-col>
                                    <span class="subtitle-1"
                                        ><strong>{{
                                            item.status === null
                                                ? 'Sin resultado'
                                                : item.status
                                        }}</strong></span
                                    >
                                </v-col>
                                <v-col>
                                    <v-btn
                                        v-if="item.status === 'EN PROCESO'"
                                        color="primary"
                                        @click="findDetail('PROCESS')"
                                        dark
                                        class="ma-2"
                                    >
                                        DETALLE
                                        <v-icon dark right>{{
                                            show
                                                ? 'mdi-chevron-up'
                                                : 'mdi-chevron-down'
                                        }}</v-icon>
                                    </v-btn>
                                    <v-btn
                                        v-if="item.status === 'RECEPCIONADA'"
                                        color="primary"
                                        @click="findDetail('RECEIVED')"
                                        dark
                                        class="ma-2"
                                    >
                                        DETALLE
                                        <v-icon dark right>{{
                                            show
                                                ? 'mdi-chevron-up'
                                                : 'mdi-chevron-down'
                                        }}</v-icon>
                                    </v-btn>
                                </v-col>
                                <v-expand-transition
                                    v-if="item.status === 'EN PROCESO'"
                                >
                                    <div v-show="showProcess">
                                        <v-divider></v-divider>

                                        <v-card-text>
                                            <v-simple-table dense>
                                                <template v-slot:default>
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-left"
                                                            >
                                                                PETICIÓN
                                                                <nav></nav>
                                                            </th>
                                                            <th
                                                                class="text-left"
                                                            >
                                                                LABORATORIO
                                                                <nav></nav>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="sample in processArray"
                                                            :key="sample.id"
                                                        >
                                                            <td>
                                                                {{
                                                                    sample.id_testing_request
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    sample.processing_laboratory
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>
                                        </v-card-text>
                                    </div>
                                </v-expand-transition>
                                <v-expand-transition
                                    v-if="item.status === 'RECEPCIONADA'"
                                >
                                    <div v-show="showReceived">
                                        <v-divider></v-divider>

                                        <v-card-text>
                                            <v-simple-table dense>
                                                <template v-slot:default>
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-left"
                                                            >
                                                                PETICIÓN
                                                                <nav></nav>
                                                            </th>
                                                            <th
                                                                class="text-left"
                                                            >
                                                                LABORATORIO
                                                                <nav></nav>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="sample in receivedArray"
                                                            :key="sample.id"
                                                        >
                                                            <td>
                                                                {{
                                                                    sample.id_testing_request
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    sample.processing_laboratory
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>
                                        </v-card-text>
                                    </div>
                                </v-expand-transition>
                            </v-row>
                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog = false">
                        Salir
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </section>
</template>

<script>
import TatLineChart from '../../components/chart/LineTAT'

export default {
    name: 'statisticCovidComponent',
    components: {
        'tat-line-chart': TatLineChart
    },
    data() {
        return {
            consolidado: [],
            errors: [],
            currentDate: '',
            model: null,
            result: 4,
            dialog: false,
            dataDialog: '',
            tabs: 0,
            tab2: null,
            tab: null,
            notifiedDetailByLaboratoryArray: null,
            descriptionNotifiedByResultHHHA: '',
            show: '',
            currentStatusSamples24: null,
            presidencyConsolidate: {
                received: {},
                notified: {},
                positive: {},
                stock: {},
                finalStock: {},
                sumNotified: {},
                sumPositive: {},
                sum: {}
            },
            generalLaboratoriesPresidency: [],
            statusByDayArray: [],
            showProcess: false,
            showReceived: false,
            receivedArray: [],
            processArray: [],
            latestUpload: null,
            loaded: false,
            options: null,
            chartdata: null,
            loaded2: false,
            options2: null,
            chartdata2: null,
            date: new Date().toISOString().substr(0, 10),
            date2: new Date().toISOString().substr(0, 10),
            menu: false,
            modal: false,
            modal2: false,
            menu2: false,
            allowedDates_: [],
            labels: [],
            value: []
        }
    },
    created() {
        this.agregateData()
        this.getLatestDateUploadFile()
        this.getChartRegisterRequest()
        this.getChartValidatedRequest()
    },
    mounted() {},
    computed: {
        currentNotifiedHHHA() {
            return this.notifiedDetailByLaboratoryArray.group
        },
        currentDateHHHA() {
            return this.notifiedDetailByLaboratoryArray.date
        },
        currentTotalHHHA() {
            return this.notifiedDetailByLaboratoryArray.sum
        },
        notifiedAllLaboratories() {
            return this.notifiedDetailByLaboratoryArray.filter(
                lab => lab.description !== null
            )
        },
        currentStatusByLab() {
            return this.currentStatusSamples24.filter(lab => lab.laboratory)
        },
        currentStatusByLabLength() {
            return this.currentStatusSamples24.length
        }
    },
    methods: {
        test() {},
        async getChartRegisterRequest() {
            try {
                this.loaded = false
                const { data } = await axios.get(
                    `/api/management/tat-received-notified/${this.date}`
                )

                this.chartdata = {
                    datasets: [
                        {
                            data: data.dataSet,
                            label:
                                'Distribución de registros a SMD en 24 horas',
                            //backgroundColor: '#FF6D00',
                            pointRadius: 0.2,
                            showLine: true,
                            fill: false,
                            // backgroundColor: lightblue,
                            borderColor: '#FF6D00',
                            borderWidth: 1,
                            cubicInterpolationMode: 'monotone',
                            tension: 0
                            // spanGaps: true
                        }
                    ]
                }
                this.options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { right: 10 } },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [
                            {
                                stacked: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'N° de Ingresos'
                                },
                                ticks: {
                                    display: true,
                                    beginAtZero: false,
                                    min: 0,
                                    max: 8
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        ],
                        xAxes: [
                            {
                                type: 'time',
                                time: {
                                    unit: 'hour',
                                    parser: 'HH:mm',
                                    displayFormats: {
                                        hour: 'HH:mm'
                                    }
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Hora de ingreso a SMD'
                                }
                            }
                        ]
                    }
                }

                this.loaded = true
            } catch (error) {
                console.log(error)
            }
        },

        async getChartValidatedRequest() {
            try {
                this.loaded2 = false
                const { data } = await axios.get(
                    `/api/management/tat-validated/${this.date2}`
                )

                this.value = data.dataSet.map(val => val.y)

                this.chartdata2 = {
                    datasets: [
                        {
                            data: data.dataSet,
                            label:
                                'Distribución de registros a SMD en 24 horas',
                            //backgroundColor: '#FF6D00',
                            pointRadius: 0.2,
                            showLine: true,
                            fill: false,
                            // backgroundColor: lightblue,
                            borderColor: '#FF6D00',
                            borderWidth: 1,
                            cubicInterpolationMode: 'monotone',
                            tension: 0
                            // spanGaps: true
                        }
                    ]
                }
                this.options2 = {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { right: 10 } },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [
                            {
                                stacked: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'N° de validaciones'
                                },
                                ticks: {
                                    display: true,
                                    beginAtZero: false,
                                    min: 0,
                                    max: 20
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        ],
                        xAxes: [
                            {
                                type: 'time',
                                time: {
                                    unit: 'hour',
                                    parser: 'HH:mm',
                                    displayFormats: {
                                        hour: 'HH:mm'
                                    }
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Hora de validación'
                                }
                            }
                        ]
                    }
                }

                this.loaded2 = true
            } catch (error) {
                console.log(error)
            }
        },

        async getLatestDateUploadFile() {
            try {
                const { data } = await axios.get('/api/management/latest-file')

                this.latestUpload = data
            } catch (error) {
                console.log(error)
            }
        },
        changeResultFormat(item) {
            if (item.result === 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
                return 'RECHAZADA'
            else if (
                item.result === 'NO CONCLUYENTE. SE SOLICITA NUEVA MUESTRA.'
            )
                return 'NO CONCLUYENTE'
            else if (item.result === null) return 'SIN RESULTADO'
            else return item.result
        },
        showInformation(item) {
            console.log(item)
            this.dataDialog = item
            this.dialog = true
            this.receivedArray = []
            this.processArray = []
            this.showProcess = false
            this.showReceived = false
        },
        setDayColor(item) {
            if (item === 0) return 'green'
            if (item === 1) return 'yellow darken-3'
            return 'red'
        },
        async findDetail(type) {
            if (type === 'PROCESS') {
                this.showProcess = !this.showProcess

                this.dataDialog.detail.forEach(detail => {
                    if (detail.description === 'EN PROCESO')
                        this.processArray = detail.samples
                })
            } else if (type === 'RECEIVED') {
                this.showReceived = !this.showReceived

                this.dataDialog.detail.forEach(detail => {
                    if (detail.description === 'RECEPCIONADA')
                        this.receivedArray = detail.samples
                })
            }
        },
        async agregateData() {
            try {
                const { data } = await axios.get(
                    '/api/management/agregate-data'
                )

                this.currentDate = data.current_date
                this.allowedDates_ = data.days
                this.consolidado = data.groupBy.consolidado
                this.errors = data.groupBy.errors
                this.result = data.result.total.detail
                this.tab = 3
                this.tabs = data.test.resultByGroupLaboratory
                this.currentStatusSamples24 =
                    data.test.currentStatusByLaboratory_
                this.notifiedDetailByLaboratoryArray =
                    data.test.notifiedGroupByLaboratoryResult
                this.descriptionNotifiedByResultHHHA =
                    data.test.notifiedGroupByLaboratoryResult[1].description
                this.presidencyConsolidate.notified = data.test.notifiedDetail24
                this.presidencyConsolidate.finalStock =
                    data.test.currentStock120Hours
                this.presidencyConsolidate.received = data.test.receivedDetail24
                this.presidencyConsolidate.sumPositive =
                    data.test.positiveDetail24
                this.presidencyConsolidate.sum =
                    data.test.sumNotifiedAndPositive
                this.generalLaboratoriesPresidency =
                    data.test.full_presidency.data
                this.statusByDayArray = data.test.statusSamplesLastFiveDays.days
            } catch (error) {
                console.log(error)
            }
        },
        allowedDates(val) {
            return this.allowedDates_.indexOf(val) !== -1
        }
    }
}
</script>

<style></style>
