<template>
    <div>
        <v-alert v-if="alarmStock" v-model="alarmStock" prominent type="error">
            <v-row align="center">
                <v-col class="grow">
                    Producto con stock crítico {{ editedProduct.description }}
                </v-col>
                <v-col class="shrink">
                    <v-btn @click="alarmStock = false">ACEPTAR</v-btn>
                </v-col>
            </v-row>
        </v-alert>
        <!--         <div v-if="!contentReady">
            <div v-if="!products.length" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div> -->
        <div v-if="contentReady">
            <!--             <div>
                <button
                    v-if="!editing"
                    @click="setFormContent"
                    type="button"
                    class="btn btn-success"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="CREAR REGISTRO"
                >
                    GENERAR MOVIMIENTO
                    <i class="fas fa-plus"></i>
                </button>
            </div> -->

            <v-container>
                <v-data-table
                    v-if="movementProducts"
                    :headers="headers"
                    :items="movementProducts"
                    sort-by="product.name"
                    class="elevation-1"
                    :search="search"
                >
                    <template v-slot:top>
                        <v-toolbar flat color="blue" dark>
                            <v-toolbar-title
                                >Movimiento de productos</v-toolbar-title
                            >
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        color="primary"
                                        dark
                                        depressed
                                        large
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        Generar movimiento
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{
                                            formTitle
                                        }}</span>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-container>
                                            <v-row justify="center">
                                                <v-col
                                                    cols="6"
                                                    v-if="
                                                        selectedProduct !== null
                                                    "
                                                >
                                                    <v-alert
                                                        :type="typeAlertStock"
                                                    >
                                                        Stock actual:
                                                        <span
                                                            class="font-weight-bold body-1"
                                                            >{{
                                                                finalStock
                                                            }}</span
                                                        >
                                                    </v-alert>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-autocomplete
                                                        v-model="
                                                            selectedProduct
                                                        "
                                                        :items="products"
                                                        color="white"
                                                        hide-details
                                                        solo-inverted
                                                        item-text="completedName"
                                                        label="Productos"
                                                        return-object
                                                    >
                                                        <template
                                                            v-slot:item="data"
                                                        >
                                                            <v-list-item-content>
                                                                <v-list-item-title
                                                                    v-html="
                                                                        data
                                                                            .item
                                                                            .code
                                                                    "
                                                                ></v-list-item-title>
                                                                <v-list-item-subtitle
                                                                    v-html="
                                                                        data
                                                                            .item
                                                                            .description
                                                                    "
                                                                ></v-list-item-subtitle>
                                                            </v-list-item-content>
                                                        </template>
                                                    </v-autocomplete>
                                                </v-col>
                                                <v-col cols="12"
                                                    ><v-text-field
                                                        solo-inverted
                                                        v-model="category"
                                                        label="Categoria"
                                                        disabled
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12"
                                                    ><v-text-field
                                                        solo-inverted
                                                        v-model="presentation"
                                                        label="Presentación"
                                                        disabled
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-select
                                                        solo-inverted
                                                        :items="movements"
                                                        v-model="
                                                            selectedMovement
                                                        "
                                                        label="Movimiento"
                                                    ></v-select>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-text-field
                                                        v-model="quantity"
                                                        :class="checkQuantity"
                                                        type="number"
                                                        label="Cantidad"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="blue darken-1"
                                            text
                                            @click="close"
                                        >
                                            CANCELAR
                                        </v-btn>
                                        <v-btn
                                            color="blue darken-1"
                                            text
                                            @click="save"
                                        >
                                            GUARDAR
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
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
                            <v-dialog v-model="dialogDelete" max-width="480px">
                                <v-card>
                                    <v-card-title class="headline"
                                        >¿Estás seguro que quieres eliminar el
                                        registro?</v-card-title
                                    >
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="blue darken-1"
                                            text
                                            @click="closeDelete"
                                            >CANCELAR</v-btn
                                        >
                                        <v-btn
                                            color="blue darken-1"
                                            text
                                            @click="deleteItemConfirm"
                                            >ACEPTAR</v-btn
                                        >
                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-spacer></v-spacer>
                            <v-btn icon @click="downloadExcel">
                                <v-icon size="50" color="white"
                                    >mdi-file-excel</v-icon
                                >
                            </v-btn>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.movement="{ item }">
                        <v-chip :color="getColor(item.movement)" dark>
                            {{ item.movement }}
                        </v-chip>
                    </template>
                    <!--                 <template v-slot:item.actions="{ item }">
                    <v-icon class="mr-2" @click="setEdit(item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                </template> -->
                    <template v-slot:no-data>
                        <span class="headline">No existen elementos</span>
                    </template>
                </v-data-table>
            </v-container>
            <!--     <div v-if="formContent" class="card mt-2 card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ titleCard }}</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 col-md-5 col-5">
                                <div class="form-group">
                                    <label>Productos: </label>
                                    <select2
                                        v-if="productSelect.length"
                                        :options="productSelect"
                                        v-model="selectedProduct"
                                        name="PRODUCTOS:"
                                    ></select2>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-3">
                                <div class="form-group">
                                    <label>Bodega: </label>
                                    <input
                                        v-model="category"
                                        type="text"
                                        class="form-control"
                                        placeholder="Categoría"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-2">
                                <div class="form-group">
                                    <label>Movimiento: </label>
                                    <select2
                                        v-if="movements.length"
                                        :options="movements"
                                        v-model="selectedMovement"
                                    ></select2>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-2">
                                <div class="form-group">
                                    <label>Cantidad: </label>
                                    <input
                                        v-model="quantity"
                                        :class="checkQuantity"
                                        type="number"
                                        class="form-control"
                                        placeholder="Valor"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <h4 v-if="selectedProduct !== ''" class="float-left">
                            Stock actual: {{ finalStock }}
                        </h4>
                        <button
                            v-if="!editing"
                            @click.prevent="save"
                            class="btn btn-default float-right ml-2"
                        >
                            Guardar
                        </button>
                        <button
                            @click.prevent="cancelButton"
                            class="btn btn-danger float-right"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div> -->

            <!--      <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <div class="card-tools">Últimos 5 movimientos</div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Movimiento</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Usuario</th>
                        </thead>
                        <tbody
                            v-for="(item, index) in setPaginate"
                            :key="item.id"
                            v-if="movementProducts.lenght !== 0"
                        >
                            <th
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ formatDate(item.created_at.split(' ')[0]) }}
                            </th>
                            <th
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ item.created_at.split(' ')[1] }}
                            </th>
                            <td
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ item.product.description }}
                            </td>
                            <td
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ item.movement }}
                            </td>
                            <td
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ item.quantity }}
                            </td>
                            <td
                                :class="
                                    item.movement === 'ENTRADA'
                                        ? 'table-success'
                                        : 'table-danger'
                                "
                            >
                                {{ item.user.name }}
                            </td>
                        </tbody>
                        <tbody v-else>
                            <td>No se encuentran registros</td>
                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
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
            category: '',
            selectedCategory: '',
            movementProducts: [],
            selectedProduct: null,
            selectedMovement: null,
            movements: ['ENTRADA', 'SALIDA'],
            quantity: '',
            checkQuantity: '',
            id: '',
            editing: false,
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: '',
            finalStock: '',

            snack: false,
            snackColor: '',
            snackText: '',
            max25chars: v => v.length <= 25 || 'Input too long!',
            pagination: {},
            headers: [
                {
                    text: 'FECHA - HORA',
                    align: 'start',
                    sortable: true,
                    value: 'created_at'
                },
                { text: 'PRODUCTO', value: 'product.description' },
                { text: 'MOVIMIENTO', value: 'movement' },
                { text: 'CANTIDAD', value: 'quantity' },
                { text: 'USUARIO RESPONSABLE', value: 'user.name' }
                /*  { text: 'OPCIONES', value: 'actions', sortable: false } */
            ],
            editedindex: -1,
            dialog: false,
            dialogDelete: false,
            date: '',
            alarmStock: false,
            editedProduct: null,
            typeAlertStock: '',
            search: '',
            presentation: ''
        }
    },
    created: function() {
        this.startProgressiveBar()
        this.getProducts()
        this.getState()
        this.getCategories()
        this.getMovementProducts()
    },
    computed: {
        formatDate_: {
            get() {
                return this.date
            },
            set(date) {
                console.log(date)
                const splitDate = date.split(' ')[0]

                const arrayDate = splitDate.split('-')

                this.date = `${arrayDate[2]}/${arrayDate[1]}/${
                    arrayDate[0]
                } - ${date.split(' ')[1]}`
            }
        },
        formTitle() {
            return this.editedindex === -1
                ? 'Generar movimiento de productos'
                : 'Editar producto'
        },
        filterData() {
            if (this.movementProducts.length === 0) return []
            const filtered = this.movementProducts.filter(movementProduct => {
                return movementProduct.product.description
                    .toLowerCase()
                    .match(this.search_item.toLowerCase())
            })
            return filtered
        },
        productsFilteredByCategory() {
            let filteredProducts = this.products.filter(product => {
                return product.category.id === Number(this.selectedCategory)
            })

            filteredProducts = filteredProducts.map(product => {
                return { id: product.id, text: product.description }
            })

            filteredProducts.unshift({ id: 0, text: 'SELECCIONE:' })

            return filteredProducts
        },
        productSelect() {
            return this.products.map(product => {
                return { id: product.id, text: product.description }
            })
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
        }
    },
    watch: {
        dialog(val) {
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
        selectedProduct() {
            if (this.selectedProduct !== null) {
                const selectedProduct_ = this.products.filter(product => {
                    return product.id === Number(this.selectedProduct.id)
                })

                if (
                    selectedProduct_[0].stock <=
                        selectedProduct_[0].critical_stock &&
                    selectedProduct_[0].stock > 0
                ) {
                    this.typeAlertStock = 'warning'
                } else if (
                    selectedProduct_[0].stock >
                    selectedProduct_[0].critical_stock
                ) {
                    this.typeAlertStock = 'success'
                } else {
                    this.typeAlertStock = 'error'
                }

                this.finalStock = selectedProduct_[0].stock
                this.category = selectedProduct_[0].category.description || ''
                this.presentation =
                    selectedProduct_[0].presentation.description || ''

                //this.selectedProduct = selectedProduct_[0]
            }
        }
    },
    methods: {
        async downloadExcel() {
            const config = {
                responseType: 'blob' // o blob o arraybuffer
            }
            const response = await axios.get(
                '/api/store/download-file-movement',
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
        getColor(movement) {
            if (movement === 'ENTRADA') return 'green'
            else return 'red'
        },
        editItem(item) {
            console.log(item)
            /*         this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item) */

            this.editedindex = 1
            this.id = item.id
            this.description = item.description
            this.selectedState = item.state.id
            this.editing = true
            this.formContent = true
            this.dialog = true
        },

        deleteItem(item) {
            /*    this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item) */
            this.dialogDelete = true
        },

        deleteItemConfirm() {
            /*     this.desserts.splice(this.editedIndex, 1) */
            this.closeDelete()
        },

        close() {
            this.selectedProduct = null
            this.selectedMovement = null
            this.category = ''
            this.quantity = 0
            this.dialog = false
            this.editedindex = -1

            /*         this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            }) */
        },

        closeDelete() {
            this.dialogDelete = false
            /*        this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            }) */
        },

        save() {
            /*             if (this.editedIndex > -1) {
                Object.assign(this.desserts[this.editedIndex], this.editedItem)
            } else {
                this.desserts.push(this.editedItem)
            } */
        },
        /*         save() {
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
        }, */
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
        formatDate(date) {
            console.log(date)
            const splitDate = date.split(' ')[0]

            const arrayDate = splitDate.split('-')

            return `${arrayDate[2]}/${arrayDate[1]}/${arrayDate[0]} - ${
                date.split(' ')[1]
            }`
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
        async getMovementProducts() {
            try {
                let response = await fetch('/api/store/movement-products')
                let json = await response.json()
                this.movementProducts = json.movementProducts
            } catch (e) {
                console.log(e)
            }
        },
        async getProducts() {
            try {
                let response = await fetch('/api/store/products')
                let json = await response.json()

                console.log(json)
                this.products = json.products.map(product => {
                    const completedName = `${product.code} | ${product.description} `

                    console.log(completedName)
                    return Object.assign(product, {
                        completedName: completedName
                    })
                })
            } catch (error) {
                console.log(error)
            }
        },
        async getCategories() {
            try {
                let response = await fetch('/api/store/categories')
                let json = await response.json()

                console.log(json)
                this.categories = this.parseSelect(json.categories)
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
                const editedIndex = this.products.findIndex(
                    find => find.id === Number(this.selectedProduct.id)
                )

                const product = this.products[editedIndex]

                if (
                    product.stock < this.quantity &&
                    this.selectedMovement === 'SALIDA'
                ) {
                    toast.fire({
                        icon: 'error',
                        title: 'No existen suficientes productos'
                    })
                    return
                }
                let params = {
                    product_id: this.selectedProduct.id,
                    quantity: this.quantity,
                    movement: this.selectedMovement
                }

                try {
                    const crfToken = document.head.querySelector(
                        'meta[name="csrf-token"]'
                    )
                    const token = crfToken.getAttribute('content')
                    let url = '/api/store/movement-products'

                    let options = {
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

                        params = {
                            product_id: this.selectedProduct.id,
                            stock: this.quantity,
                            movement: this.selectedMovement
                        }

                        const response_ = await axios.put(
                            `/api/store/products/${this.selectedProduct.id}`,
                            params
                        )
                        this.movementProducts.splice(4, 1)

                        this.movementProducts.unshift(json.movementProduct)

                        if (response_.status === 200) {
                            const checkStock =
                                response_.data.product.stock <=
                                response_.data.product.critical_stock

                            console.log('checkstock', checkStock)
                            console.log('stock', response_.data.product.stock)
                            console.log(
                                'critical stock',
                                response_.data.product.critical_stock
                            )

                            if (checkStock) {
                                this.editedProduct = response_.data.product
                                setTimeout(() => {
                                    this.alarmStock = false
                                    this.editedProduct = null
                                }, 5000)
                                this.alarmStock = true
                            }
                        }

                        this.resetForm()

                        this.close()
                    } else {
                        this.showErrorToast(response)
                    }
                } catch (e) {
                    console.log(e)
                    this.showErrorSwal(e)
                }
            }
        },
        setEdit(item) {
            this.editedindex = 1
            this.titleCard = 'Editar registro'
            this.id = item.id
            this.selectedProduct = item.product
            this.categoy = item.state.id
            this.editing = true
            this.formContent = true
        },
        async edit() {
            if (this.validateInput()) {
                const params = {
                    description: this.description,
                    state_id: this.selectedState
                }

                try {
                    const response = await axios.put(
                        `/api/store/products/${this.id}`,
                        params
                    )

                    if (response.status === 200) {
                        const index = this.products.findIndex(
                            find => find.id === response.data.product.id
                        )
                        console.log(index)
                        toast.fire({
                            icon: 'success',
                            title: 'El registro ha sido editado exitosamente'
                        })
                        this.products.splice(index, 1, response.data.product)
                        this.resetForm()
                    }
                } catch (e) {
                    console.log(e)
                }
            }
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
                        this.products.splice(index, 1)
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        resetForm() {
            this.selectedProduct = ''
            this.quantity = ''
            this.selectedMovement = ''

            this.id = ''
            this.formContent = true
            this.editing = false

            this.editedindex = -1
            this.getProducts()
        },
        validateInput() {
            if (
                this.selectedProduct === null ||
                this.selectedMovement === null ||
                this.category === '' ||
                this.quantity === ''
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
