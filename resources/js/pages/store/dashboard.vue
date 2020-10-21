<template>
    <v-card class="mx-auto" tile elevation="0">
         <v-toolbar dark flat color="blue">
                    <v-toolbar-title>Estado de productos</v-toolbar-title>
         </v-toolbar>
        <v-container fluid>
            <v-row dense>
           <!--      <v-col cols="3">
                    <v-card class="grow" outlined tile>
                        <v-card-title>
                            <span class="title font-weight-light ml-5"
                                >Productos</span
                            >
                        </v-card-title>
                        <v-card outlined tile>
                            <v-card-title>
                                <v-icon large left color="green darken-1">
                                    mdi-check-all
                                </v-icon>

                                <span class="title font-weight-light ml-5"
                                    >Total</span
                                >
                            </v-card-title>

                            <v-card-text
                                class="h2 font-weight-bold text-center"
                            >
                                55
                            </v-card-text>
                        </v-card>
                        <v-card tile outlined>
                            <v-card-title>
                                <v-icon large left color="orange darken-1">
                                    mdi-alert-rhombus
                                </v-icon>
                                <span class="title font-weight-light"
                                    >Stock crítico</span
                                >
                            </v-card-title>

                            <v-card-text
                                class="h2 font-weight-bold text-center"
                            >
                                55
                            </v-card-text>
                        </v-card>
                        <v-card tile outlined>
                            <v-card-title>
                                <v-icon large left color="red darken-2">
                                    mdi-close-box
                                </v-icon>
                                <span class="title font-weight-light"
                                    >Sin stock</span
                                >
                            </v-card-title>

                            <v-card-text
                                class="h2 font-weight-bold text-center"
                            >
                                55
                            </v-card-text>
                        </v-card>
                    </v-card>
                </v-col> -->
                <v-col cols="12">
                    <v-row dense>
                        <v-col cols="12">
                            <v-row dense>
                                <v-col cols="6">
                                    <v-card outlined tile>
                                        <v-card-title>
                                            <v-icon large left color="orange darken-1">
                                              mdi-alert-rhombus
                                            </v-icon>
                                            <span
                                                class="title font-weight-light"
                                                >Stock crítico</span
                                            >
                                        </v-card-title>

                                        <v-data-table
                                            dense
                                            :headers="headersCriticalStock"
                                            :items="productsWithCriticalStock"
                                            item-key="name"
                                            class="elevation-1"
                                        ></v-data-table>
                                    </v-card>
                                </v-col>
                                <v-col cols="6">
                                    <v-card outlined tile>
                                        <v-card-title>
                                            <v-icon large left color="red darken-2">
                                               mdi-close-box
                                            </v-icon>
                                            <span
                                                class="title font-weight-light"
                                                >Sin stock</span
                                            >
                                        </v-card-title>

                                        <v-data-table
                                            dense
                                            :headers="headersStock"
                                            :items="productWithoutStock"
                                            item-key="name"
                                            class="elevation-1"
                                        ></v-data-table>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
            <!--         <v-row dense>
                        <v-col cols="12">
                            <v-card tile outlined>
                                <v-card-title>
                                    <v-icon large left>
                                        mdi-twitter
                                    </v-icon>
                                    <span class="title font-weight-light"
                                        >Twitter</span
                                    >
                                </v-card-title>
                                <v-list three-line>
                                    <template v-for="(item, index) in items">
                                        <v-subheader
                                            v-if="item.header"
                                            :key="item.header"
                                            v-text="item.header"
                                        ></v-subheader>

                                        <v-divider
                                            v-else-if="item.divider"
                                            :key="index"
                                            :inset="item.inset"
                                        ></v-divider>

                                        <v-list-item v-else :key="item.title">
                                            <v-list-item-avatar>
                                                <v-img
                                                    :src="item.avatar"
                                                ></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    v-html="item.title"
                                                ></v-list-item-title>
                                                <v-list-item-subtitle
                                                    v-html="item.subtitle"
                                                ></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-col>
                    </v-row> -->
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
export default {
    name: 'storeDashboardComponent',
    data: () => ({
        headersCriticalStock: [
            {
                text: 'Producto',
                align: 'start',
                sortable: true,
                value: 'description'
            },
            { text: 'Stock', value: 'stock' }
        ],
        headersStock: [
            {
                text: 'Producto',
                align: 'start',
                sortable: true,
                value: 'description'
            },
            { text: 'Stock', value: 'stock' }
        ],
        desserts: [
            {
                product: 'Frozen Yogurt',
                stock: 159
            },
            {
                product: 'Ice cream sandwich',
                stock: 237
            },
            {
                product: 'Eclair',
                stock: 262
            }
        ],
        items: [
            { header: 'Today' },
            {
                avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
                title: 'Brunch this weekend?',
                subtitle:
                    "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
            },
            { divider: true, inset: true },
            {
                avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
                title:
                    'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
                subtitle:
                    "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
            },
            { divider: true, inset: true },
            {
                avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                title: 'Oui oui',
                subtitle:
                    "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
            },
            { divider: true, inset: true },
            {
                avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                title: 'Oui oui',
                subtitle:
                    "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
            },
            { divider: true, inset: true },
            {
                avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                title: 'Oui oui',
                subtitle:
                    "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
            }
        ],
        products: []
    }),
    created() {
        this.getProducts()
    },
    computed: {
        productsWithCriticalStock() {
            return this.products.filter(
                product => product.critical_stock >= product.stock
            )
        },
        productWithoutStock() {
            return this.products.filter(product => product.stock === 0)
        }
    },
    methods: {
        async getProducts() {
            try {
                let response = await fetch('/api/store/products')
                let json = await response.json()

                console.log(json)
                this.products = json.products
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style></style>
