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
        <v-card class="mt-6" v-if="informationCovid !== null">
            <v-card-text>
                <h1 class="text-center">Casos en Chile COVID-19</h1>
                <p class="text-center">
                    <i
                        >(<span class="text-bold">Actualizado:</span>
                        {{ castDate
                        }}<span class="text-bold"> Fuente: </span>
                        NovelCOVID)</i
                    >
                </p>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-warning text-center">
                            <div class="info-box-content">
                                <span class="info-box-text h3"
                                    >Casos Totales</span
                                >
                                <span class="info-box-number h3">
                                    {{ informationCovid.cases }}
                                </span>
                                <small>&nbsp;</small>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-danger text-center">
                            <div class="info-box-content">
                                <span class="info-box-text h3"
                                    >Pacientes fallecidos</span
                                >
                                <span class="info-box-number h3">
                                    {{ informationCovid.deaths }}
                                </span>
                                <small>&nbsp;</small>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-success text-center">
                            <div class="info-box-content">
                                <span class="info-box-text h4"
                                    >Pacientes recuperados</span
                                >
                                <span class="info-box-number h2">
                                    {{ informationCovid.recovered }}
                                </span>
                                <small>&nbsp;</small>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-info">
                            <div class="info-box-content text-center">
                                <span class="info-box-text h3"
                                    >Casos / Fallecidos
                                </span>
                                <span class="info-box-number h2">
                                    {{ informationCovid.casesPerOneMillion }}
                                    /
                                    {{ informationCovid.deathsPerOneMillion }}
                                </span>
                                <small>(por millón)</small>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </main>
</template>

<script>
export default {
    name: 'index',
    data() {
        return {
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
                'PREANALITICA Y SEROLOGIA',
                'MICROBIOLOGIA',
                'DIAGNOSTICO MOLECULAR',
                'TUBERCULOSIS'
            ],
            informationCovid: null
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
        this.fetchApiCovid()
        this.fetchApiCovidiIterval()
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
