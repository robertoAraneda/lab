<template>
    <div>
        <div v-if="!contentReady">
            <div v-if="!products.length" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div v-if="contentReady">
            <div>
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
            </div>
            <div v-if="formContent" class="card mt-2 card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ titleCard }}</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-3">
                                <div class="form-group">
                                    <label>Categoría: </label>
                                    <select2
                                        v-if="categories.length"
                                        :options="categories"
                                        v-model="selectedCategory"
                                    ></select2>
                                </div>
                            </div>
                            <div class="col-sm-5 col-md-5 col-5">
                                <div class="form-group">
                                    <label>Productos: </label>
                                    <select2
                                        v-if="productsFilteredByCategory.length"
                                        :options="productsFilteredByCategory"
                                        v-model="selectedProduct"
                                    ></select2>
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
            </div>
            <div class="card mt-2">
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
            </div>
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
            categories: [],
            selectedCategory: '',
            movementProducts: [],
            selectedProduct: '',
            selectedMovement: '',
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
            finalStock: ''
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
            if (this.selectedProduct !== '') {
                const selectedProduct_ = this.products.filter(product => {
                    return product.id === Number(this.selectedProduct)
                })

                console.log(selectedProduct_)

                this.finalStock = selectedProduct_[0].stock
            }
        }
    },
    methods: {
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
            const arrayDate = date.split('-')

            return `${arrayDate[2]}/${arrayDate[1]}/${arrayDate[0]}`
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
                this.products = json.products
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
                    find => find.id === Number(this.selectedProduct)
                )

                const product = this.products[editedIndex]

                if (
                    product.stock < this.quantity &&
                    this.selectedMovement === 'SALIDA'
                ) {
                    toast.fire({
                        icon: 'error',
                        title:
                            'La cantidad solicitada no puede ser menor al stock actual'
                    })
                    return
                }
                let params = {
                    product_id: this.selectedProduct,
                    quantity: this.quantity,
                    movement: this.selectedMovement
                }

                console.log(params)
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
                            product_id: this.selectedProduct,
                            stock: this.quantity,
                            movement: this.selectedMovement
                        }

                        const response_ = await axios.put(
                            `/api/store/products/${this.selectedProduct}`,
                            params
                        )

                        this.movementProducts.splice(4, 1)

                        this.movementProducts.unshift(json.movementProduct)
                        this.resetForm()
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
            this.titleCard = 'Editar registro'
            this.id = item.id
            this.description = item.description
            this.selectedState = item.state.id
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

            this.getProducts()
        },
        validateInput() {
            if (
                this.description === '' ||
                this.selectedState === 0 ||
                this.selectedCategory === 0 ||
                this.selectedProduct === 0
            ) {
                if (this.description === '') {
                    this.checkDescription = 'is-invalid'
                } else {
                    this.checkDescription = 'is-valid'
                }
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
