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
        <v-dialog v-model="modalRegister" max-width="500">
            <v-card>
                <v-card-title class="headline primary text-white">
                    Definir fecha y hora
                </v-card-title>

                <v-card-text>
                    <p>
                        *Los datos generados corresponden a las últimas 24 horas
                        de la fecha definida.
                    </p>
                    <p>
                        *Ejemplo: Si define la fecha como 05/10/2020 Hora:
                        20:00, el rango de fechas será
                        <b>04/10/2020 20:00 a 05/10/2020 20:00 </b>
                    </p>
                    <v-stepper v-model="e" vertical>
                        <v-stepper-step :complete="e > 1" step="1">
                            Selecciona fecha
                        </v-stepper-step>

                        <v-stepper-content step="1">
                            <v-card flat class="mb-12 text-center">
                                <v-date-picker
                                    v-model="date"
                                    class="mt-4"
                                    :allowed-dates="allowedDates"
                                    scrollable
                                ></v-date-picker
                            ></v-card>
                            <v-btn color="primary" @click="e = 2">
                                Continuar
                            </v-btn>
                            <v-btn @click="resetModal1" text>
                                Cancelar
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-step :complete="e > 2" step="2">
                            Selecciona hora
                        </v-stepper-step>

                        <v-stepper-content step="2">
                            <v-card flat class="mb-12 text-center">
                                <v-time-picker
                                    v-model="time"
                                    flat
                                    format="24hr"
                                ></v-time-picker>
                            </v-card>
                            <v-btn color="primary" @click="e = 3">
                                Continuar
                            </v-btn>
                            <v-btn @click="e = 1" text>
                                atrás
                            </v-btn>
                        </v-stepper-content>
                    </v-stepper>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="getChartRegisterRequest()"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title>
                Resumen presidencial diario
            </v-card-title>
            <v-card-text>
                <v-col v-if="loadedPresidency" cols="12">
                    <tat-line-chart
                        :style="{ height: '350px' }"
                        :chartdata="chartdataPresidency"
                        :options="optionsPresidency"
                    ></tat-line-chart>
                </v-col>
                <div v-else class="text-center">
                    <v-progress-circular
                        class="ml-6"
                        v-for="n in 3"
                        :key="n"
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </div>
            </v-card-text>
        </v-card>

        <v-card class="my-3">
            <v-toolbar color="primary" dark>
                <v-toolbar-title>
                    Frecuencia registro formularios COVID-19 en SMD
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-btn color="primary darken-2" @click="openModal"
                    >Filtrar fecha</v-btn
                >
            </v-toolbar>

            <v-card-text>
                <v-row v-if="loaded">
                    <v-col cols="9">
                        <tat-line-chart
                            :style="{ height: '250px' }"
                            :chartdata="chartdata"
                            :options="options"
                        ></tat-line-chart>
                    </v-col>
                    <v-col cols="3">
                        <v-list>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo.currentCount"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Recuento</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >(24h)</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo.maxCount"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Capacidad</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >máxima</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo.performance"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Capacidad</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >operativa</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>
                <div v-else class="text-center">
                    <v-progress-circular
                        class="ml-6"
                        v-for="n in 3"
                        :key="n"
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </div>
            </v-card-text>
        </v-card>

        <v-card class="my-3">
            <v-toolbar color="primary" dark>
                <v-toolbar-title>
                    Frecuencia validaciones COVID-19 en LIS
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn color="primary darken-2" @click="openModal2"
                    >Filtrar fecha</v-btn
                >
                <v-dialog v-model="modalRegister2" max-width="500">
                    <v-card>
                        <v-card-title class="headline primary text-white">
                            Definir fecha y hora
                        </v-card-title>

                        <v-card-text>
                            <p>
                                *Los datos generados corresponden a las últimas
                                24 horas de la fecha definida.
                            </p>
                            <p>
                                *Ejemplo: Si define la fecha como 05/10/2020
                                Hora: 20:00, el rango de fechas será
                                <b>04/10/2020 20:00 a 05/10/2020 20:00 </b>
                            </p>
                            <v-stepper v-model="e2" vertical>
                                <v-stepper-step :complete="e2 > 1" step="1">
                                    Selecciona fecha
                                </v-stepper-step>

                                <v-stepper-content step="1">
                                    <v-card flat class="mb-12 text-center">
                                        <v-date-picker
                                            v-model="date2"
                                            class="mt-4"
                                            :allowed-dates="allowedDates"
                                            scrollable
                                        ></v-date-picker
                                    ></v-card>
                                    <v-btn color="primary" @click="e2 = 2">
                                        Continuar
                                    </v-btn>
                                    <v-btn @click="resetModal2" text>
                                        Cancelar
                                    </v-btn>
                                </v-stepper-content>

                                <v-stepper-step :complete="e2 > 2" step="2">
                                    Selecciona hora
                                </v-stepper-step>

                                <v-stepper-content step="2">
                                    <v-card flat class="mb-12 text-center">
                                        <v-time-picker
                                            v-model="time2"
                                            flat
                                            format="24hr"
                                        ></v-time-picker>
                                    </v-card>
                                    <v-btn color="primary" @click="e2 = 3">
                                        Continuar
                                    </v-btn>
                                    <v-btn @click="e2 = 1" text>
                                        atrás
                                    </v-btn>
                                </v-stepper-content>
                            </v-stepper>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="primary"
                                text
                                @click="getChartValidatedRequest()"
                            >
                                Aceptar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
            <v-card-text>
                <v-row v-if="loaded2">
                    <v-col cols="9">
                        <tat-line-chart
                            :style="{ height: '250px' }"
                            :chartdata="chartdata2"
                            :options="options2"
                        ></tat-line-chart>
                    </v-col>
                    <v-col cols="3">
                        <v-list>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo2.currentCount"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Recuento</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >(24h)</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo2.maxCount"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Capacidad</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >máxima</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-avatar size="70">
                                    <v-icon
                                        class="text-h6"
                                        dark
                                        color="primary"
                                        v-text="chartdataInfo2.performance"
                                    ></v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="overline"
                                        >Capacidad</v-list-item-title
                                    >
                                    <v-list-item-subtitle class="overline"
                                        >operativa</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>
                <div v-else class="text-center">
                    <v-progress-circular
                        class="ml-6"
                        v-for="n in 3"
                        :key="n"
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </div>
            </v-card-text>
        </v-card>

        <v-card class="mt-5" v-if="generalLaboratoriesPresidency.length !== 0">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title>Reporte presidencia </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title>Análisis diario corte 19:00</v-toolbar-title>
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
                <v-toolbar-title>CORTE: 19:00 HORAS</v-toolbar-title>
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
            chartdataPresidency: null,
            optionsPresidency: null,
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
            value: [],
            chartdataInfo: {},
            chartdataInfo2: {},
            modalTimer: false,
            time: '00:00',
            time2: '00:00',
            modalRegister: false,
            modalRegister2: false,
            e: 1,
            e2: 1,
            loadedPresidency: false
        }
    },
    created() {
        this.agregateData()
        this.getLatestDateUploadFile()
        this.getChartRegisterRequest()
        this.getChartValidatedRequest()
        this.getChartPresidencyConsolidate()
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
    watch: {
        modalRegister(val) {
            if (!val) {
                this.resetModal1()
            }
        },
        modalRegister2() {
            if (!val) {
                this.resetModal2()
            }
        }
    },
    methods: {
        openModal() {
            this.modalRegister = true
        },
        openModal2() {
            this.modalRegister2 = true
        },
        resetModal1() {
            this.modalRegister = false
            this.e = 1
        },
        resetModal2() {
            this.modalRegister2 = false
            this.e2 = 1
        },
        test() {},
        async getChartPresidencyConsolidate() {
            try {
                this.loadedPresidency = false
                const { data } = await axios.get(
                    `/api/management/presidency-consolidate`
                )

                const notified = data.data.map(day => day.notified.value)
                const positive = data.data.map(day => day.positive.value)
                const received = data.data.map(day => day.received.value)

                this.chartdataPresidency = {
                    datasets: [
                        {
                            label: 'Número de positivos',
                            data: positive,
                            backgroundColor: '#FF5252',
                            pointBorderColor: 'black',
                            pointBackgroundColor: 'white'

                            //backgroundColor: '#FF6D00',
                        },
                        {
                            label: 'Número de muestras procesadas',
                            data: notified,
                            backgroundColor: '#66BB6A',
                            pointBorderColor: 'black',
                            pointBackgroundColor: 'white'

                            //backgroundColor: '#FF6D00',
                            /*                             pointRadius: 1,

                            fill: false,
                            // backgroundColor: lightblue,
                            borderColor: '#FF6D00',
                            borderWidth: 2,
                            tension: 0.2,
                            type: 'line',
                            spanGaps: true */
                        },
                        {
                            data: received,
                            label: 'Muestras recepcionadas',
                            //backgroundColor: '#FF6D00',
                            fill: false,
                            // backgroundColor: lightblue,
                            borderColor: '#283593'
                        }
                    ],
                    labels: data.labels
                }
                this.optionsPresidency = {
                    responsive: true,
                    maintainAspectRatio: false
                    /*                    layout: { padding: { right: 10 } },
                    legend: {
                        display: false
                    }, */
                    /*    scales: {
                        yAxes: [
                            {
                                stacked: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'N° de Ingresos'
                                },
                                ticks: {
                                    display: true,
                                    beginAtZero: true
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
                                //                    distribution: 'series',
                                time: {
                                    unit: 'hour',
                                    parser: 'DD/MM/YY',
                                    displayFormats: {
                                        hour: 'DD/MM'
                                    }
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Fecha de envío'
                                }
                            }
                        ]
                    } */
                }
                this.loadedPresidency = true
                console.log(data)
            } catch (error) {
                console.log(error)
            }
        },
        async getChartRegisterRequest() {
            try {
                this.loaded = false
                const { data } = await axios.get(
                    `/api/management/tat-received-notified/${this.date}/${this.time}`
                )

                this.chartdataInfo = {
                    currentCount: data.analitycs.count,
                    maxCount: 1500,
                    performance: `${Number.parseFloat(
                        (data.analitycs.count / 1500) * 100
                    ).toFixed(1)}%`
                }

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
                                distribution: 'series',
                                time: {
                                    unit: 'hour',
                                    parser: 'DD/MM/YY HH:mm',
                                    displayFormats: {
                                        hour: 'DD/MM HH:mm'
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

                this.resetModal1()
            } catch (error) {
                console.log(error)
            }
        },

        async getChartValidatedRequest() {
            try {
                this.loaded2 = false
                const { data } = await axios.get(
                    `/api/management/tat-validated/${this.date2}/${this.time2}`
                )

                this.value = data.dataSet.map(val => val.y)

                this.chartdataInfo2 = {
                    currentCount: data.analitycs.count,
                    maxCount: 1200,
                    performance: `${Number.parseFloat(
                        (data.analitycs.count / 1200) * 100
                    ).toFixed(1)}%`
                }

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
                                distribution: 'series',
                                time: {
                                    unit: 'hour',
                                    parser: 'DD/MM/YY HH:mm',
                                    displayFormats: {
                                        hour: 'DD/MM HH:mm'
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
                this.resetModal2()
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
