<template>
    <section class="p-5">
        <v-row v-if="!loadingFile" align-content="center" justify="center">
            <v-col cols="6">
                <v-card class="mx-auto">
                    <v-card-title>
                        Carga de archivo excel consolidado full
                    </v-card-title>
                    <v-card-text>
                        <v-file-input
                            v-model="file"
                            show-size
                            label="File input"
                        ></v-file-input>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            :disabled="file === null"
                            :dark="file !== null"
                            block
                            large
                            color="blue"
                            depressed
                            @click.stop="sendFile"
                        >
                            <v-icon class="mr-3" size="25"
                                >mdi-file-import</v-icon
                            >Subir
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

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
export default {
    name: 'statisticCovidComponent',
    data() {
        return {
            consolidado: [],
            file: null,
            loadingFile: false,
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
            processArray: []
        }
    },
    mounted() {
        this.agregateData()
    },
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

            console.log('process', this.processArray)
            console.log('received', this.receivedArray)
        },
        async sendFile() {
            let formData = new FormData()
            formData.append('file', this.file)

            const config = {
                'Content-Type': 'multipart/form-data'
            }
            const { data } = await axios.post(
                '/api/management/upload-file',
                formData,
                config
            )

            console.log(data)

            if (data) {
                const config = {
                    responseType: 'blob' // o blob o arraybuffer
                }
                const response = await axios.get(
                    '/api/management/download-file',
                    config
                )
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                )
                const link = document.createElement('a')
                link.href = url
                link.setAttribute('download', 'file.xlsx')
                document.body.appendChild(link)
                link.click()
            }
        },
        async agregateData() {
            try {
                const { data } = await axios.get(
                    '/api/management/agregate-data'
                )

                this.currentDate = data.current_date

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
        }
    }
}
</script>

<style></style>
