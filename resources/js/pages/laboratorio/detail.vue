<template>
    <div class="d-flex justify-content-center">
        <div class="scrollspy-custom col-md-8">
            <nav id="navbar-example2" class="navbar navbar-light bg-light mt-2">
                <a class="navbar-brand" href="#"> {{ analyte.description }}</a>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="#laboratorio">LABORATORIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#loinc">LOINC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lis">LIS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#clinica">CLINICA</a>
                    </li>
                </ul>
            </nav>
            <div
                data-spy="scroll"
                data-target="#navbar-example2"
                data-offset="0"
                class="spy-over"
            >
               <h4 id="laboratorio">LABORATORIO</h4>
                <dt>Nombre examen</dt>
                <dd> {{ analyte.description }} </dd>
                <dt>Area de trabajo</dt>
                <dd>{{ analyte.work_area.description }}</dd>
                <dt>Contenedor</dt>
                <dd>{{ analyte.analyteSampleContainer.container.description }}</dd>
                <dt>Tipo de muestra</dt>
                <dd>{{ analyte.analyteSampleContainer.sample_collection_method.sample.description }}</dd>
                <dt>Obtención</dt>
                <dd>{{ analyte.analyteSampleContainer.sample_collection_method.collection_method.description }}</dd>
                <h4 id="loinc">LOINC</h4>
                <dt>Código</dt>
                <dd>{{ analyte.loinc.loinc_num }}</dd>
                <dt>Nombre</dt>
                <dd>{{ analyte.loinc.long_common_name }}</dd>
                <dt>Tipo muestra</dt>
                <dd>{{ analyte.loinc.system_ }}</dd>
                <dt>Método</dt>
                <dd>{{ analyte.loinc.method_typ }}</dd>

                <h4 id="lis">LIS</h4>
                <dt>Código solicitud médica electrónica</dt>
                <dd>{{ analyte.loinc.loinc_num }}</dd>
                <dt>Código ingreso LabDate</dt>
                <dd>{{ analyte.infinity_labdate_test.code }}</dd>
                <dt>Nombre LabDate</dt>
                <dd>{{ analyte.infinity_labdate_test.description }}</dd>
             
                <h4 id="clinica">CLINICA</h4>
                <p>...</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["analyte"]
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
