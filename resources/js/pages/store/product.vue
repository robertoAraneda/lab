<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="products"
            sort-by="description"
            class="elevation-1"
            :search="search"
        >
            <template v-slot:top>
                <v-toolbar dark flat color="blue">
                    <v-toolbar-title>REGISTRO DE PRODUCTOS</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        flat
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Buscar"
                        single-line
                        solo-inverted
                        hide-details
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                large
                                depressed
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
                                                v-model="editedItem.code"
                                                label="Código"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field
                                                solo-inverted
                                                single-line
                                                v-model="editedItem.description"
                                                label="Nombre"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field
                                                type="number"
                                                v-model="editedItem.stock"
                                                label="Stock"
                                                placeholder="Stock"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field
                                                type="number"
                                                v-model="
                                                    editedItem.critical_stock
                                                "
                                                label="Stock crítico"
                                                placeholder="Stock crítico"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-autocomplete
                                                v-model="editedItem.category"
                                                :items="categories"
                                                color="white"
                                                hide-details
                                                solo-inverted
                                                item-text="description"
                                                label="Categoria"
                                                return-object
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-autocomplete
                                                v-model="
                                                    editedItem.presentation
                                                "
                                                :items="presentations"
                                                color="white"
                                                hide-details
                                                solo-inverted
                                                item-text="description"
                                                label="Presentación"
                                                return-object
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-select
                                                return-object
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
                    <v-spacer></v-spacer>
                    <v-btn
                        color="white"
                        fab
                        small
                        dark
                        @click="downloadExcel"
                        class="ml-2"
                    >
                        <v-icon size="30" color="success darken-3"
                            >mdi-file-excel</v-icon
                        >
                    </v-btn>
                    <v-btn
                        color="white"
                        fab
                        small
                        dark
                        @click="exportPDF"
                        class="ml-2"
                    >
                        <v-icon size="30" color="red darken-3"
                            >mdi-file-pdf-box</v-icon
                        >
                    </v-btn>
                    <v-btn
                        color="white"
                        fab
                        small
                        dark
                        @click="print"
                        class="ml-2"
                    >
                        <v-icon size="30" color="grey darken-1"
                            >mdi-printer</v-icon
                        >
                    </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon color="primary" class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon color="primary" @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary">
                    Reset
                </v-btn>
            </template>
        </v-data-table>

        <!--         <div v-if="!contentReady">
            <div v-if="!products.length" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div v-if="contentReady">
            <div v-if="formContent" class="card mt-2 card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ titleCard }}</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-4">
                                <div class="form-group">
                                    <input type="hidden" v-model="id" />
                                    <label>Código: </label>
                                    <input
                                        v-model="code"
                                        :class="checkCode"
                                        type="text"
                                        class="form-control"
                                        placeholder="Código"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8 col-8">
                                <div class="form-group">
                                    <label>Nombre: </label>
                                    <input
                                        v-model="description"
                                        :class="checkDescription"
                                        type="text"
                                        class="form-control"
                                        placeholder="Nombre"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-md-2 col-2">
                                <div class="form-group">
                                    <label>Stock: </label>
                                    <input
                                        v-model="stock"
                                        :class="checkStock"
                                        type="number"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-2">
                                <div class="form-group">
                                    <label>Stock crítico: </label>
                                    <input
                                        v-model="critical_stock"
                                        :class="checkCriticalStock"
                                        type="number"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-4">
                                <div class="form-group">
                                    <label>Bodega: </label>
                                    <select2
                                        name="SELECCIONE:"
                                        v-if="categories.length"
                                        :options="categoriesSelect"
                                        v-model="selectedCategory"
                                    ></select2>
                                    <label v-if="checkStore" class="text-danger"
                                        >Seleccione una bodega*</label
                                    >
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-4">
                                <div class="form-group">
                                    <label>Estado: </label>
                                    <select2
                                        v-if="states.length"
                                        :options="states"
                                        v-model="selectedState"
                                    ></select2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button
                            v-if="!editing"
                            @click.prevent="save"
                            class="btn btn-default float-right ml-2"
                        >
                            Guardar
                        </button>
                        <button
                            v-if="editing"
                            @click.prevent="edit"
                            class="btn btn-warning float-right ml-2"
                        >
                            Editar
                        </button>
                        <button
                            @click.prevent="cancelButton"
                            class="btn btn-danger float-right"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
            <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <div class="card-tools">
                        <button
                            v-if="!editing"
                            @click="setFormContent"
                            type="button"
                            class="btn btn-success float-right"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="CREAR REGISTRO"
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-header">
                    <div
                        class="input-group input-group-sm card-title"
                        style="width: 250px;"
                    >
                        <h5 class="mt-2">Mostrar</h5>
                        <div class="input-group-append">
                            <select
                                class="card-title form-control show-select"
                                v-model="perPage"
                            >
                                <option value="20">20</option>
                                <option value="10">10</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="input-group-append">
                            <h5 class="mt-2 ml-2">registros</h5>
                        </div>
                    </div>
                    <div class="card-tools">
                        <div class="input-group mb-2 mt-1">
                            <input
                                type="text"
                                v-model="search_item"
                                class="form-control float-right"
                                placeholder="Buscar"
                            />
                            <div class="input-group-append">
                                <span class="input-group-text"
                                    ><i class="fas fa-search"></i
                                ></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <th scope="col">Código</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Bodega</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </thead>
                        <tbody
                            v-for="(item, index) in setPaginate"
                            :key="item.id"
                        >
                            <th scope="row">{{ item.code }}</th>
                            <td scope="row">{{ item.description }}</td>
                            <td scope="row">{{ item.category.description }}</td>
                            <td scope="row">{{ item.stock }}</td>
                            <td scope="row">
                                <span
                                    :class="
                                        item.state.id === 1
                                            ? 'badge badge-success'
                                            : 'badge badge-danger'
                                    "
                                >
                                    {{ item.state.description }}</span
                                >
                            </td>
                            <td
                                scope="row"
                                class="text-center py-1 align-middle"
                            >
                                <div class="btn-group btn-group-sm">
                                    <button
                                        @click.prevent="setEdit(item)"
                                        class="btn btn-warning mx-1"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="EDITAR REGISTRO"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button
                                        class="btn btn-danger mx-1"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="ELIMINAR REGISTRO"
                                        @click.prevent="destroy(item, index)"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center bg-white">
                    <div class="float-right">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" :class="disabledPrev">
                                    <button @click="prevPage" class="page-link">
                                        Anterior
                                    </button>
                                </li>
                                <li
                                    v-for="pageNumber in pages.slice(
                                        page - 1,
                                        page + 4
                                    )"
                                    :key="pageNumber"
                                    class="page-item"
                                >
                                    <button
                                        @click="currentPage(pageNumber)"
                                        class="page-link"
                                    >
                                        {{ pageNumber }}
                                    </button>
                                </li>
                                <li class="page-item" :class="disabledNext">
                                    <button @click="nextPage" class="page-link">
                                        Siguiente
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="float-left mt-2">
                        <h5>
                            Mostrando {{ from }} a {{ to }} de
                            {{ setPaginate.length }} registros
                        </h5>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
