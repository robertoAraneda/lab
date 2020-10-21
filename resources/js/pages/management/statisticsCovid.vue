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

        <v-card class="content-center mt-5" v-if="notifiedByResultHHHA">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title>REPORTE PRESIDENCIA </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title> FECHA: {{ currentDate }} </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title> CORTE: 16:00 HORAS </v-toolbar-title>
                <v-tooltip left>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-head-question-outline</v-icon>
                        </v-btn>
                    </template>
                    <span>¿Más información?</span>
                </v-tooltip>
            </v-toolbar>
            <v-card class="p-2 my-3">
                <v-toolbar color="blue" dark>
                    <v-toolbar-title>LABORATORIO HHHA </v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-row>
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2 mb-4">
                                        STOCK ACTUAL
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.finalStock
                                            .allCurrentStock120 +
                                            presidencyConsolidate.notified
                                                .notified24 -
                                            presidencyConsolidate.received.all24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2 mb-4">
                                        RECEPCIONADAS
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.received.all24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2 mb-4">
                                        NOTIFICADAS
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.notified
                                            .notified24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2 mb-4">
                                        STOCK FINAL
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.finalStock
                                            .allCurrentStock120
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                        
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2  mb-4">
                                        POSITIVOS
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.sumPositive
                                            .positive24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>

                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2  mb-4">
                                        TOTAL POSITIVOS
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.sum.sum_positive +
                                            presidencyConsolidate.sumPositive
                                                .positive24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>

                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="250"
                            color="grey lighten-3"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="subtitle-2  mb-4">
                                        TOTAL NOTIFICADOS
                                    </div>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{
                                        presidencyConsolidate.sum.sum_notified +
                                            presidencyConsolidate.notified
                                                .notified24
                                    }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card>

        <v-card v-if="currentStatusSamples24" class="mt-5">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title
                    >CONSOLIDADO DE PROCESAMIENTO DIARIO</v-toolbar-title
                >
                <v-spacer></v-spacer>
                <v-toolbar-title>FECHA: {{ currentDate }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title>CORTE: 16:00 HORAS</v-toolbar-title>
            </v-toolbar>
            <v-card flat>
                <v-tabs v-model="tab" color="deep-purple accent-4" right>
                    <v-tab
                        v-for="(laboratory, index) in currentStatusByLab"
                        :key="index"
                    >
                        {{
                            laboratory.laboratory === null
                                ? 'Sin clasificar'
                                : laboratory.laboratory
                        }}
                    </v-tab>
                    <v-tab-item
                        class="p-5"
                        v-for="(laboratory, index) in currentStatusByLab"
                        :key="index"
                    >
                        <v-row>
                            <v-card
                                elevation="5"
                                class="mx-auto mb-2"
                                max-width="320"
                                color="grey lighten-3"
                                v-for="(detail, index) in laboratory.detail"
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
                                            {{ detail.description }}
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
            <v-card-actions>
                <v-spacer />
                <span class="caption">
                    *El total de muestras notificadas, no incluye las muestras
                    rechazadas.</span
                >
            </v-card-actions>
        </v-card>

        <v-card class="content-center mt-5" v-if="notifiedByResultHHHA">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title>ESTADO: NOTIFICADO </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title> FECHA: {{ currentDate }} </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title> CORTE: 16:00 HORAS </v-toolbar-title>
                <v-tooltip left>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-head-question-outline</v-icon>
                        </v-btn>
                    </template>
                    <span>¿Más información?</span>
                </v-tooltip>
            </v-toolbar>
            <v-card
                v-for="(laboratory, index) in notifiedAllLaboratories"
                :key="index"
                class="p-2 my-3"
            >
                <v-toolbar color="blue" dark>
                    <v-toolbar-title
                        >{{ laboratory.description }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-title> </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <p class="mt-4">TOTAL:</p>
                    <v-avatar color="blue darken-2" size="48">
                        <span class="white--text headline">{{
                            laboratory.days.sum
                        }}</span>
                    </v-avatar>
                </v-toolbar>
                <v-card-text>
                    <v-row>
                        <v-card
                            elevation="5"
                            class="mx-auto my-3"
                            max-width="320"
                            color="grey lighten-3"
                            v-for="(item, index) in laboratory.days.group"
                            :key="index"
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="overline mb-4">
                                        RESULTADO
                                    </div>
                                    <v-list-item-title class="subtitle-1 mb-1">
                                        {{ changeResultFormat(item) }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle
                                        >RT-PCR para
                                        SARS-CoV2</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="blue"
                                    class="headline white--text"
                                >
                                    {{ item.count }}</v-list-item-avatar
                                >
                            </v-list-item>
                        </v-card>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card>

        <v-card class="mt-5">
            <v-toolbar flat color="grey lighten-3">
                <v-toolbar-title>ESTADO: INGRESO A SMD HHHA </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title>ANÁLISIS SEGÚN RESULTADOS</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-title> ÚLTIMOS 5 DÍAS</v-toolbar-title>
            </v-toolbar>
            <v-card>
                <v-tabs v-model="tab" color="deep-purple accent-4" right>
                    <v-tab v-for="(laboratory, index) in tabs" :key="index">
                        {{
                            laboratory.description === null
                                ? 'Sin clasificar'
                                : laboratory.description
                        }}
                    </v-tab>
                    <v-tab-item
                        class="p-5"
                        v-for="(laboratory, index) in tabs"
                        :key="index"
                    >
                        <v-row>
                            <v-card
                                elevation="5"
                                class="mx-auto mb-2"
                                max-width="320"
                                color="grey lighten-3"
                                v-for="(day, index) in laboratory.days"
                                :key="index"
                                @click.stop="showInformation(day)"
                            >
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-4">
                                            FECHA
                                        </div>
                                        <v-list-item-title
                                            class="headline mb-1"
                                        >
                                            {{ day.date }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle
                                            >RT-PCR para
                                            SARS-CoV2</v-list-item-subtitle
                                        >
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        :color="setDayColor(index)"
                                        class="headline white--text"
                                    >
                                        {{ day.sum }}
                                    </v-list-item-avatar>
                                </v-list-item>
                            </v-card>
                        </v-row>
                    </v-tab-item>
                </v-tabs>
            </v-card>
        </v-card>

        <v-dialog v-if="dataDialog" v-model="dialog" max-width="500">
            <v-card>
                <v-card-title class="subtitle">
                    Resultados en {{ dataDialog.date }}
                </v-card-title>

                <v-card-text class="py-0">
                    <v-timeline align-top dense>
                        <v-timeline-item
                            v-for="(item, index) in dataDialog.group"
                            :key="index"
                            :color="item.result === null ? 'red' : 'blue'"
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
                                            item.result === null
                                                ? 'Sin resultado'
                                                : item.result
                                        }}</strong></span
                                    >
                                </v-col>
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

        <v-btn @click="agregateData">
            Datos
        </v-btn>
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
            tab: null,
            notifiedByResultHHHA: null,
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
            }
        }
    },

    computed: {
        currentNotifiedHHHA() {
            return this.notifiedByResultHHHA.group
        },
        currentDateHHHA() {
            return this.notifiedByResultHHHA.date
        },
        currentTotalHHHA() {
            return this.notifiedByResultHHHA.sum
        },
        notifiedAllLaboratories() {
            return this.notifiedByResultHHHA.filter(
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
        },
        setDayColor(item) {
            if (item === 0) return 'green'
            if (item === 1) return 'yellow darken-3'
            return 'red'
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
            const { data } = await axios.get('/api/management/agregate-data')

            console.log(data)

            this.currentDate = data.current_date

            this.consolidado = data.groupBy.consolidado
            this.errors = data.groupBy.errors
            this.result = data.result.total.detail
            this.tab = data.test.resultByGroupLaboratory.length
            this.tabs = data.test.resultByGroupLaboratory
            this.currentStatusSamples24 = data.test.currentStatusByLaboratory_
            this.notifiedByResultHHHA =
                data.test.notifiedGroupByLaboratoryResult
            this.descriptionNotifiedByResultHHHA =
                data.test.notifiedGroupByLaboratoryResult[1].description

            this.presidencyConsolidate.notified = data.test.notifiedDetail24
            this.presidencyConsolidate.finalStock =
                data.test.currentStock120Hours
            this.presidencyConsolidate.received = data.test.receivedDetail24
            this.presidencyConsolidate.sumPositive = data.test.positiveDetail24

            this.presidencyConsolidate.sum = data.test.sumNotifiedAndPositive
        }
    }
}
</script>

<style></style>
