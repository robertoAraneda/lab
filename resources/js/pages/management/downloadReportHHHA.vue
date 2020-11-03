<template>
    <v-container fluid>
        <v-card
            elevation="5"
            class="mx-auto mb-2"
            color="grey lighten-3"
            @click="check"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        REPORTE
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
            <v-data-table :headers="headers" :items="desserts">
                <template v-slot:item.name="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.name"
                        @save="save"
                        @cancel="cancel"
                        @open="open"
                        @close="close"
                    >
                        {{ props.item.name }}
                        <template v-slot:input>
                            <v-text-field
                                v-model="props.item.name"
                                :rules="[max25chars]"
                                label="Edit"
                                single-line
                                counter
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.iron="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.iron"
                        large
                        persistent
                        @save="save"
                        @cancel="cancel"
                        @open="open"
                        @close="close"
                    >
                        <div>{{ props.item.iron }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Iron
                            </div>
                            <v-text-field
                                v-model="props.item.iron"
                                :rules="[max25chars]"
                                label="Edit"
                                single-line
                                counter
                                autofocus
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
                    text: 'Dessert (100g serving)',
                    align: 'start',
                    sortable: false,
                    value: 'name'
                },
                { text: 'Calories', value: 'calories' },
                { text: 'Fat (g)', value: 'fat' },
                { text: 'Carbs (g)', value: 'carbs' },
                { text: 'Protein (g)', value: 'protein' },
                { text: 'Iron (%)', value: 'iron' }
            ]
        }
    },
    methods: {
        async check() {
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
        save() {
            this.snack = true
            this.snackColor = 'success'
            this.snackText = 'Data saved'
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
