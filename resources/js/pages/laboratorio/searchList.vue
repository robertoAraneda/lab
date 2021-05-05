<template>
    <v-container fluid>
        <v-data-iterator
            :items="activeAnalytes"
            :items-per-page.sync="itemsPerPage"
            :page="page"
            :search="search"
            :sort-by="sortBy.toLowerCase()"
            :sort-desc="sortDesc"
            hide-default-footer
        >
            <template v-slot:header>
                <v-toolbar dark color="blue darken-3" class="mb-1">
                    <v-text-field
                        v-model="search"
                        clearable
                        flat
                        solo-inverted
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        label="Search"
                    ></v-text-field>
                    <template v-if="$vuetify.breakpoint.mdAndUp">
                        <v-spacer></v-spacer>
                        <v-select
                            v-model="sortBy"
                            flat
                            solo-inverted
                            hide-details
                            :items="keys"
                            prepend-inner-icon="mdi-magnify"
                            label="Sort by"
                        ></v-select>
                        <v-spacer></v-spacer>
                        <v-btn-toggle v-model="sortDesc" mandatory>
                            <v-btn large depressed color="blue" :value="false">
                                <v-icon>mdi-arrow-up</v-icon>
                            </v-btn>
                            <v-btn large depressed color="blue" :value="true">
                                <v-icon>mdi-arrow-down</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </template>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
                <v-row>
                    <v-col
                        v-for="item in props.items"
                        :key="item.id"
                        cols="12"
                        sm="6"
                    >
                        <v-hover v-slot:default="{ hover }" open-delay="100">
                            <v-card
                                :elevation="hover ? 16 : 2"
                                class="mx-auto"
                                @click="advancedSearch(item)"
                                height="150"
                                color="orange lighten-5"
                            >
                                <v-card-title
                                    class="subheading font-weight-bold"
                                    >{{ item.description }}</v-card-title
                                >
                                <v-card-text class="subtitle-1">
                                    AREA DE TRABAJO:
                                    {{ item.work_area.description }}
                                </v-card-text>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:footer>
                <v-row class="mt-2" align="center" justify="center">
                    <span class="grey--text">Elementos por página</span>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                dark
                                text
                                color="primary"
                                class="ml-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                {{ itemsPerPage }}
                                <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item
                                v-for="(number, index) in itemsPerPageArray"
                                :key="index"
                                @click="updateItemsPerPage(number)"
                            >
                                <v-list-item-title>{{
                                    number
                                }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-spacer></v-spacer>

                    <span
                        class="mr-4
            grey--text"
                    >
                        Página {{ page }} de {{ numberOfPages }}
                    </span>
                    <v-btn
                        fab
                        dark
                        color="blue darken-3"
                        class="mr-1"
                        @click="formerPage"
                    >
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn
                        fab
                        dark
                        color="blue darken-3"
                        class="ml-1"
                        @click="nextPage"
                    >
                        <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
    <!-- <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover">
                        <tbody>
                            <tr v-for="analyte in activeAnalytes" :key="analyte.id">
                                <td class="mailbox-star" style="min-width: 100px;">
                                    <span class="text-secondary">
                                        {{ analyte.loinc.loinc_num }}</span
                                    >
                                </td>
                                <td class="mailbox-name">
                                    <a :href="'/search/advanced/'+ analyte.id"> {{ analyte.description }}</a>
                                </td>
                                <td class="mailbox-subject" style="max-width: 180px;">
                                    <b>Area de trabajo: </b>
                                    {{ analyte.work_area.description }}
                                </td>
                                <td class="mailbox-date">
                                    {{ analyte.available.description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
</template>

<script>
export default {
    props: ['analytes', 'propsSearch'],
    data() {
        return {
            itemsPerPageArray: [4, 8, 12],
            search: '',
            filter: {},
            sortDesc: false,
            page: 1,
            itemsPerPage: 12,
            sortBy: 'id',
            keys: ['id']
        }
    },
    created() {
        console.log(this.analytes)
    },

    computed: {
        activeAnalytes() {
            return this.analytes.filter(analyte => {
                return analyte.is_checked === 1
            })
        },
        numberOfPages() {
            return Math.ceil(this.analytes.length / this.itemsPerPage)
        },
        filteredKeys() {
            return this.keys.filter(key => key !== `Name`)
        }
    },
    methods: {
        advancedSearch(item) {
            window.location.href = `/search/advanced/${item.id}`
        },
        nextPage() {
            if (this.page + 1 <= this.numberOfPages) this.page += 1
        },
        formerPage() {
            if (this.page - 1 >= 1) this.page -= 1
        },
        updateItemsPerPage(number) {
            this.itemsPerPage = number
        }
    }
}
</script>

<style scoped></style>
