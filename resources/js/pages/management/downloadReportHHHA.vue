<template>
    <v-container fluid>
        <v-card
            elevation="5"
            class="mx-auto mb-2"
            color="grey lighten-3"
            @click="downloadExcel"
            :disabled="disableDownload"
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

        <v-card>
            <v-toolbar color="primary" dark dense>
                <v-toolbar-title class="subtitle-1"
                    >PACIENTES SIN RUT
                </v-toolbar-title>
            </v-toolbar>
            <v-data-table :headers="headers" :items="items">
                <template v-slot:item.patient_rut="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.patient_rut"
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

            <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
                {{ snackText }}

                <template v-slot:action="{ attrs }">
                    <v-btn v-bind="attrs" text @click="snack = false">
                        Close
                    </v-btn>
                </template>
            </v-snackbar>
        </v-card>
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
            items: []
        }
    },
    created() {
        this.getRequestDetail()
    },
    computed: {
        filteredPatientWithoutRut() {
            return this.items.filter(patient => patient.patient_rut === '')
        },
        disableDownload() {
            return this.items.length !== 0
        }
    },
    methods: {
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

            console.log(file)

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
