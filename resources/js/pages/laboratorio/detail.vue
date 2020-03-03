<template>
    <div class="d-flex justify-content-center">
        <div class="invoice scrollspy-custom col-md-12 mt-2">
            <div class="card card-secondary text-center bg-secondary elevation-2 mt-2">
                <h4>{{ analyte.description }}</h4>
            </div>
            <nav id="navbar-example2" class="navbar navbar-light bg-light elevation-1 mb-2">
                <button class="navbar-brand" @click="downloadPDF">PDF</button>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="#clinic">CLÍNICA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sample">TOMA DE MUESTRA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#laboratory">LABORATORIO</a>
                    </li>
                </ul>
            </nav>
            <div
                data-spy="scroll"
                data-target="#navbar-example2"
                data-offset="50"
                class="spy-over"
                id="content"
            >
                <h4 id="clinic">
                    <i class="fas fa-stethoscope text-info ml-3"></i><span
                    class="text-info ml-3">INFORMACIÓN CLÍNICA</span>
                    <small class="float-right badge badge-success p-2 mr-4">EXAMEN {{
                        available.description
                        }}</small>
                </h4>
                <div class="m-3">
                    <p class="lead m-3 text-lg" align="justify"> {{ analyte_.observation
                        }}</p>
                    <div class="row text-center m-1">
                        <div class="col-md-4 card">
                            <h5>
                                <dt>Procesamiento</dt>
                                <dd> {{ time_process.description }}</dd>
                            </h5>
                        </div>
                        <div class="col-md-4 card">
                            <h5>
                                <dt>Recepción</dt>
                                <dd> {{ time_reception.description }}</dd>
                            </h5>
                        </div>
                        <div class="col-md-4 card">
                            <h5>
                                <dt>Tiempo respuesta</dt>
                                <dd> {{ time_response.description }}</dd>
                            </h5>
                        </div>
                    </div>
                    <div class="callout callout-info table-responsive mt-0">
                        <h5>Valores de referencia</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Prueba</th>
                                <th>Genero</th>
                                <th>Edad</th>
                                <th>Rango normal</th>
                                <th>Rango crítico</th>
                                <th>Rango cualitativo</th>
                                <th>Valor</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="test in tests" :key="test.id">
                                <td>{{ test.description }}</td>
                                <td>{{ test.reference_range.gender.description }}</td>
                                <td> {{ test.reference_range.age_start }} a
                                    {{ test.reference_range.age_end }}
                                    {{ test.reference_range.age_unit.description }}
                                </td>
                                <td v-if="test.reference_range.type_value === 'CUANTITATIVO'" class="text-success text-md text-bold">{{ test.reference_range.normal_minimum }} -
                                    {{ test.reference_range.normal_maximum }}
                                    {{ test.unit.description }}
                                </td>
                                <td v-else> - </td>
                                <td v-if="test.reference_range.type_value === 'CUANTITATIVO'" class="text-danger text-md text-bold">{{ test.reference_range.critical_minimum }} -
                                    {{ test.reference_range.critical_maximum }}
                                    {{ test.unit.description }}
                                </td>
                                <td v-else> - </td>
                                <td v-if="test.reference_range.type_value === 'CUANTITATIVO'"> - </td>
                                <td v-else>{{ test.reference_range.cualitative_value }}</td>
                                <td>{{ test.reference_range.type_value }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h4 id="sample">
                    <i class="fas fa-syringe text-info ml-3"></i><span
                    class="text-info ml-3">INFORMACIÓN TOMA DE MUESTRA</span>
                </h4>
                <div class="m-3">
                    <div class="row m-1 d-flex justify-content-around">
                        <div class="col-md-6 card">
                            <div class="row text-lg lead pt-2 pl-3">
                                <dt>Tipo muestra:</dt>
                                <dd class="ml-2"> {{ sample.description }}</dd>
                            </div>

                        </div>
                        <div class="col-md-6 card">
                            <div class="row text-lg lead pt-2 pl-3">
                                <dt>Obtención:</dt>
                                <dd class="ml-2">{{ collection_method.description }}</dd>
                            </div>
                        </div>
                    </div>
                    <div class="row m-1 d-flex justify-content-around">
                        <div class="col-md-12 card">
                            <h5>Indicaciones</h5>
                            <ul class="note-icon-orderedlist">
                                <li class="lead" v-for="indication in indications" :key="indication.id"> {{
                                    indication.description }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12 card">
                            <h5>Solicitud médica</h5>
                            <ul class="note-icon-orderedlist">
                                <li class="lead">{{ medical_order.description }}</li>
                            </ul>

                        </div>
                    </div>

                    <h5 class="ml-2">CONTENEDOR</h5>
                    <div class="info-box">
                        <span style="min-width: 100px;" class="info-box-icon"><i
                            class="fas fa-square fa-lg text-yellow"></i> <i
                            class="fas fa-square fa-lg text-red"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number text-lg"> {{ container.description }}</span>
                            <span class="info-box-text text-lg"><span
                                class="lead mr-3">{{ container.abbreviation}}</span></span>
                        </div>
                    </div>
                </div>
                <h4 id="laboratory">
                    <i class="fas fa-microscope text-info"></i><span
                    class="text-info ml-3">INFORMACIÓN LABORATORIO</span>
                </h4>
                <div class="m-3">
                    <h5>LOINC</h5>
                    <div class="info-box">
                        <span style="min-width: 100px;" class="info-box-icon bg-gradient-info text-lg"> {{ loinc.loinc_num }}</span>
                        <div class="info-box-content">
                            <span class="info-box-number text-lg">{{ loinc.long_common_name }}</span>
                            <span class="info-box-text text-lg"> <span
                                class="lead mr-3">{{ loinc.system_ }}</span></span>
                        </div>
                    </div>
                    <h5>FONASA</h5>
                    <div class="info-box">
                        <span style="min-width: 100px;" class="info-box-icon bg-gradient-info text-lg"> {{ fonasa_test.code }}</span>
                        <div class="info-box-content">
                            <span class="info-box-number text-lg">{{ fonasa_test.description }}</span>
                        </div>
                    </div>
                    <h5>INGRESO A SISTEMA INFORMÁTICO</h5>
                    <div class="col-md-12">
                        <div class="info-box">
                            <span style="min-width: 100px;" class="info-box-icon bg-gradient-success text-lg"> {{ loinc.loinc_num }}</span>
                            <div class="info-box-content">
                                <span class="info-box-number text-lg"> {{ analyte.description }}</span>
                                <span class="info-box-text text-lg"><span
                                    class="lead mr-3">Sistema OA (SME HHHA) </span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span style="min-width: 100px;" class="info-box-icon bg-gradient-info text-lg"> {{ hca.internal_code }}</span>
                                <div class="info-box-content">
                                    <span class="info-box-number text-lg"> {{ hca.description }}</span>
                                    <span class="info-box-text text-lg"><span
                                        class="lead mr-3">Sistema Infinity </span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span style="min-width: 100px;" class="info-box-icon bg-gradient-info text-lg"> {{ lis.code }}</span>
                                <div class="info-box-content">
                                    <span class="info-box-number text-lg"> {{ lis.description }}</span>
                                    <span class="info-box-text text-lg"><span
                                        class="lead mr-3">Sistema LabDate </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5>PRUEBAS ASOCIADAS</h5>
                    <div v-for="test in tests" :key="test.id" class="callout callout-info">
                        <h5>Nombre: <span class="lead">{{ test.description }}</span></h5>
                        <h5>Prueba LIS asociada: <span class="lead">{{ test.infinity_test.description }}</span></h5>
                        <h5>LOINC: <span class="lead">{{ test.loinc.long_common_name }}</span></h5>
                        <h5>Método: <span class="lead">{{ test.method.description }}</span></h5>
                        <h5>Unidades: <span class="lead">{{ test.unit.description }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import jsPDF from 'jspdf';
    import html2canvas from 'html2canvas';

    export default {

        props: ["analyte"],
        data() {
            return {
                tests: this.analyte.tests,
                analyte_: this.analyte,
                loinc: this.analyte.loinc,
                main_analyte: this.analyte.analyteSampleContainer.main_analyte,
                sample: this.analyte.analyteSampleContainer.sample_collection_method.sample,
                collection_method: this.analyte.analyteSampleContainer.sample_collection_method.collection_method,
                container: this.analyte.analyteSampleContainer.container,
                labels: this.analyte.labels,
                indications: this.analyte.indications,
                hca: this.analyte.hca_laboratory,
                lis: this.analyte.infinity_labdate_test,
                available: this.analyte.available,
                vih_key: this.analyte.vih_key,
                time_process: this.analyte.time_process,
                time_reception: this.analyte.time_reception,
                time_response: this.analyte.time_response,
                medical_order: this.analyte.medical_order,
                fonasa_test: this.analyte.fonasa_test,
                work_area: this.analyte.work_area,
                section: this.analyte.work_area.section,
                state: this.analyte.state
            }
        },
        methods: {
            downloadPDF() {
                const doc = new jsPDF();

                doc.html(document.getElementById('content'), {
                    callback: function (pdf) {
                        var iframe = document.createElement('iframe');
                        iframe.setAttribute('style', 'position:absolute;right:0; top:0; bottom:0; height:100%; width:500px');
                        document.body.appendChild(iframe);
                        iframe.src = pdf.output('datauristring');
                    }
                });
                doc.save("sample.pdf");
            },
            createPDF() {
                const doc = new jsPDF();

                doc.setTextColor(100);
                doc.text(20, 20, this.analyte_.description);

                doc.setTextColor(80);
                doc.text(20, 30, 'INFORMACIÓN CLÍNICA');
                doc.text(20, 40, this.main_analyte.information)

                return doc;
            }
        }
    };
</script>

<style scoped>
    .scrollspy-custom {
        position: relative;
    }

    .spy-over {
        position: relative;
        height: 500px;
        overflow: auto;
    }
</style>
