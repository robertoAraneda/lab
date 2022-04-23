<template>
    <main class="py-4">
        <div class="text-center">
            <h1 class="display-4 text-bold text-black">
                SIEL
            </h1>
            <h3 class="display-2 text-bold text-black">
                Sistema de Información de Exámenes de Laboratorio
            </h3>
            <p class="lead">
                Subdepartamento Laboratorio Clínico - Hospital Dr. Hernán
                Henríquez Aravena
            </p>
        </div>
        <div class="jumbotron"></div>
        <v-card>
            <v-card-title>Catálogo de exámenes:</v-card-title>
            <v-card-text>
                <div class="row justify-content-md-center">
                    <div class="input-group input-group-md col-sm-10">
                        <input
                            class="form-control"
                            type="text"
                            placeholder="Buscar examen"
                            aria-label="Search"
                            v-model="search_word"
                        />
                        <div class="input-group-append">
                            <button
                                @click.prevent="findByWord"
                                class="btn btn-navbar"
                                type="submit"
                            >
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-md-center">
                    <div class="mt-2 col-sm-10">
                        <button
                            v-for="letter in searchCatalogLetter"
                            :key="letter"
                            class="letter btn btn-secondary"
                            @click.prevent="findByLetter(letter)"
                        >
                            {{ letter }}
                        </button>
                    </div>
                </div>
            </v-card-text>
        </v-card>
        <v-card class="mt-6">
            <v-card-title>Secciones:</v-card-title>
            <v-card-text class="row justify-content-md-center">
                <button
                    @click.prevent="findBySection(section)"
                    v-for="section in filteredSections"
                    :key="section"
                    class="btn btn-success text-white mr-2 mt-1"
                >
                    {{ section }}
                </button>
            </v-card-text>
        </v-card>
        <v-card class="mt-6" @click="codesLab">
            <div class="d-flex flex-no-wrap justify-space-between">
                <v-avatar
                    color="red lighten-1"
                    class="ma-3"
                    size="60"
                    tile
                    rounded
                >
                    <v-icon dark size="80">mdi-alpha-c</v-icon>
                </v-avatar>
                <div>
                    <v-card-text class="headline">
                        Listado de exámenes y códigos de ingreso para solicitud
                        de medios</v-card-text
                    >
                </div>
            </div>
        </v-card>
        <v-footer padless class="mt-6" color="primary lighten-1">
            <v-card flat tile class="primary lighten-1 white--text text-center">
                <v-card-text>
                    <v-btn
                        v-for="icon in icons"
                        :key="icon.id"
                        class="mx-4 white--text"
                        icon
                        :href="icon.href"
                        target="_blank"
                    >
                        <v-icon size="24px">
                            {{ icon.icon }}
                        </v-icon>
                    </v-btn>
                </v-card-text>
                <v-card color="primary" tile flat elevation="0" width="1280">
                    <v-tabs
                        v-model="tab"
                        centered
                        background-color="primary"
                        dark
                    >
                        <v-tab href="#tab-1">
                            Creado por
                        </v-tab>
                        <v-tab href="#tab-2">
                            Desarrollado por
                        </v-tab>
                        <v-tab href="#tab-3">
                            Colaboradores
                        </v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
                        <v-tab-item value="tab-1">
                            <v-card
                                flat
                                tile
                                elevation="0"
                                class="white--text"
                                color="primary lighten-1"
                            >
                                <v-card-text class="white--text">
                                    <p>TM. Andrés San Martín Rivera</p>
                                    <p>
                                        Este sistema fue creado el año 2016 en
                                        la ciudad de Temuco, siendo
                                        posteriormente desarrollado en este
                                        aplicativo para su publicación el año
                                        2021. La información contenida fue
                                        producida por distintos profesionales
                                        del laboratorio clínico del Hospital Dr.
                                        Hernán Henríquez Aravena de Temuco.
                                    </p>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item value="tab-2">
                            <v-card
                                flat
                                tile
                                elevation="0"
                                color="primary lighten-1"
                            >
                                <v-card-text class="white--text">
                                    <p>TM. Roberto Araneda Espinoza</p>
                                    <p>
                                        Creación, desarrollo e implementación de
                                        estructura en base a estandar
                                        <a
                                            class="white--text text-decoration-underline"
                                            href="https://loinc.org/"
                                            >LOINC.</a
                                        >
                                    </p>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item value="tab-3">
                            <v-card
                                flat
                                tile
                                elevation="0"
                                color="primary lighten-1"
                            >
                                <v-card-text class="white--text">
                                    <p>
                                        Creación, desarrollo e implementación de
                                        toda la información contenida en SIEL,
                                        para cada uno de los exámenes y pruebas
                                        que conforman la canasta del
                                        laboratorio.
                                    </p>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <p>BQ. Felipe Collao</p>
                                            <p>BQ. Marcela González</p>
                                            <p>QF. Jaime Inostroza</p>
                                            <p>TM. Camila Mendez</p>
                                            <p>TM. Camila Toloza</p>
                                            <p>TM. Claudia Anoni</p>
                                            <p>TM. Claudia Cifuentes</p>
                                            <p>TM. Claudio Rodríguez</p>
                                            <p>TM. Francisco Quiñones</p>
                                            <p>TM. Hugo Delgado</p>
                                            <p>TM. Irma Rapiman</p>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <p>TM. Iván Araya</p>
                                            <p>TM. Javier Sanzana</p>
                                            <p>TM. Jorge Jara</p>
                                            <p>TM. Judith Muñoz</p>
                                            <p>TM. Patricia Jara</p>
                                            <p>TM. Patricia Reydet</p>
                                            <p>TM. Paulina Cartes</p>
                                            <p>TM. Vitalia Bahamondes</p>
                                            <p>TM. Yoselyn Olmazabal</p>
                                            <p>TM. Yvo Matamala</p>
                                            <p>
                                                Y otros profesionales del
                                                laboratorio Clínico del Hospital
                                                Dr. Hernán Henríquez Aravena de
                                                Temuco
                                            </p>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>

                <v-divider></v-divider>

                <v-card-text class="white--text">
                    <p class="text-h6">2016 - {{ new Date().getFullYear() }}</p>
                    <p>
                        <strong
                            >Aplicación web desarrollada por TM. Roberto Araneda
                            Espinoza</strong
                        >
                    </p>
                </v-card-text>
            </v-card>
        </v-footer>
    </main>
