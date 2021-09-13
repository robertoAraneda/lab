<template>
    <v-row justify="center">
        <v-col cols="11">
            <v-card>
                <v-toolbar dark color="blue darken-4">
                    <v-toolbar-title
                        >Listado de exámenes y códigos de
                        ingreso</v-toolbar-title
                    >
                </v-toolbar>

                <v-card-title>
                    <v-text-field
                        color="blue"
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Buscar"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="analytes"
                    :search="search"
                    :loading="loading"
                >
                    <template v-slot:item.tests="{ item }">
                        <p v-for="(test, index) in item.tests" :key="index">
                            {{ test.infinity_test.code }} -
                            {{ test.description }}
                        </p>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        analytes: [],
        headers: [
            {
                text: 'Nombre',
                filterable: true,
                value: 'description'
            },
            {
                text: 'Código Labdate',
                filterable: true,
                value: 'infinity_labdate_test.code'
            },
            {
                text: 'Código Infinity',
                filterable: true,
                value: 'hca_laboratory.internal_code'
            },
            {
                text: 'Código HIS',
                filterable: true,
                value: 'loinc.loinc_num'
            },
            {
                text: 'Área de trabajo',
                filterable: true,
                value: 'work_area.description'
            },
            {
                text: 'Disponibilidad',
                filterable: true,
                value: 'available.description'
            },
            {
                text: 'Pruebas',
                filterable: true,
                value: 'tests'
            }
        ],
        search: ''
    }),
    created() {
        this.fetchData()
    },

    computed: {
        loading() {
            return this.analytes.length === 0
        }
    },
    methods: {
        async fetchData() {
            const response = await fetch('/api/analytes/all')

            const json = await response.json()

            this.analytes = json.filter(
                analyte => analyte.infinity_labdate_test.code !== '0000'
            )
        }
    }
}
</script>
