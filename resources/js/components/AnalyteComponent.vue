<template>
    <div>
        <div v-if="!contentReady">
            <div
                v-if="!collections.timeReceptions.length"
                class="d-flex justify-content-center"
            >
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div v-else>
            <div
                v-if="formContent"
                class="card card-secondary card-outline card-tabs"
            >
                <div class="bg-secondary">
                    <h5 class="text-center m-2 lead">
                        <span class="lead"> {{ analyte.description }}</span>
                    </h5>
                </div>
                <div class="card-header p-0 pt-1">
                    <ul
                        class="nav nav-tabs nav-fill"
                        id="custom-tabs-one-tab"
                        role="tablist"
                    >
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount === 0,
                                    active: formCount === 0,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 2 ||
                                        formCount === 3 ||
                                        formCount === 4
                                }"
                                class="nav-link"
                                id="custom-tabs-one-loinc-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-loinc"
                                role="tab"
                                aria-controls="custom-tabs-one-loinc"
                                :aria-selected="formCount === 0"
                                ><span
                                    >DATOS LOINC
                                    <!--                                    <i-->
                                    <!--                                        class="fas fa-check text-success fa-lg"-->
                                    <!--                                    ></i>-->
                                </span></a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount === 1,
                                    active: formCount === 1,
                                    disabled:
                                        formCount === 0 ||
                                        formCount === 2 ||
                                        formCount === 3 ||
                                        formCount === 4
                                }"
                                class="nav-link"
                                id="custom-tabs-one-general-1-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-general-1"
                                role="tab"
                                aria-controls="custom-tabs-one-general-1"
                                :aria-selected="formCount === 1"
                                >DATOS GENERALES</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount === 2,
                                    active: formCount === 2,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 0 ||
                                        formCount === 3 ||
                                        formCount === 4
                                }"
                                class="nav-link"
                                id="custom-tabs-one-lis-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-lis"
                                role="tab"
                                aria-controls="custom-tabs-one-lis"
                                :aria-selected="formCount === 2"
                                >TOMA DE MUESTRA</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount === 3,
                                    active: formCount === 3,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 0 ||
                                        formCount === 2 ||
                                        formCount === 4
                                }"
                                class="nav-link"
                                id="custom-tabs-one-lis-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-lis"
                                role="tab"
                                aria-controls="custom-tabs-one-lis"
                                :aria-selected="formCount === 3"
                                >TIEMPOS</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    ['bg-secondary']: formCount === 4,
                                    active: formCount === 4,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 2 ||
                                        formCount === 0 ||
                                        formCount === 3
                                }"
                                class="nav-link"
                                id="custom-tabs-one-test-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-test"
                                role="tab"
                                aria-controls="custom-tabs-one-test"
                                :aria-selected="formCount === 4"
                                >DATOS LIS</a
                            >
                        </li>
                    </ul>
                </div>
                <div v-if="dmlOperation" class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
                <div class="card-body">
                    <form>
                        <div
                            class="tab-content"
                            id="custom-tabs-one-tabContent"
                        >
                            <input
                                type="hidden"
                                v-model="idAnalyteSampleContainer"
                            />
                            <div
                                :class="
                                    formCount === 0 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-loinc"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-loinc-tab"
                            >
                                <div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>CÓDIGO:</label>
                                                <input
                                                    v-model="loinc_code"
                                                    @keypress.enter.prevent="
                                                        search_loinc
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Ingrese código"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <input
                                                type="hidden"
                                                v-model="analyte.loinc.id"
                                            />
                                            <input
                                                type="hidden"
                                                v-model="analyte.loinc.code"
                                            />
                                            <div class="form-group">
                                                <label>NOMBRE: </label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        analyte.loinc
                                                            .description
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>TIPO DE MUESTRA:</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        analyte.loinc.sample
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <div class="row">
                                            <button
                                                @click.prevent="cancelCreate"
                                                class="btn btn-danger mr-1"
                                            >
                                                <i class="fas fa-times"></i>
                                                Cancelar
                                            </button>
                                            <button
                                                class="btn btn-default"
                                                @click.prevent="nextTab"
                                            >
                                                Continuar
                                                <i
                                                    class="fas fa-angle-right"
                                                ></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                :class="
                                    formCount === 1 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-general-1"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-general-1-tab"
                            >
                                <div>
                                    <div
                                        v-if="!collections.containers.length"
                                        class="d-flex justify-content-center"
                                    >
                                        <div
                                            class="spinner-border"
                                            role="status"
                                        >
                                            <span class="sr-only"
                                                >Loading...</span
                                            >
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div
                                                class="col-sm-12 col-12 col-md-12"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        for="description"
                                                        v-if="
                                                            analyte.description !==
                                                                ''
                                                        "
                                                        >DESCRIPCIÓN:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <input
                                                        id="description"
                                                        v-model="
                                                            analyte.description
                                                        "
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="NOMBRE"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="observation"
                                                        v-if="
                                                            analyte.observation !==
                                                                ''
                                                        "
                                                        >INFORMACIÓN GENERAL:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <textarea
                                                        id="observation"
                                                        v-model="
                                                            analyte.observation
                                                        "
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="INFORMACIÓN GENERAL SOBRE LA UTILIDAD CLÍNICA DEL EXAMEN..."
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.mainAnalyte
                                                                .id !== 0
                                                        "
                                                        >PRESTACIÓN
                                                        PRINCIPAL:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="PRESTACIÓN PRINCIPAL: "
                                                        :options="
                                                            collections.mainAnalytes
                                                        "
                                                        v-model="
                                                            analyte.mainAnalyte
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.medicalOrder
                                                                .id !== 0
                                                        "
                                                        >SOLICITUD MÉDICA</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="SOLICITUD MÉDICA: "
                                                        :options="
                                                            collections.medicalOrders
                                                        "
                                                        v-model="
                                                            analyte.medicalOrder
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.fonasaTest
                                                                .id !== 0
                                                        "
                                                        >CÓDIGO FONASA:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="CÓDIGO FONASA: "
                                                        :options="
                                                            collections.fonasaTests
                                                        "
                                                        v-model="
                                                            analyte.fonasaTest
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.workArea
                                                                .id !== 0
                                                        "
                                                        >AREA DE TRABAJO:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="AREA DE TRABAJO: "
                                                        :options="
                                                            collections.workAreas
                                                        "
                                                        v-model="
                                                            analyte.workArea.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.vihKey
                                                                .id !== 0
                                                        "
                                                        >CLAVE VIH:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="CLAVE VIH: "
                                                        :options="
                                                            collections.vihKeys
                                                        "
                                                        v-model="
                                                            analyte.vihKey.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>

                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.available
                                                                .id !== 0
                                                        "
                                                        >DISPONIBILIDAD:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 1"
                                                        name="DISPONIBILIDAD: "
                                                        :options="
                                                            collections.availables
                                                        "
                                                        v-model="
                                                            analyte.available.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <div class="row">
                                                <button
                                                    @click.prevent="
                                                        cancelCreate
                                                    "
                                                    class="btn btn-danger mr-1"
                                                >
                                                    <i class="fas fa-times"></i>
                                                    Cancelar
                                                </button>
                                                <button
                                                    class="btn btn-default mr-1"
                                                    @click.prevent="backTab"
                                                >
                                                    <i
                                                        class="fas fa-angle-left"
                                                    ></i>
                                                    Atrás
                                                </button>
                                                <button
                                                    class="btn btn-default"
                                                    @click.prevent="nextTab"
                                                >
                                                    Continuar
                                                    <i
                                                        class="fas fa-angle-right"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                :class="
                                    formCount === 2 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-lis"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-lis-tab"
                            >
                                <div>
                                    <div
                                        v-if="!collections.fonasaTests.length"
                                        class="d-flex justify-content-center"
                                    >
                                        <div
                                            class="spinner-border"
                                            role="status"
                                        >
                                            <span class="sr-only"
                                                >Loading...</span
                                            >
                                        </div>
                                    </div>
                                    <div v-else>
                                        <h4 class="ml-1 text-secondary">
                                            Condiciones toma de muestra:
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="card card-secondary"
                                                >
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            Condicion:
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div
                                                            class="input-group"
                                                        >
                                                            <input
                                                                v-model="
                                                                    search_condition
                                                                "
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Buscar"
                                                            />
                                                            <div
                                                                class="input-group-append"
                                                            >
                                                                <span
                                                                    class="input-group-text"
                                                                    ><i
                                                                        class="fas fa-search"
                                                                    ></i
                                                                ></span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="list-group list-group-flush overflow-auto"
                                                        >
                                                            <button
                                                                @dblclick.prevent="
                                                                    addSelectedSampleCondition(
                                                                        sampleCondition
                                                                    )
                                                                "
                                                                v-for="sampleCondition in filteredListSampleCondition"
                                                                :key="
                                                                    sampleCondition.id
                                                                "
                                                                type="button"
                                                                class="list-group-item list-group-item-action"
                                                            >
                                                                {{
                                                                    sampleCondition.description
                                                                }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="card card-secondary"
                                                >
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            Condiciones muestra
                                                            seleccionadas:
                                                        </h5>
                                                        <h5>
                                                            <span
                                                                class="badge badge-info float-right"
                                                                >{{
                                                                    selectedSampleConditions.length
                                                                }}</span
                                                            >
                                                        </h5>
                                                    </div>
                                                    <div
                                                        class="card-body overflow-auto"
                                                        style="max-height: 300px;"
                                                    >
                                                        <div class="row">
                                                            <div
                                                                v-for="selectedSampleCondition in selectedSampleConditions"
                                                                :key="
                                                                    selectedSampleCondition.id
                                                                "
                                                                class="col-md-12 col-sm-12 col-12"
                                                            >
                                                                <div
                                                                    class="info-box"
                                                                >
                                                                    <div
                                                                        class="info-box-content overflow-hidden"
                                                                    >
                                                                        <span
                                                                            class="info-box-text"
                                                                            >{{
                                                                                selectedSampleCondition.description
                                                                            }}</span
                                                                        >
                                                                    </div>
                                                                    <button
                                                                        @click.prevent="
                                                                            removeSelectedSampleCondition(
                                                                                selectedSampleCondition
                                                                            )
                                                                        "
                                                                        class=" btn btn-info info-box-icon"
                                                                    >
                                                                        <i
                                                                            class="fas fa-times"
                                                                        ></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-3 col-12 col-md-3"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.sample
                                                                .id !== 0
                                                        "
                                                        >TIPO MUESTRA:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 2"
                                                        name="TIPO MUESTRA: "
                                                        :options="
                                                            collections.samples
                                                        "
                                                        v-model="
                                                            analyte.sample.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-3 col-12 col-md-3"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .collectionMethod
                                                                .id !== 0
                                                        "
                                                        >OBTENCIÓN:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 2"
                                                        name="OBTENCIÓN: "
                                                        :options="
                                                            collections.collectionMethods
                                                        "
                                                        v-model="
                                                            analyte
                                                                .collectionMethod
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-6 col-12 col-md-6"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.container
                                                                .id !== 0
                                                        "
                                                        >CONTENEDOR:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 2"
                                                        name="CONTENEDOR: "
                                                        :options="
                                                            collections.containers
                                                        "
                                                        v-model="
                                                            analyte.container.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-sm-3 col-12 col-md-3"
                                                >
                                                    <div class="form-group">
                                                        <label
                                                            v-if="
                                                                analyte
                                                                    .quantitySampleAdult
                                                                    .id !== 0
                                                            "
                                                            >VOLUMEN MUESTRA
                                                            PEDIÁTRICO:</label
                                                        >
                                                        <label v-else
                                                            >&nbsp;</label
                                                        >
                                                        <select2
                                                            v-if="
                                                                formCount === 2
                                                            "
                                                            name="VOLUMEN MUESTRA
                                                        PEDIÁTRICO:"
                                                            :options="
                                                                collections.quantitySamples
                                                            "
                                                            v-model="
                                                                analyte
                                                                    .quantitySampleAdult
                                                                    .id
                                                            "
                                                        ></select2>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-sm-3 col-12 col-md-3"
                                                >
                                                    <div class="form-group">
                                                        <label
                                                            v-if="
                                                                analyte
                                                                    .quantitySamplePediatric
                                                                    .id !== 0
                                                            "
                                                            >VOLUMEN MUESTRA
                                                            ADULTO:</label
                                                        >
                                                        <label v-else
                                                            >&nbsp;</label
                                                        >
                                                        <select2
                                                            v-if="
                                                                formCount === 2
                                                            "
                                                            name="VOLUMEN MUESTRA
                                                        ADULTO:"
                                                            :options="
                                                                collections.quantitySamples
                                                            "
                                                            v-model="
                                                                analyte
                                                                    .quantitySamplePediatric
                                                                    .id
                                                            "
                                                        ></select2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <div class="row">
                                                <button
                                                    @click.prevent="
                                                        cancelCreate
                                                    "
                                                    class="btn btn-danger mr-1"
                                                >
                                                    <i class="fas fa-times"></i>
                                                    Cancelar
                                                </button>

                                                <button
                                                    class="btn btn-default mr-1"
                                                    @click.prevent="backTab"
                                                >
                                                    <i
                                                        class="fas fa-angle-left"
                                                    ></i>
                                                    Atrás
                                                </button>
                                                <button
                                                    class="btn btn-default"
                                                    @click.prevent="nextTab"
                                                >
                                                    Siguiente
                                                    <i
                                                        class="fas fa-angle-right"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                :class="
                                    formCount === 3 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-lis"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-lis-tab"
                            >
                                <div>
                                    <div
                                        v-if="!collections.fonasaTests.length"
                                        class="d-flex justify-content-center"
                                    >
                                        <div
                                            class="spinner-border"
                                            role="status"
                                        >
                                            <span class="sr-only"
                                                >Loading...</span
                                            >
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .timeReception
                                                                .id !== 0
                                                        "
                                                        >TIEMPO DE
                                                        RECEPCIÓN:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO RECEPCIÓN: "
                                                        :options="
                                                            collections.timeReceptions
                                                        "
                                                        v-model="
                                                            analyte
                                                                .timeReception
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.timeProcess
                                                                .id !== 0
                                                        "
                                                        >TIEMPO PROCESO:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO PROCESO: "
                                                        :options="
                                                            collections.timeProcesses
                                                        "
                                                        v-model="
                                                            analyte.timeProcess
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .timeResponseUrg
                                                                .id !== 0
                                                        "
                                                        >TIEMPO DE RESPUESTA
                                                        URGENCIA:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO DE RESPUESTA URGENCIA: "
                                                        :options="
                                                            collections.timeResponses
                                                        "
                                                        v-model="
                                                            analyte
                                                                .timeResponseUrg
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .timeResponseAmb
                                                                .id !== 0
                                                        "
                                                        >TIEMPO DE RESPUESTA
                                                        AMBULATORIO:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO DE RESPUESTA AMBULATORIO: "
                                                        :options="
                                                            collections.timeResponses
                                                        "
                                                        v-model="
                                                            analyte
                                                                .timeResponseAmb
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .timeResponseHosp
                                                                .id !== 0
                                                        "
                                                        >TIEMPO DE RESPUESTA
                                                        HOSPITALIZADO:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO DE RESPUESTA HOSPITALIZADO: "
                                                        :options="
                                                            collections.timeResponses
                                                        "
                                                        v-model="
                                                            analyte
                                                                .timeResponseHosp
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .timeResponseExt
                                                                .id !== 0
                                                        "
                                                        >TIEMPO DE RESPUESTA
                                                        EXTERNO:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 3"
                                                        name="TIEMPO DE RESPUESTA EXTERNO: "
                                                        :options="
                                                            collections.timeResponses
                                                        "
                                                        v-model="
                                                            analyte
                                                                .timeResponseExt
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <div class="row">
                                                <button
                                                    @click.prevent="
                                                        cancelCreate
                                                    "
                                                    class="btn btn-danger mr-1"
                                                >
                                                    <i class="fas fa-times"></i>
                                                    Cancelar
                                                </button>

                                                <button
                                                    class="btn btn-default mr-1"
                                                    @click.prevent="backTab"
                                                >
                                                    <i
                                                        class="fas fa-angle-left"
                                                    ></i>
                                                    Atrás
                                                </button>
                                                <button
                                                    class="btn btn-default"
                                                    @click.prevent="nextTab"
                                                >
                                                    Siguiente
                                                    <i
                                                        class="fas fa-angle-right"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                :class="
                                    formCount === 4 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-test"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-test-tab"
                            >
                                <div>
                                    <div
                                        v-if="
                                            !collections.hcaLaboratories.length
                                        "
                                        class="d-flex justify-content-center"
                                    >
                                        <div
                                            class="spinner-border"
                                            role="status"
                                        >
                                            <span class="sr-only"
                                                >Loading...</span
                                            >
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div
                                                class="col-sm-5 col-md-5 col-12"
                                            >
                                                <div class="card card-default">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            Etiquetas:
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div
                                                            class="input-group"
                                                        >
                                                            <input
                                                                v-model="
                                                                    search_label
                                                                "
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Buscar"
                                                            />
                                                            <div
                                                                class="input-group-append"
                                                            >
                                                                <span
                                                                    class="input-group-text"
                                                                    ><i
                                                                        class="fas fa-search"
                                                                    ></i
                                                                ></span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="list-group list-group-flush overflow-auto"
                                                        >
                                                            <button
                                                                @dblclick.prevent="
                                                                    addSelectedLabel(
                                                                        label
                                                                    )
                                                                "
                                                                v-for="label in filteredList"
                                                                :key="label.id"
                                                                type="button"
                                                                class="list-group-item list-group-item-action"
                                                            >
                                                                {{
                                                                    label.description
                                                                }}
                                                                ({{
                                                                    label.code
                                                                }})
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-7 col-md-7 col-12"
                                            >
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            Etiquetas
                                                            seleccionadas:
                                                        </h5>
                                                    </div>
                                                    <div
                                                        class="card-body overflow-auto"
                                                        style="max-height: 180px;"
                                                    >
                                                        <div class="row">
                                                            <div
                                                                v-for="selectedLabel in selectedLabels"
                                                                :key="
                                                                    selectedLabel.id
                                                                "
                                                                class="col-md-12 col-sm-12 col-12"
                                                            >
                                                                <div
                                                                    class="info-box"
                                                                >
                                                                    <div
                                                                        class="info-box-content overflow-hidden"
                                                                    >
                                                                        <span
                                                                            class="info-box-text"
                                                                            >{{
                                                                                selectedLabel.description
                                                                            }}</span
                                                                        >
                                                                        <span
                                                                            class="info-box-number"
                                                                            >{{
                                                                                selectedLabel.code
                                                                            }}</span
                                                                        >
                                                                    </div>
                                                                    <button
                                                                        @click.prevent="
                                                                            removeSelectedLabel(
                                                                                selectedLabel
                                                                            )
                                                                        "
                                                                        class=" btn btn-info info-box-icon"
                                                                    >
                                                                        <i
                                                                            class="fas fa-times"
                                                                        ></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .hcaLaboratory
                                                                .id !== 0
                                                        "
                                                        >PRUEBA HCA:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 4"
                                                        name="PRUEBA HCA:"
                                                        :options="
                                                            collections.hcaLaboratories
                                                        "
                                                        v-model="
                                                            analyte
                                                                .hcaLaboratory
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte
                                                                .infinityLabdateTest
                                                                .id !== 0
                                                        "
                                                        >PRUEBA LABDATE:</label
                                                    >
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 4"
                                                        name="PRUEBA LABDATE:"
                                                        :options="
                                                            collections.infinityLabdateTests
                                                        "
                                                        v-model="
                                                            analyte
                                                                .infinityLabdateTest
                                                                .id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <label
                                                        v-if="
                                                            analyte.state.id !==
                                                                0
                                                        "
                                                        >ESTADO:
                                                    </label>
                                                    <label v-else>&nbsp;</label>
                                                    <select2
                                                        v-if="formCount === 4"
                                                        :options="
                                                            collections.states
                                                        "
                                                        name="ESTADO: "
                                                        v-model="
                                                            analyte.state.id
                                                        "
                                                    ></select2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <div class="row">
                                                <button
                                                    @click.prevent="
                                                        cancelCreate
                                                    "
                                                    class="btn btn-danger mr-1"
                                                >
                                                    <i class="fas fa-times"></i>
                                                    Cancelar
                                                </button>
                                                <button
                                                    class="btn btn-default mr-1"
                                                    @click.prevent="backTab"
                                                >
                                                    <i
                                                        class="fas fa-angle-left"
                                                    ></i>
                                                    Atrás
                                                </button>
                                                <button
                                                    v-if="!editing"
                                                    @click.prevent="save"
                                                    type="submit"
                                                    class="btn btn-secondary"
                                                >
                                                    Guardar
                                                </button>
                                                <button
                                                    v-if="editing"
                                                    @click.prevent="edit"
                                                    type="submit"
                                                    class="btn btn-warning float-right ml-2"
                                                >
                                                    Editar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card my-2">
                <div class="card-header bg-secondary">
                    <div class="card-tools">
                        <button
                            v-if="!editing"
                            @click="setFormContent"
                            type="button"
                            class="btn btn-success float-right"
                        >
                            <i class="fas fa-plus"></i> Crear nuevo registro
                        </button>
                    </div>
                </div>
                <div class="card-header">
                    <div
                        class="input-group input-group-sm card-title"
                        style="width: 150px;"
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
                                v-model="search_analyte"
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
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Area de trabajo</th>
                                <th scope="col">Disponibilidad</th>
                                <th scope="col">HCA</th>
                                <th scope="col">LIS</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in setPaginate" :key="item.id">
                                <th scope="row">{{ item.id }}</th>
                                <td>{{ item.description }}</td>
                                <td>{{ item.work_area.description }}</td>
                                <td>{{ item.available.description }}</td>
                                <td>
                                    {{
                                        item.hca_laboratory == null
                                            ? ''
                                            : item.hca_laboratory.internal_code
                                    }}
                                    -
                                    {{
                                        item.hca_laboratory == null
                                            ? ''
                                            : item.hca_laboratory.description
                                    }}
                                </td>
                                <td>
                                    {{
                                        item.infinity_labdate_test == null
                                            ? ''
                                            : item.infinity_labdate_test.code
                                    }}
                                    -
                                    {{
                                        item.infinity_labdate_test == null
                                            ? ''
                                            : item.infinity_labdate_test
                                                  .description
                                    }}
                                </td>
                                <td>
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
                                <td class="text-center py-1 align-middle">
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
                                            @click.prevent="destroy(item)"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
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
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: '',
            analyte: {
                id: '',
                description: '',
                observation: '',
                mainAnalyte: {
                    id: 0,
                    description: ''
                },
                container: {
                    id: 0,
                    description: ''
                },
                sample: {
                    id: 0,
                    description: ''
                },
                collectionMethod: {
                    id: 0,
                    description: ''
                },
                loinc: {
                    id: '',
                    code: '',
                    sample: '',
                    description: ''
                },
                state: {
                    id: 0,
                    description: ''
                },
                available: {
                    id: 0,
                    description: ''
                },
                workArea: {
                    id: 0,
                    description: ''
                },
                vihKey: {
                    id: 0,
                    description: ''
                },
                timeProcess: {
                    id: 0,
                    description: ''
                },
                timeReception: {
                    id: 0,
                    description: ''
                },
                medicalOrder: {
                    id: 0,
                    description: ''
                },
                timeResponseUrg: {
                    id: 0,
                    description: ''
                },
                timeResponseAmb: {
                    id: 0,
                    description: ''
                },
                timeResponseHosp: {
                    id: 0,
                    description: ''
                },
                timeResponseExt: {
                    id: 0,
                    description: ''
                },
                fonasaTest: {
                    id: 0,
                    code: '',
                    description: ''
                },
                hcaLaboratory: {
                    id: 0,
                    code: '',
                    description: ''
                },
                infinityLabdateTest: {
                    id: 0,
                    code: '',
                    description: ''
                },
                quantitySamplePediatric: {
                    id: 0,
                    description: ''
                },
                quantitySampleAdult: {
                    id: 0,
                    description: ''
                },
                labels: [],
                indications: [],
                sampleConditions: []
            },
            collections: {
                analytes: [],
                mainAnalytes: [],
                containers: [],
                samples: [],
                collectionMethods: [],
                states: [],
                availables: [],
                workAreas: [],
                vihKeys: [],
                timeProcesses: [],
                timeReceptions: [],
                hcaLaboratories: [],
                infinityLabdateTests: [],
                labels: [],
                indications: [],
                timeResponses: [],
                medicalOrders: [],
                fonasaTests: [],
                quantitySamples: [],
                sampleConditions: []
            },
            idAnalyteSampleContainer: '',
            idTimeResponseDetail: '',
            selectedLabels: [],
            selectedIndications: [],
            selectedSampleConditions: [],
            orderIndications: [],
            orderSampleConditions: [],
            loinc_code: '',
            editing: false,
            createItem: false,
            formCount: 0,
            search_label: '',
            search_indication: '',
            search_analyte: '',
            search_condition: '',
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 5,
            disabledPrev: 'disabled',
            disabledNext: '',
            progress: 0,
            dmlOperation: false
        }
    },
    created() {
        this.getAnalytes()
        this.getLabel()
        this.getIndications()
        this.getMedicalOrders()
        this.getFonasaTests()
        this.getStates()
        this.getTimeResponses()
        this.getInfinityLabdate()
        this.getHcaLaboratories()
        this.getWorkareas()
        this.getMainAnalytes()
        this.getSamples()
        this.getVihKeys()
        this.getCollectionMethods()
        this.getContainers()
        this.getAvailables()
        this.getTimeProcesses()
        this.getTimeReceptions()
        this.getQuantitySamples()
        this.getSampleConditions()
    },
    watch: {
        loinc_code() {
            if (!this.editing) {
                this.analyte.loinc.id = 0
                this.analyte.loinc.description = ''
                this.analyte.loinc.sample = ''
                this.analyte.loinc.code = ''
            }
        },
        id() {
            if (!this.editing) {
                this.id = ''
            }
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
        }
    },
    computed: {
        filteredList() {
            return this.collections.labels.filter(label => {
                return (
                    (label.description
                        .toLowerCase()
                        .match(this.search_label.toLowerCase()) ||
                        label.code
                            .toLowerCase()
                            .match(this.search_label.toLowerCase())) &&
                    !label.selected
                )
            })
        },
        filteredListIndication() {
            return this.collections.indications.filter(indication => {
                return (
                    indication.description
                        .toLowerCase()
                        .match(this.search_indication.toLowerCase()) &&
                    !indication.selected
                )
            })
        },
        filteredListSampleCondition() {
            return this.collections.sampleConditions.filter(sampleCondition => {
                return (
                    sampleCondition.description
                        .toLowerCase()
                        .match(this.search_condition.toLowerCase()) &&
                    !sampleCondition.selected
                )
            })
        },
        setPaginate() {
            return this.paginate(this.filterData)
        },
        filterData() {
            return this.collections.analytes.filter(analyte => {
                return analyte.description
                    .toLowerCase()
                    .match(this.search_analyte.toLowerCase())
            })
        },
        from() {
            if (this.page === 1 && this.setPaginate.length === 0) {
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
    methods: {
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
            let numberOfPages = Math.ceil(this.filterData.length / this.perPage)
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
            this.formContent = true
        },
        nextTab() {
            this.formCount++
        },
        backTab() {
            this.formCount--
        },
        cancelCreate() {
            this.createItem = false
            this.resetForm()
            this.editing = false
        },
        newRegister() {
            this.createItem = true
        },
        parseSelect(data) {
            var newData = []
            if (data) {
                data.forEach(item => {
                    let obj = null
                    if (item.code) {
                        obj = {
                            id: item.id,
                            text: '(' + item.code + ') ' + item.description
                        }
                    } else if (item.internal_code) {
                        obj = {
                            id: item.id,
                            text:
                                '(' +
                                item.internal_code +
                                ') ' +
                                item.description
                        }
                    } else {
                        obj = {
                            id: item.id,
                            text: item.description
                        }
                    }

                    newData.push(obj)
                })
            }
            return newData
        },
        addSelectedLabel: function(label) {
            label.selected = true

            this.selectedLabels = this.collections.labels.filter(
                labelFilter => {
                    return labelFilter.selected
                }
            )
            this.search_label = ''
        },
        addSelectedIndication: function(indication) {
            indication.selected = true

            this.selectedIndications.push(indication)
            this.orderIndications.push(this.orderIndications.length + 1)
            this.search_indication = ''
        },
        addSelectedSampleCondition: function(sampleCondition) {
            sampleCondition.selected = true

            this.selectedSampleConditions.push(sampleCondition)
            this.orderSampleConditions.push(
                this.orderSampleConditions.length + 1
            )
            this.search_sampleCondition = ''
        },
        removeSelectedIndication: function(indication) {
            this.collections.indications.map(indication_ => {
                if (indication_.id === indication.id) {
                    console.log(indication_.id, indication.id)
                    indication_.selected = false
                }

                return indication_
            })

            const index = this.selectedIndications.findIndex(
                find => find.id === indication.id
            )

            this.selectedIndications.splice(index, 1)
            this.orderIndications.pop()
        },
        removeSelectedSampleCondition: function(sampleCondition) {
            this.collections.sampleConditions.map(sampleCondition_ => {
                if (sampleCondition_.id === sampleCondition.id) {
                    sampleCondition_.selected = false
                }

                return sampleCondition_
            })

            const index = this.selectedSampleConditions.findIndex(
                find => find.id === sampleCondition.id
            )

            this.selectedSampleConditions.splice(index, 1)
            this.orderSampleConditions.pop()
        },
        removeSelectedLabel: function(label) {
            label.selected = false
            this.selectedLabels = this.collections.labels.filter(
                labelFilter => {
                    return labelFilter.selected
                }
            )
        },
        getLabel: function() {
            fetch('/api/label')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.collections.labels = json.labels.map(label => {
                        label.selected = false
                        return label
                    })
                })
                .catch(error => console.log(error.message))
        },
        async getIndications() {
            const respIndication = await fetch('/api/indication')
            const jsonResponse = await respIndication.json()

            this.collections.indications = jsonResponse.indications.map(
                indication => {
                    indication.selected = false
                    return indication
                }
            )
        },
        async getSampleConditions() {
            const responseSampleCondition = await fetch('/api/sampleCondition')
            const jsonResponse = await responseSampleCondition.json()

            this.collections.sampleConditions = jsonResponse.sampleConditions.map(
                sampleCondition => {
                    sampleCondition.selected = false
                    return sampleCondition
                }
            )
        },
        async search_loinc() {
            const response = await axios.get(`/api/loinc/${this.loinc_code}`)

            if (response.data !== '') {
                this.analyte.loinc.code = response.data.loinc_num
                this.analyte.loinc.description = response.data.long_common_name
                this.analyte.loinc.sample = response.data.system_
                this.analyte.loinc.id = response.data.id
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'El código LOINC no existe'
                })
            }
        },
        async getAnalytes() {
            const resAnalyte = await axios.get('/api/analyte')

            this.collections.analytes = resAnalyte.data.analytes
            console.log(resAnalyte.data.analytes)
        },
        async getMedicalOrders() {
            const respMedicalOrder = await fetch('/api/medicalOrder')
            const jsonResponse = await respMedicalOrder.json()

            this.collections.medicalOrders = this.parseSelect(
                jsonResponse.medicalOrders
            )
        },
        async getQuantitySamples() {
            const respQuantitySamples = await fetch('/api/quantity-sample')
            const jsonResponse = await respQuantitySamples.json()

            this.collections.quantitySamples = this.parseSelect(
                jsonResponse.quantitySamples
            )
        },
        async getTimeResponses() {
            const respTimeResponse = await fetch('/api/timeResponse')
            const jsonResponse = await respTimeResponse.json()

            this.collections.timeResponses = this.parseSelect(
                jsonResponse.timeResponses
            )
        },
        async getFonasaTests() {
            const respFonasaTest = await fetch('/api/fonasa')

            const jsonResponse = await respFonasaTest.json()

            this.collections.fonasaTests = this.parseSelect(
                jsonResponse.fonasaTests
            )
        },

        async getInfinityLabdate() {
            const testInfinityLabdate = await axios.get(
                '/api/infinityLabdateTest'
            )
            this.collections.infinityLabdateTests = await this.parseSelect(
                testInfinityLabdate.data.infinityLabdateTests
            )
        },
        async getStates() {
            const state = await axios.get('/api/state')

            this.collections.states = await this.parseSelect(state.data.states)
        },
        async getHcaLaboratories() {
            const testHca = await axios.get('/api/hcaLaboratory')
            this.collections.hcaLaboratories = await this.parseSelect(
                testHca.data.hcaLaboratories
            )
        },
        async getWorkareas() {
            const workarea = await axios.get('/api/workarea')
            this.collections.workAreas = await this.parseSelect(
                workarea.data.workareas
            )
        },
        async getMainAnalytes() {
            const mainAnalyte = await fetch('/api/mainAnalyte')
            const jsonMainAnalyte = await mainAnalyte.json()
            this.collections.mainAnalytes = this.parseSelect(
                jsonMainAnalyte.mainAnalytes
            )
        },
        async getSamples() {
            const sample = await fetch('/api/sample')
            const jsonSample = await sample.json()
            this.collections.samples = this.parseSelect(jsonSample.samples)
        },
        async getVihKeys() {
            const vihkey = await axios.get('/api/vihkey')
            this.collections.vihKeys = await this.parseSelect(
                vihkey.data.vihKeys
            )
        },
        async getCollectionMethods() {
            const collectionMethod = await fetch('/api/collectionMethod')
            const jsonCollectionMethod = await collectionMethod.json()
            this.collections.collectionMethods = this.parseSelect(
                jsonCollectionMethod.collectionMethods
            )
        },
        async getContainers() {
            const container = await fetch('/api/container')
            const jsonContainer = await container.json()
            this.collections.containers = this.parseSelect(
                jsonContainer.containers
            )
        },
        async getAvailables() {
            const available = await axios.get('/api/available')
            this.collections.availables = await this.parseSelect(
                available.data.availables
            )
        },
        async getTimeProcesses() {
            const timeProcess = await axios.get('/api/timeProcess')
            this.collections.timeProcesses = await this.parseSelect(
                timeProcess.data.timeProcesses
            )
        },

        async getTimeReceptions() {
            const timeReception = await axios.get('/api/timeReception')
            this.collections.timeReceptions = await this.parseSelect(
                timeReception.data.timeReceptions
            )

            this.contentReady = true
        },
        async save() {
            if (this.validateInput()) {
                this.dmlOperation = true
                let labelsSelected = []
                this.selectedLabels.forEach(label => {
                    labelsSelected.push(label.id)
                })

                let indicationsSelected = []
                this.selectedIndications.forEach(indication => {
                    indicationsSelected.push(indication.id)
                })

                let sampleConditionSelected = []
                this.selectedSampleConditions.forEach(sampleCondition => {
                    sampleConditionSelected.push(sampleCondition.id)
                })

                let paramsAnalyte = {
                    description: this.analyte.description,
                    observation: this.analyte.observation,
                    state_id: this.analyte.state.id,
                    workarea_id: this.analyte.workArea.id,
                    loinc_id: this.analyte.loinc.id,
                    available_id: this.analyte.available.id,
                    hca_laboratory_id: this.analyte.hcaLaboratory.id,
                    infinity_labdate_test_id: this.analyte.infinityLabdateTest
                        .id,
                    vih_key_id: this.analyte.vihKey.id,
                    time_process_id: this.analyte.timeProcess.id,
                    time_reception_id: this.analyte.timeReception.id,
                    medical_order_id: this.analyte.medicalOrder.id,
                    // time_response_id: this.analyte.timeResponse.id,
                    fonasa_test_id: this.analyte.fonasaTest.id,
                    quantity_sample_pediatric_id: this.analyte
                        .quantitySamplePediatric.id,
                    quantity_sample_adult_id: this.analyte.quantitySampleAdult
                        .id
                }
                const resAnalyte = await axios.post(
                    '/api/analyte',
                    paramsAnalyte
                )
                this.collections.analytes.push(resAnalyte.data.analyte)
                const paramsLabel = {
                    labels: labelsSelected,
                    analyte_id: resAnalyte.data.analyte.id
                }
                const resAnalyteLabel = await axios.post(
                    '/api/analyteLabel',
                    paramsLabel
                )

                const paramsSampleCondition = {
                    sampleConditions: sampleConditionSelected,
                    orders: this.orderSampleConditions,
                    analyte_id: resAnalyte.data.analyte.id
                }
                const respSampleConditionAnalyte = await axios.post(
                    '/api/analyteSampleCondition',
                    paramsSampleCondition
                )

                const resSampleCollection = await axios.get(
                    `/api/sampleCollectionMethod/${this.analyte.sample.id}`
                )
                const filter = resSampleCollection.data.filter(dataFilter => {
                    return (
                        dataFilter.collection_method_id ===
                        this.analyte.collectionMethod.id
                    )
                })
                let sample_method = null
                if (filter.length === 0) {
                    const paramsCollection_method = {
                        sample_id: this.analyte.sample.id,
                        collection_method_id: this.analyte.collectionMethod.id
                    }
                    const respInsert = await axios.post(
                        '/api/sampleCollectionMethod',
                        paramsCollection_method
                    )
                    sample_method = respInsert.data.id
                } else {
                    sample_method = filter[0].id
                }
                const paramsAnalyteContainerSample = {
                    analyte_id: resAnalyte.data.analyte.id,
                    main_analyte_id: this.analyte.mainAnalyte.id,
                    sample_collection_method_id: sample_method,
                    container_id: this.analyte.container.id,
                    state_id: this.analyte.state.id
                }
                const resAnalyteSampleContainer = await axios.post(
                    '/api/analyteSampleContainer',
                    paramsAnalyteContainerSample
                )

                const paramsTimeResponse = {
                    analyte_id: resAnalyte.data.analyte.id,
                    state_id: this.analyte.state.id,
                    time_response_id_ambulatory: Number.parseInt(
                        this.analyte.timeResponseAmb.id
                    ),
                    time_response_id_hospitalized: Number.parseInt(
                        this.analyte.timeResponseHosp.id
                    ),
                    time_response_id_urgency: Number.parseInt(
                        this.analyte.timeResponseUrg.id
                    ),
                    time_response_id_external: Number.parseInt(
                        this.analyte.timeResponseExt.id
                    )
                }

                const responseTimeResp = await axios.post(
                    '/api/timeResponseDetail',
                    paramsTimeResponse
                )

                toast.fire({
                    icon: 'success',
                    title: 'Registro creado exitosamente'
                })
                this.resetForm()
                this.dmlOperation = false
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })
            }
        },
        async edit() {
            if (this.validateInput()) {
                this.dmlOperation = true
                let labelsSelected = []
                this.selectedLabels.forEach(label => {
                    labelsSelected.push(label.id)
                })
                let indicationsSelected = []
                this.selectedIndications.forEach(indication => {
                    indicationsSelected.push(indication.id)
                })

                let sampleConditionSelected = []
                this.selectedSampleConditions.forEach(sampleCondition => {
                    sampleConditionSelected.push(sampleCondition.id)
                })
                let params = {
                    description: this.analyte.description,
                    observation: this.analyte.observation,
                    state_id: this.analyte.state.id,
                    workarea_id: this.analyte.workArea.id,
                    loinc_id: this.analyte.loinc.id,
                    available_id: this.analyte.available.id,
                    hca_laboratory_id: this.analyte.hcaLaboratory.id,
                    infinity_labdate_test_id: this.analyte.infinityLabdateTest
                        .id,
                    vih_key_id: this.analyte.vihKey.id,
                    time_process_id: this.analyte.timeProcess.id,
                    time_reception_id: this.analyte.timeReception.id,
                    medical_order_id: this.analyte.medicalOrder.id,
                    // time_response_id: this.analyte.timeResponse.id,
                    fonasa_test_id: this.analyte.fonasaTest.id,
                    quantity_sample_pediatric_id: this.analyte
                        .quantitySamplePediatric.id,
                    quantity_sample_adult_id: this.analyte.quantitySampleAdult
                        .id
                }
                const resAnalyte = await axios.put(
                    `/api/analyte/${this.analyte.id}`,
                    params
                )
                const index = this.collections.analytes.findIndex(
                    find => find.id === this.analyte.id
                )
                this.collections.analytes.splice(
                    index,
                    1,
                    resAnalyte.data.analyte
                )
                params = {
                    labels: labelsSelected,
                    analyte_id: this.analyte.id
                }
                const resAnalyteLabel = await axios.put(
                    `/api/analyteLabel/${this.analyte.id}`,
                    params
                )

                params = {
                    sampleConditions: sampleConditionSelected,
                    analyte_id: this.analyte.id
                }
                const respAnalyteIndication = await axios.put(
                    `/api/analyteSampleCondition/${this.analyte.id}`,
                    params
                )

                const resSampleCollection = await axios.get(
                    `/api/sampleCollectionMethod/${this.analyte.sample.id}`
                )
                const filter = resSampleCollection.data.filter(dataFilter => {
                    return (
                        dataFilter.collection_method_id ===
                        this.analyte.collectionMethod.id
                    )
                })
                let sample_method = null
                if (filter.length === 0) {
                    params = {
                        sample_id: this.analyte.sample.id,
                        collection_method_id: this.analyte.collectionMethod.id
                    }
                    const respInsert = await axios.post(
                        '/api/sampleCollectionMethod',
                        params
                    )
                    sample_method = respInsert.data.id
                } else {
                    sample_method = filter[0].id
                }
                params = {
                    analyte_id: resAnalyte.data.analyte.id,
                    main_analyte_id: this.analyte.mainAnalyte.id,
                    sample_collection_method_id: sample_method,
                    container_id: this.analyte.container.id,
                    state_id: this.analyte.state.id
                }
                if (this.idAnalyteSampleContainer === null) {
                    const resAnalyteSampleContainer = await axios.post(
                        `/api/analyteSampleContainer`,
                        params
                    )
                } else {
                    const resAnalyteSampleContainer = await axios.put(
                        `/api/analyteSampleContainer/${this.idAnalyteSampleContainer}`,
                        params
                    )
                }

                if (this.idTimeResponseDetail === null) {
                    const resAnalyteSampleContainer = await axios.post(
                        `/api/analyteSampleContainer`,
                        params
                    )
                }

                const paramsTimeResponse = {
                    analyte_id: resAnalyte.data.analyte.id,
                    state_id: this.analyte.state.id,
                    time_response_id_ambulatory: Number.parseInt(
                        this.analyte.timeResponseAmb.id
                    ),
                    time_response_id_hospitalized: Number.parseInt(
                        this.analyte.timeResponseHosp.id
                    ),
                    time_response_id_urgency: Number.parseInt(
                        this.analyte.timeResponseUrg.id
                    ),
                    time_response_id_external: Number.parseInt(
                        this.analyte.timeResponseExt.id
                    )
                }

                console.log('paramsTimeResponse', paramsTimeResponse)

                if (this.idTimeResponseDetail !== '') {
                    const respTimeResponseDetail = await axios.put(
                        `/api/timeResponseDetail/${this.idTimeResponseDetail}`,
                        paramsTimeResponse
                    )
                } else {
                    const respTimeResponseDetail = await axios.post(
                        '/api/timeResponseDetail',
                        paramsTimeResponse
                    )
                }

                toast.fire({
                    icon: 'success',
                    title: 'Registro editado exitosamente'
                })

                this.resetForm()

                this.dmlOperation = false
            } else {
                toast.fire({
                    icon: 'error',
                    title: 'Complete los datos solicitados'
                })
            }
        },
        async setEdit(selected) {
            const { data } = await axios.get(`/api/analyte/${selected.id}`)

            console.log(data)

            this.analyte.timeResponseUrg.id = 0
            this.analyte.timeResponseAmb.id = 0
            this.analyte.timeResponseExt.id = 0
            this.analyte.timeResponseHosp.id = 0

            this.editing = true
            this.analyte.description = data.description
            this.analyte.observation = data.observation
            this.analyte.state.id = data.state.id
            this.analyte.id = data.id
            this.analyte.workArea.id = data.work_area.id
            this.analyte.available.id = data.available.id
            this.analyte.loinc.id = data.loinc.id
            this.loinc_code = data.loinc.loinc_num
            this.analyte.loinc.code = data.loinc.loinc_num
            this.analyte.loinc.description = data.loinc.long_common_name
            this.analyte.loinc.sample = data.loinc.system_
            this.analyte.hcaLaboratory.id = data.hca_laboratory.id
            this.analyte.infinityLabdateTest.id = data.infinity_labdate_test.id
            this.analyte.vihKey.id = data.vih_key.id
            this.analyte.timeProcess.id = data.time_process.id
            this.analyte.timeReception.id = data.time_reception.id
            this.analyte.medicalOrder.id = data.medical_order.id
            this.analyte.fonasaTest.id = data.fonasa_test.id
            this.analyte.quantitySamplePediatric.id =
                data.quantity_sample_pediatric.id
            this.analyte.quantitySampleAdult.id = data.quantity_sample_adult.id

            if (data.analyte_time_response_detail !== null) {
                this.idTimeResponseDetail = data.analyte_time_response_detail.id
                this.analyte.timeResponseUrg.id =
                    data.analyte_time_response_detail.time_response_urg.id
                this.analyte.timeResponseAmb.id =
                    data.analyte_time_response_detail.time_response_amb.id
                this.analyte.timeResponseExt.id =
                    data.analyte_time_response_detail.time_response_ext.id
                this.analyte.timeResponseHosp.id =
                    data.analyte_time_response_detail.time_response_hosp.id
            }

            console.log('analyte', this.analyte)
            const resAnalyteLabel = await axios.get(
                `/api/analyteLabel/${selected.id}`
            )

            if (resAnalyteLabel.data.length !== 0) {
                this.analyte.labels = resAnalyteLabel.data

                this.setSelectedFalse()
                this.selectedLabels = this.collections.labels
                    .map(label => {
                        this.analyte.labels.forEach(element => {
                            if (element.id === label.id) {
                                label.selected = true
                            }
                        })
                        return label
                    })
                    .filter(filterTest => {
                        return filterTest.selected
                    })
            }
            // const resAnalyteIndication = await axios.get(
            //     `/api/analyteIndication/${selected.id}`
            // )

            // if (resAnalyteIndication.data.length !== 0) {
            //     this.analyte.indications = resAnalyteIndication.data

            //     this.setIndicationSelectedFalse()
            //     const selection = this.collections.indications
            //         .map(indication => {
            //             this.analyte.indications.forEach(element => {
            //                 if (element.id === indication.id) {
            //                     indication.selected = true
            //                 }
            //             })
            //             return indication
            //         })
            //         .filter(filterIndication => {
            //             return filterIndication.selected
            //         })

            //     console.log(selection)

            //     this.selectedIndications = this.analyte.indications.sort(
            //         function(a, b) {
            //             if (a.pivot.order > b.pivot.order) {
            //                 return 1
            //             }
            //             if (a.pivot.order < b.pivot.order) {
            //                 return -1
            //             }
            //             // a must be equal to b
            //             return 0
            //         }
            //     )
            // } else {
            //     this.setIndicationSelectedFalse()
            //     this.selectedIndications = []
            // }

            const resAnalyteSampleCondition = await axios.get(
                `/api/analyteSampleCondition/${selected.id}`
            )

            if (resAnalyteSampleCondition.data.length !== 0) {
                this.analyte.sampleConditions = resAnalyteSampleCondition.data

                this.setSampleConditionSelectedFalse()
                const selection = this.collections.sampleConditions
                    .map(sampleCondition => {
                        this.analyte.sampleConditions.forEach(element => {
                            if (element.id === sampleCondition.id) {
                                sampleCondition.selected = true
                            }
                        })
                        return sampleCondition
                    })
                    .filter(filterSampleCondition => {
                        return filterSampleCondition.selected
                    })

                this.selectedSampleConditions = this.analyte.sampleConditions.sort(
                    function(a, b) {
                        if (a.pivot.order > b.pivot.order) {
                            return 1
                        }
                        if (a.pivot.order < b.pivot.order) {
                            return -1
                        }
                        // a must be equal to b
                        return 0
                    }
                )
            } else {
                this.setSampleConditionSelectedFalse()
                this.selectedSampleConditions = []
            }

            const resAnalyteSampleContainer = await axios.get(
                `/api/analyteSampleContainer/findByAnalyte/${selected.id}`
            )

            if (resAnalyteSampleContainer.data.length !== 0) {
                this.analyte.sample.id =
                    resAnalyteSampleContainer.data[0].sample_collection_method.sample_id
                this.analyte.collectionMethod.id =
                    resAnalyteSampleContainer.data[0].sample_collection_method.collection_method_id
                this.analyte.container.id =
                    resAnalyteSampleContainer.data[0].container_id
                this.analyte.mainAnalyte.id =
                    resAnalyteSampleContainer.data[0].main_analyte_id
                this.idAnalyteSampleContainer =
                    resAnalyteSampleContainer.data[0].id
            } else {
                this.idAnalyteSampleContainer = null
            }

            this.formContent = true
        },
        async destroy(item) {
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
                    const respAnalyteLabel = await axios.delete(
                        `/api/analyteLabel/${item.id}`
                    )

                    // const respAnalyteIndication = await axios.delete(
                    //     `/api/analyteIndication/${item.id}`
                    // )

                    const respAnalyteSampleCondition = await axios.delete(
                        `/api/analyteSampleCondition/${item.id}`
                    )

                    const respAnalyteTest = await axios.delete(
                        `/api/analyteTest/${item.id}`
                    )
                    const analyteSampleContainer = await axios.get(
                        `/api/analyteSampleContainer/findByAnalyte/${item.id}`
                    )
                    const respAnalyteSampleContainer = await axios.delete(
                        `/api/analyteSampleContainer/${analyteSampleContainer.data[0].id}`
                    )
                    const respAnalyte = await axios.delete(
                        `/api/analyte/${item.id}`
                    )

                    toast.fire({
                        icon: 'success',
                        title: 'Registro eliminado exitosamente'
                    })

                    const index = this.collections.analytes.findIndex(
                        find => find.id === item.id
                    )

                    this.collections.analytes.splice(index, 1)
                } catch (e) {
                    console.log(e.message)
                    toast.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error'
                    })
                }
            }
        },
        resetForm() {
            this.analyte = {
                id: '',
                description: '',
                observation: '',
                mainAnalyte: {
                    id: 0,
                    description: ''
                },
                container: {
                    id: 0,
                    description: ''
                },
                sample: {
                    id: 0,
                    description: ''
                },
                collectionMethod: {
                    id: 0,
                    description: ''
                },
                loinc: {
                    id: '',
                    code: '',
                    sample: '',
                    description: ''
                },
                state: {
                    id: 0,
                    description: ''
                },
                available: {
                    id: 0,
                    description: ''
                },
                workArea: {
                    id: 0,
                    description: ''
                },
                vihKey: {
                    id: 0,
                    description: ''
                },
                timeProcess: {
                    id: 0,
                    description: ''
                },
                timeReception: {
                    id: 0,
                    description: ''
                },
                timeResponseUrg: {
                    id: 0,
                    description: ''
                },
                timeResponseExt: {
                    id: 0,
                    description: ''
                },
                timeResponseAmb: {
                    id: 0,
                    description: ''
                },
                timeResponseHosp: {
                    id: 0,
                    description: ''
                },
                medicalOrder: {
                    id: 0,
                    description: ''
                },
                fonasaTest: {
                    id: 0,
                    description: ''
                },
                hcaLaboratory: {
                    id: 0,
                    code: '',
                    description: ''
                },
                infinityLabdateTest: {
                    id: 0,
                    code: '',
                    description: ''
                },
                quantitySamplePediatric: {
                    id: 0,
                    description: ''
                },
                quantitySampleAdult: {
                    id: 0,
                    description: ''
                },
                labels: [],
                indications: [],
                sampleConditions: []
            }

            this.selectedIndications = []
            this.selectedSampleConditions = []
            this.selectedLabels = []
            this.loinc_code = ''
            this.editing = false
            this.createItem = false
            this.formCount = 0
            this.search_label = ''
            this.search_analyte = ''
            this.formContent = false
            this.idAnalyteSampleContainer = ''
            this.idTimeResponseDetail = ''

            this.setSelectedFalse()
            this.setIndicationSelectedFalse()
            this.setSampleConditionSelectedFalse()
        },
        validateInput() {
            return this.analyte.state.id !== 0
        },
        resetCheck() {
            this.checkDescription = ''
        },
        setSelectedFalse() {
            this.collections.labels.map(label => {
                label.selected = false
                return label
            })
        },
        setIndicationSelectedFalse() {
            this.collections.indications.map(indication => {
                indication.selected = false
                return indication
            })
        },
        setSampleConditionSelectedFalse() {
            this.collections.sampleConditions.map(sampleCondition => {
                sampleCondition.selected = false
                return sampleCondition
            })
        }
    }
}
</script>

<style scoped>
div,
label,
input,
textarea,
button {
    font-size: 13px;
}

table thead {
    font-size: 14px;
}

.list-group {
    max-height: 220px;
}

.info-box-icon {
    font-size: 1em;
    max-height: 30px;
    max-width: 25px;
}

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

.badge {
    font-size: 1em;
}

.info-box {
    min-height: 0px;
}
</style>