</template>

<script>
export default {
    name: 'index',
    data() {
        return {
            tab: null,
            searchCatalogLetter: [
                'A',
                'B',
                'C',
                'D',
                'E',
                'F',
                'G',
                'H',
                'I',
                'J',
                'K',
                'L',
                'M',
                'N',
                'O',
                'P',
                'Q',
                'R',
                'S',
                'T',
                'U',
                'V',
                'W',
                'X',
                'Y',
                'Z'
            ],
            search_word: '',
            workareas: [
                'HEMOSTASIA',
                'HEMATOLOGIA',
                'QUIMICA CLINICA',
                'VIROLOGIA',
                'INMUNOQUIMICA',
                'INMUNOLOGIA',
                'CITOMETRIA DE FLUJO',
                'SEROLOGIA',
                'PREANALITICA',
                'PARASITOLOGIA',
                'UROANALISIS',
                'CITOGENETICA',
                'BIOLOGIA MOLECULAR',
                'TUBERCULOSIS',
                'HEMOCULTIVO',
                'UROCULTIVO',
                'CULTIVO CORRIENTE',
                'QUIMICA ORINAS'
            ],
            sections: [
                'HEMATOLOGIA Y HEMOSTASIA',
                'BIOQUIMICA',
                'INMUNOLOGIA Y CITOMETRIA DE FLUJO',
                'PREANALITICA Y TOMA DE MUESTRAS',
                'MICROBIOLOGIA',
                'DIAGNOSTICO MOLECULAR',
                'TUBERCULOSIS'
            ],
            informationCovid: null,
            icons: [
                {
                    id: 1,
                    icon: 'mdi-facebook',
                    href:
                        'https://www.facebook.com/Laboratorio-Cl%C3%ADnico-Hospital-Dr-Hern%C3%A1n-Henr%C3%ADquez-Aravena-de-Temuco-1153132284851554'
                },
                {
                    id: 2,
                    icon: 'mdi-instagram',
                    href: 'https://www.instagram.com/laboratoriohhha/'
                }
            ]
        }
    },
    computed: {
        filteredWorkareas() {
            return this.workareas.sort()
        },
        filteredSections() {
            return this.sections.sort()
        },
        castDate() {
            const date = new Date(this.informationCovid.updated)
            let hour =
                date.getHours() <= 10
                    ? `0${date.getHours()}`
                    : `${date.getHours()}`
            let minute =
                date.getMinutes() <= 10
                    ? `0${date.getMinutes()}`
                    : `${date.getMinutes()}`

            return `Fecha: ${date.getDate()}/${date.getMonth() +
                1}/${date.getFullYear()} Hora: ${hour}:${minute}`
        }
    },
    created() {
        //this.fetchApiCovid()
        // this.fetchApiCovidiIterval()
    },
    methods: {
        codesLab() {
            window.location.href = `/codigos-laboratorio`
        },
        findByWord() {
            window.location.href = `/search-word/${this.search_word}`
        },
        findByLetter(letter) {
            window.location.href = `/search-letter/${letter}`
        },
        findByWorkarea(workarea) {
            window.location.href = `/search-workarea/${workarea}`
        },
        findBySection(section) {
            window.location.href = `/search-section/${section}`
        },
        async fetchApiCovid() {
            const response = await axios.get(
                'https://corona.lmao.ninja/v2/countries/Chile'
            )

            const json = response.data

            console.log(json)
            this.informationCovid = json
        },
        fetchApiCovidiIterval() {
            window.setInterval(async () => {
                const response = await axios.get(
                    'https://corona.lmao.ninja/v2/countries/Chile'
                )

                const json = response.data

                console.log(json)
                this.informationCovid = json
            }, 600000)
        }
    }
}
</script>

<style scoped>
.letter {
    width: 40px;
    height: 40px;
    margin: 2px;
}

.jumbotron {
    background-image: url('../../../../public/dist/img/lab-id-solutions-supplies-banner.jpg');
    background-size: cover;
    opacity: 0.8;
}
</style>