import jsPDF from 'jspdf'
import 'jspdf-autotable'

export default {
    name: 'productComponent',
    data: function() {
        return {
            progress: 0,
            titleCard: '',
            search_item: '',
            states: [],
            selectedState: 1,
            products: [],
            categories: [],
            selectedCategory: 0,
            description: '',
            code: '',
            stock: '',
            critical_stock: '',
            checkCriticalStock: '',
            checkDescription: '',
            checkCode: '',
            checkStock: '',
            checkStore: false,
            id: '',
            editing: false,
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: '',
            headers: [
                {
                    text: 'CÓDIGO',
                    align: 'start',
                    sortable: true,
                    value: 'code'
                },
                { text: 'NOMBRE', value: 'description' },
                { text: 'PRESENTACIÓN', value: 'presentation.description' },
                { text: 'BODEGA', value: 'category.description' },
                { text: 'STOCK', value: 'stock' },
                { text: 'STOCK CRITICO', value: 'critical_stock' },
                { text: 'OPCIONES', value: 'actions', sortable: false }
            ],
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                code: '',
                description: '',
                stock: '',
                critical_stock: '',
                category: null,
                presentation: null,
                state: null
            },
            defaultItem: {
                code: '',
                description: '',
                stock: '',
                critical_stock: '',
                category: null,
                presentation: null,
                state: null
            },
            presentations: [],
            search: ''
        }
    },
    created: function() {
        this.startProgressiveBar()
        this.getProducts()
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? 'Nuevo producto'
                : 'Modificar producto'
        },
        filterData() {
            const filtered = this.products.filter(product => {
                return product.description
                    .toLowerCase()
                    .match(this.search_item.toLowerCase())
            })
            return filtered
        },
        setPaginate() {
            return this.paginate(this.filterData)
        },
        from() {
            if (this.page === 1 && this.setPaginate.length == 0) {
                return 0
            } else if (this.page === 1) {
                return 1
            } else {
                return this.page * this.setPaginate.length - this.perPage
            }
        },
        to() {
            if (this.page === 1) {
                return this.setPaginate.length
            }
            return this.page * this.perPage
        },
        categoriesSelect() {
            return this.parseSelect(this.categories)
            // return format.push({
            //     id: 0,
            //     text: 'SELECCIONE:'
            // })
        }
    },
    watch: {
        dialog(val) {
            this.categories.length === 0 ? this.getCategories() : ''
            this.presentations.length === 0 ? this.getPresentations() : ''
            this.states.length === 0 ? this.getState() : ''
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
        page() {
            this.isPrevDisabled()
            this.isNextDisabled()
        },
        filterData() {
            this.pages = []
            this.page = 1
            this.setPages()
        },
        pages() {
            if (this.pages.length <= 1) {
                this.disabledNext = 'disabled'
            } else {
                this.disabledNext = ''
            }
        },
        perPage() {
            this.pages = []
            this.page = 1
            this.setPages()
        },
        selectedCategory() {
            if (this.selectedCategory === 0) {
                this.checkStore = true
            } else {
                this.checkStore = false
            }
        }
    },
    methods: {
        print() {
            window.print()
        },
        exportPDF() {
            var vm = this
            var columns = [
                { title: 'CODIGO', dataKey: 'code' },
                { title: 'NOMBRE', dataKey: 'description' },
                { title: 'CATEGORIA', dataKey: 'completedCategory' },
                { title: 'PRESENTACION', dataKey: 'completedPresentation' },
                { title: 'STOCK', dataKey: 'stock' },
                { title: 'STOCK CRITICO', dataKey: 'critical_stock' }
            ]
            var doc = new jsPDF('p', 'pt')
            doc.text('Lista de productos', 40, 40)

            const head = [columns.map(column => column.title)]

            const body = vm.products.map(product => {
                return [
                    product.code,
                    product.description,
                    product.completedCategory,
                    product.completedPresentation,
                    product.stock,
                    product.critical_stock
                ]
            })

            doc.autoTable({
                margin: { top: 60 },
                body: body,
                columns: columns
            })
            //    doc.autoPrint() // <<--------------------- !!
            doc.output('dataurlnewwindow')

            // window.open(doc.output('presentaciones'))
            // doc.save('presentaciones.pdf')
        },
        async downloadExcel() {
            const config = {
                responseType: 'blob' // o blob o arraybuffer
            }
            const response = await axios.get(
                '/api/store/download-file-product',
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
        editItem(item) {
            this.editedIndex = this.products.indexOf(item)

            this.editedItem = Object.assign({}, item)
            this.dialog = true

            console.log('item', this.editedItem)
        },

        deleteItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)

            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            try {
                const response = await axios.delete(
                    `/api/store/products/${this.editedItem.id}`
                )

                if (response.status === 200) {
                    toast.fire({
                        icon: 'success',
                        title: 'El registro ha sido eliminado exitosamente'
                    })

                    this.products.splice(this.editedIndex, 1)
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

        startProgressiveBar() {
            let width = 0
            const vm = this
            let progress = setInterval(function() {
                if (vm.progress <= 99) {
                    vm.progress += width
                    width += 0.1
                }
                if (vm.products.length) {
                    vm.progress = 100
                    clearInterval(progress)
                    vm.contentReady = true
                }
            }, 300)
        },
        currentPage(page) {
            this.page = page
        },
        prevPage() {
            this.page--
        },
        nextPage() {
            this.page++
        },
        isPrevDisabled() {
            if (this.page !== 1) {
                this.disabledPrev = ''
            } else {
                this.disabledPrev = 'disabled'
            }
        },
        isNextDisabled() {
            if (this.page < this.pages.length) {
                this.disabledNext = ''
            } else {
                this.disabledNext = 'disabled'
            }
        },
        setPages() {
            let numberOfPages = []
            numberOfPages = Math.ceil(this.filterData.length / this.perPage)
            for (let i = 1; i <= numberOfPages; i++) {
                this.pages.push(i)
            }
        },
        paginate(array) {
            let page = this.page
            let perpage = this.perPage
            let from = page * perpage - perpage
            let to = page * perpage

            return array.slice(from, to)
        },
        setFormContent() {
            this.titleCard = 'Crear nuevo registro'
            this.formContent = true
        },
        async getState() {
            try {
                let response = await fetch('/api/state')
                let json = await response.json()
                this.states = this.parseSelect(json.states)
            } catch (e) {
                console.log(e)
            }
        },
        async getProducts() {
            try {
                let response = await fetch('/api/store/products')
                let json = await response.json()

                this.products = json.products.map(product => {
                    console.log(product)
                    const completedCategory = product.category.description
                    const completedPresentation =
                        product.presentation === null
                            ? ''
                            : product.presentation.description

                    return Object.assign(product, {
                        completedCategory: completedCategory,
                        completedPresentation: completedPresentation
                    })
                })
            } catch (error) {
                console.log(error)
            }
        },
        async getPresentations() {
            try {
                let response = await fetch('/api/store/presentations')
                let json = await response.json()

                console.log(json)
                this.presentations = json.presentations
            } catch (error) {
                console.log(error)
            }
        },
        async getCategories() {
            try {
                let response = await fetch('/api/store/categories')
                let json = await response.json()

                this.categories = json.categories
            } catch (error) {
                console.log(error)
            }
        },
        parseSelect: function(array) {
            const res = array.map(function(obj) {
                return {
                    id: obj.id,
                    text: obj.description
                }
            })
            return res
        },
        async save() {
            if (this.validateInput()) {
                if (this.editedIndex > -1) {
                    const params = {
                        code: this.editedItem.code,
                        description: this.editedItem.description,
                        category_id: this.editedItem.category.id,
                        stock: this.editedItem.stock,
                        critical_stock: this.editedItem.critical_stock,
                        state_id: this.editedItem.state.id,
                        presentation_id: this.editedItem.presentation.id
                    }

                    console.log(params)
                    try {
                        const response = await axios.put(
                            `/api/store/products/${this.editedItem.id}`,
                            params
                        )

                        console.log(response)

                        if (response.status === 200) {
                            this.products.splice(
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
                        code: this.editedItem.code,
                        description: this.editedItem.description,
                        category_id: this.editedItem.category.id,
                        stock: this.editedItem.stock,
                        critical_stock: this.editedItem.critical_stock,
                        state_id: this.editedItem.state.id,
                        presentation_id: this.editedItem.presentation.id
                    }
                    try {
                        const crfToken = document.head.querySelector(
                            'meta[name="csrf-token"]'
                        )
                        const token = crfToken.getAttribute('content')
                        const url = '/api/store/products'

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

                            this.products.unshift(this.editedItem)

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

        setEdit(item) {
            this.titleCard = 'Editar registro'
            this.id = item.id
            this.code = item.code
            this.description = item.description
            this.selectedCategory = item.category.id
            this.selectedState = item.state.id
            this.stock = item.stock
            this.editing = true
            this.formContent = true
        },
        cancelButton() {
            this.editing = false
            this.resetForm()
        },
        async destroy(item, index) {
            const confirmation = await swal.fire({
                title: '¿Estás seguro?',
                text: 'El registro se eliminará permanentemente',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            })
            if (confirmation.value) {
                try {
                    const response = await axios.delete(
                        `/api/store/products/${item.id}`
                    )

                    if (response.status === 200) {
                        toast.fire({
                            icon: 'success',
                            title: 'El registro ha sido eliminado exitosamente'
                        })
                        const editedIndex = this.products.findIndex(
                            find => find.id === item.id
                        )

                        this.products.splice(editedIndex, 1)
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        resetForm() {
            this.code = ''
            this.description = ''
            this.selectedCategory = 0
            this.stock = 0
            this.selectedState = 1
            this.id = ''
            this.formContent = false
            this.editing = false
        },
        validateInput() {
            if (
                this.editedItem.code === '' ||
                this.editedItem.description === 0 ||
                this.editedItem.stock === '' ||
                this.editedItem.critical_stock === '' ||
                this.editedItem.category === null ||
                this.editedItem.state === null ||
                this.editedItem.presentation === null
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

<style scoped>
.show-select {
    font-size: 14px;
    padding: 1px;
    height: 35px;
    width: 50px;
    margin-left: 5px;
}

h5 {
    font-size: 15px;
}
</style>
