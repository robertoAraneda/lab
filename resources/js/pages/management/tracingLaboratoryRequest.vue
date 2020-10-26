<template>
    <div>
        <v-card>
            <v-toolbar dark dense color="blue lighten-1">
                <v-toolbar-title>En proceso</v-toolbar-title>

                <v-spacer></v-spacer>
                <v-select
                    v-model="laboratory"
                    hide-details
                    solo-inverted
                    :items="laboratories"
                    label="Laboratorio"
                    dense
                ></v-select>
            </v-toolbar>
            <v-card-text>
                <v-data-table
                    dense
                    :headers="headers"
                    :items="filterRequest"
                    item-key="id_testing_request"
                    class="elevation-1"
                ></v-data-table>
            </v-card-text>
        </v-card>
        <v-card>
            <v-toolbar dark dense color="blue lighten-1">
                <v-toolbar-title>Recepcionadas sin distribución</v-toolbar-title>

                <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
                <v-data-table
                    dense
                    :headers="headersReceived"
                    :items="receiveds"
                    item-key="id_testing_request"
                    class="elevation-1"
                ></v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data: () => ({
        headers: [
            {
                text: 'N° Petición',
                align: 'start',
                value: 'id_testing_request'
            },
            { text: 'Laboratorio de proceso', value: 'processing_laboratory' },
            { text: 'Recepción', value: 'received_at' },
            { text: 'Distribución', value: 'distributed_at' }
        ],
        headersReceived: [
            {
                text: 'N° Petición',
                align: 'start',
                value: 'id_testing_request'
            },
            { text: 'Recepción', value: 'received_at' },
        ],
        items: [],
        receiveds: [],
        laboratories: ['LABORATORIO HHHA', 'LBDM-UFRO', 'LMM-UFRO', 'TODOS'],
        laboratory: 'TODOS'
    }),
    mounted() {
        this.getInProcessRequest()
        this.getReceivedRequest()
    },
    computed: {
        filterRequest() {
            if (this.laboratory === 'TODOS') {
                return this.items
            } else {
                return this.items.filter(request => {
                    return request.processing_laboratory === this.laboratory
                })
            }
        }
    },
    methods: {
        async getInProcessRequest() {
            try {
                const process = await fetch(
                    '/api/management/get-in-process-request'
                )

                const json = await process.json()

                this.items = json.inProcess
            } catch (error) {
                consle.log(error.message())
            }
        },

        async getReceivedRequest() {
            try {
                const process = await fetch('/api/management/received-request')

                const json = await process.json()

                this.receiveds = json.received

                console.log(this.receiveds)
            } catch (error) {
                console.log(error.message)
            }
        }
    }
}
</script>

<style></style>
