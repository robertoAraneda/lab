<template>
    <div>
        <v-container v-if="!loadingFile" fluid>
            <v-row align-content="center" justify="center">
                <v-col cols="6">
                    <v-card class="mx-auto my-3">
                        <v-card-title>
                            Carga de archivo excel consolidado full
                        </v-card-title>
                        <v-card-text>
                            <v-file-input
                                v-model="file"
                                accept=".xlsx"
                                show-size
                                label="Subir archivo"
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
                    <v-card
                        v-if="latestUpload"
                        class="mx-auto text-center"
                        flat
                    >
                        <v-card-text class="text-center">
                            <p>
                                <b>Última actualización:</b>
                                {{ latestUpload.created_at }}
                            </p>
                            <p>
                                <b>Responsable:</b>
                                {{ latestUpload.created_user.name }}
                            </p>
                            <p>
                                <b>Nombre archivo:</b>
                                {{ latestUpload.file_name }}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-container v-else style="height: 400px;">
            <v-row class="fill-height" align-content="center" justify="center">
                <v-col class="subtitle-1 text-center" cols="12">
                    Cargando información...
                </v-col>
                <v-col cols="6">
                    <v-progress-linear
                        color="blue accent-4"
                        indeterminate
                        rounded
                        height="10"
                    ></v-progress-linear>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data: () => ({
        file: null,
        loadingFile: false,
        latestUpload: null
    }),
    created() {
        this.getLatestDateUploadFile()
    },
    methods: {
        async sendFile() {
            this.loadingFile = true
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

            this.loadingFile = false
            this.file = null
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
        async getLatestDateUploadFile() {
            try {
                const { data } = await axios.get('/api/management/latest-file')

                this.latestUpload = data

                console.log(data)
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style></style>
