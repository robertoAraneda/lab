<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="presentations"
            sort-by="description"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>REGISTRO DE PRODUCTOS</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                CREAR PRODUCTO
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field
                                                solo-inverted
                                                single-line
                                                v-model="editedItem.description"
                                                label="Nombre"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-select
                                                return-object
                                                item-text="description"
                                                solo-inverted
                                                :items="states"
                                                v-model="editedItem.state"
                                                label="Estado"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-2"
                                    text
                                    @click="close"
                                >
                                    Cancelar
                                </v-btn>
                                <v-btn color="blue darken-2" text @click="save">
                                    Guardar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="480px">
                        <v-card>
                            <v-card-title class="headline text-center"
                                >¿Estás seguro que quieres eliminar este
                                registro?</v-card-title
                            >
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-2"
                                    text
                                    @click="closeDelete"
                                    >CANCELAR</v-btn
                                >
                                <v-btn
                                    color="blue darken-2"
                                    text
                                    @click="deleteItemConfirm"
                                    >ACEPTAR</v-btn
                                >
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon color="orange" class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon color="red" @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary">
                    Reset
                </v-btn>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
export default {
    data: () => {
        return {
            headers: [
                { text: 'NOMBRE', value: 'description' },
                { text: 'ESTADO', value: 'state.description' },
                { text: 'OPCIONES', value: 'actions', sortable: false }
            ],
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                description: '',
                state: null
            },
            defaultItem: {
                description: '',
                state: null
            },
            presentations: [],
            states: []
        }
    },
    created() {
        this.getPresentations()
    },
    watch: {
        dialog(val) {
            this.getStates()
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? 'Nueva presentación'
                : 'Modificar presentación'
        }
    },
    methods: {
        async save() {
            if (this.validateInput()) {
                if (this.editedIndex > -1) {
                    const params = {
                        description: this.editedItem.description,
                        state_id: this.editedItem.state.id
                    }
                    try {
                        const response = await axios.put(
                            `/api/store/presentations/${this.editedItem.id}`,
                            params
                        )

                        if (response.status === 200) {
                            this.presentations.splice(
                                this.editedIndex,
                                1,
                                this.editedItem
                            )

                            toast.fire({
                                icon: 'success',
                                title:
                                    'El registro ha sido editado exitosamente'
                            })
                            this.close()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                } else {
                    const params = {
                        description: this.editedItem.description,
                        state_id: this.editedItem.state.id
                    }
                    try {
                        const crfToken = document.head.querySelector(
                            'meta[name="csrf-token"]'
                        )
                        const token = crfToken.getAttribute('content')
                        const url = '/api/store/presentations'

                        const options = {
                            method: 'POST',
                            body: JSON.stringify(params),
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        }
                        const response = await fetch(url, options)

                        if (response.status >= 200 && response.status < 300) {
                            const json = await response.json()

                            this.presentations.unshift(this.editedItem)

                            this.close()
                        } else {
                            this.showErrorToast(response)
                        }
                    } catch (e) {
                        console.log(e)
                        this.showErrorSwal(e)
                    }
                }
            }
        },

        editItem(item) {
            this.editedIndex = this.presentations.indexOf(item)

            this.editedItem = Object.assign({}, item)
            this.dialog = true

            console.log(this.editedItem)
        },

        deleteItem(item) {
            this.editedIndex = this.presentations.indexOf(item)
            this.editedItem = Object.assign({}, item)

            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            try {
                const response = await axios.delete(
                    `/api/store/presentations/${this.editedItem.id}`
                )

                if (response.status === 200) {
                    toast.fire({
                        icon: 'success',
                        title: 'El registro ha sido eliminado exitosamente'
                    })

                    this.presentations.splice(this.editedIndex, 1)
                    this.closeDelete()
                }
            } catch (e) {
                console.log(e)
            }
        },

        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        async getPresentations() {
            try {
                let response = await fetch('/api/store/presentations')
                let json = await response.json()

                this.presentations = json.presentations
            } catch (error) {
                console.log(error)
            }
        },
        async getStates() {
            try {
                let response = await fetch('/api/state')
                let json = await response.json()

                this.states = json.states
            } catch (error) {
                console.log(error)
            }
        },
        validateInput() {
            if (
                this.editedItem.description === 0 ||
                this.editedItem.state === null
            ) {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los campos necesarios'
                })
                return false
            } else {
                return true
            }
        },
        showErrorSwal(error) {
            swal.fire({
                icon: 'error',
                title: error.message,
                text: 'Error grave. Contacte a desarrollo informático'
            })
        },
        showErrorToast(response) {
            toast.fire({
                icon: 'error',
                title: `Error: ${response.status}: ${response.statusText}`
            })
        }
    }
}
</script>

<style></style>
