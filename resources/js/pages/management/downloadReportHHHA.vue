<template>
    <v-container fluid>
        <v-card
            elevation="5"
            class="mx-auto mb-2"
            color="grey lighten-3"
            @click="handleModalDetail"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        DESCARGA
                    </div>
                    <v-list-item-title class="headline mb-1">
                        REPORTE CONSOLIDADO PRESIDENCIAL DETALLE
                    </v-list-item-title>
                    <v-list-item-subtitle
                        >RT-PCR para SARS-CoV2</v-list-item-subtitle
                    >
                </v-list-item-content>
                <v-list-item-avatar tile size="80" class="headline white--text">
                    <v-icon color="green darken-4" size="80" dark>
                        mdi-file-excel
                    </v-icon>
                </v-list-item-avatar>
            </v-list-item>
        </v-card>

        <v-card
            elevation="5"
            class="mx-auto mb-2"
            color="grey lighten-3"
            @click="getDailyPresidency"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        DESCARGA
                    </div>
                    <v-list-item-title class="headline mb-1">
                        REPORTE CONSOLIDADO PRESIDENCIAL
                    </v-list-item-title>
                    <v-list-item-subtitle
                        >RT-PCR para SARS-CoV2</v-list-item-subtitle
                    >
                </v-list-item-content>
                <v-list-item-avatar tile size="80" class="headline white--text">
                    <v-icon color="green darken-4" size="80" dark>
                        mdi-file-excel
                    </v-icon>
                </v-list-item-avatar>
            </v-list-item>
        </v-card>

        <v-dialog v-model="dialogPresidency" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Confirmar datos reporte minsal</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row justify="center" class="text-center">
                            <v-col cols="6">
                                <v-checkbox
                                    v-model="checkEditPresidencyForm"
                                    label="Editar campos"
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.currentStock"
                                    label="Muestras en espera"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.received"
                                    label="Muestras recepcionadas"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.notified"
                                    label="Muestras procesadas"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.positive"
                                    label="Muestras positivas"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.finalStock"
                                    label="Stock final"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.totalNotified"
                                    label="Muestras procesadas acumuladas"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.totalPositive"
                                    label="Muestras positivas acumuladas"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.maximum_capacity"
                                    label="Capacidad máxima de procesamiento"
                                    required
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-textarea
                                    :disabled="!checkEditPresidencyForm"
                                    v-model="dataModel.observations"
                                    label="Alerta cuello de botella"
                                    required
                                >
                                </v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="dialogPresidency = false"
                    >
                        cancelar
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="storePresidency">
                        Confirmar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogDetail" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Confirmar datos detalle MINSAL</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-card v-if="items.length !== 0">
                            <v-toolbar color="primary" dark dense>
                                <v-toolbar-title class="subtitle-1"
                                    >PACIENTES SIN RUT
                                </v-toolbar-title>
                            </v-toolbar>
                            <v-data-table :headers="headers" :items="items">
                                <template v-slot:item.patient_rut="props">
                                    <v-edit-dialog
                                        :return-value.sync="
                                            props.item.patient_rut
                                        "
                                        @save="save(props.item)"
                                        @cancel="cancel"
                                        @open="open"
                                        @close="close"
                                    >
                                        {{ props.item.patient_rut }}
                                        <template v-slot:input>
                                            <v-text-field
                                                v-model="props.item.patient_rut"
                                                label="Editar"
                                                single-line
                                                counter
                                            ></v-text-field>
                                        </template>
                                    </v-edit-dialog>
                                </template>
                            </v-data-table>

                            <v-snackbar
                                v-model="snack"
                                :timeout="3000"
                                :color="snackColor"
                            >
                                {{ snackText }}

                                <template v-slot:action="{ attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        text
                                        @click="snack = false"
                                    >
                                        Close
                                    </v-btn>
                                </template>
                            </v-snackbar>
                        </v-card>
                        <v-card v-else>
                            <v-card-text>
                                Todos los datos con correctos
                            </v-card-text>
                        </v-card>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="dialogDetail = false"
                    >
                        cancelar
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="downloadExcel">
                        Confirmar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            snack: false,
            snackColor: '',
            snackText: '',
            max25chars: v => v.length <= 25 || 'Input too long!',
            pagination: {},
            headers: [
                {
                    text: 'Rut',
                    align: 'start',
                    value: 'patient_rut'
                },
                { text: 'Resultado', value: 'result' },
                { text: 'Toma muestra', value: 'sampled_at' },
                { text: 'Recepción', value: 'received_at' },
                { text: 'Validación', value: 'validated_at' },
                { text: 'Procedencia', value: 'requesting_institution_name' }
            ],
            items: [],
            dialogPresidency: false,
            dialogDetail: false,
            presidencyData: {},
            dataModel: {
                currentStock: '',
                received: '',
                notified: '',
                finalStock: '',
                positive: '',
                totalPositive: '',
                totalNotified: '',
                maximum_capacity: 1200,
                observations:
                    'Se reciben muestras de operativos municipales de búsqueda activa de casos (estrategia BAC)'
            },
            checkEditPresidencyForm: false
        }
    },
    created() {
        this.getRequestDetail()
    },
    computed: {
        filteredPatientWithoutRut() {
            return this.items.filter(
                patient =>
                    patient.patient_rut === '' || patient.patient_rut === null
            )
        },
        disableDownload() {
            return this.items.length !== 0
        }
    },
    methods: {
        async storePresidency() {
            try {
                const { data } = await axios.post(
                    '/api/management/presidencies-statistics',
                    this.dataModel
                )

                if (data.status) {
                    this.downloadExcelPresidency()
                    this.dialogPresidency = false
                }
            } catch (error) {
                console.log(error)
            }
        },
        async getDailyPresidency() {
            this.dialogPresidency = true
            try {
                const { data } = await axios.get(
                    '/api/management/agregate-data'
                )
                this.presidencyData = data.test.full_presidency.data.filter(
                    data =>
                        data.processing_laboratory.description ===
                        'LABORATORIO HHHA'
                )[0]
                this.dataModel.currentStock = this.presidencyData.detail.filter(
                    data => data.description === 'Stock actual'
                )[0].count
                this.dataModel.positive = this.presidencyData.detail.filter(
                    data => data.description === 'Positivo'
                )[0].count
                this.dataModel.finalStock = this.presidencyData.detail.filter(
                    data => data.description === 'Stock Final'
                )[0].count
                this.dataModel.notified = this.presidencyData.detail.filter(
                    data => data.description === 'Notificado'
                )[0].count
                this.dataModel.received = this.presidencyData.detail.filter(
                    data => data.description === 'Recepcionado'
                )[0].count
                this.dataModel.totalNotified = this.presidencyData.detail.filter(
                    data => data.description === 'Total notificados'
                )[0].count
                this.dataModel.totalPositive = this.presidencyData.detail.filter(
                    data => data.description === 'Total positivos'
                )[0].count
            } catch (error) {
                console.log(error)
            }
        },
        async getRequestDetail() {
            try {
                const { data } = await axios.get(
                    '/api/management/minsal-details'
                )

                this.items = data.filter(patient => patient.patient_rut === '')
            } catch (error) {
                console.log(error)
            }
        },
        handleModalDetail() {
            this.dialogDetail = true
        },
        async downloadExcel() {
            const config = {
                responseType: 'blob' // o blob o arraybuffer
            }
            const response = await axios.get(
                '/api/management/download-file',
                config
            )

            const file = response.headers['content-disposition'].split(
                'filename='
            )[1]

            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `${file}`)
            document.body.appendChild(link)
            link.click()

            this.dialogDetail = false
        },
        async downloadExcelPresidency() {
            const config = {
                responseType: 'blob' // o blob o arraybuffer
            }
            const response = await axios.get(
                '/api/management/download-file-presidency',
                config
            )

            const file = response.headers['content-disposition'].split(
                'filename='
            )[1]

            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `${file}`)
            document.body.appendChild(link)
            link.click()
        },
        async save(item) {
            try {
                const {
                    data
                } = await axios.put(
                    `/api/management/minsal-details/${item.id}`,
                    { patient_rut: item.patient_rut }
                )
                this.snack = true
                this.snackColor = 'success'
                this.snackText = 'Datos guardados'

                this.getRequestDetail()
                // console.log(data)
            } catch (error) {
                console.log(error)
            }
        },
        cancel() {
            this.snack = true
            this.snackColor = 'error'
            this.snackText = 'Canceled'
        },
        open() {
            this.snack = true
            this.snackColor = 'info'
            this.snackText = 'Dialog opened'
        },
        close() {
            console.log('Dialog closed')
        }
    }
}
</script>

<style></style>
