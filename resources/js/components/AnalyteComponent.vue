<template>
    <div>
        <div v-if="!contentReady">
            <div
                v-if="!collections.analytes.length"
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
                    <h5 class="card-title m-2">Crear nuevo registro</h5>
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
                                    'bg-secondary': formCount == 0,
                                    active: formCount == 0,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 2 ||
                                        formCount === 3
                                }"
                                class="nav-link"
                                id="custom-tabs-one-loinc-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-loinc"
                                role="tab"
                                aria-controls="custom-tabs-one-loinc"
                                :aria-selected="formCount == 0 ? true : false"
                                ><span
                                    >DATOS LOINC
                                    <i
                                        class="fas fa-check text-success fa-lg"
                                    ></i></span
                            ></a>
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount == 1,
                                    active: formCount == 1,
                                    disabled:
                                        formCount === 0 ||
                                        formCount === 2 ||
                                        formCount === 3
                                }"
                                class="nav-link"
                                id="custom-tabs-one-general-1-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-general-1"
                                role="tab"
                                aria-controls="custom-tabs-one-general-1"
                                :aria-selected="formCount == 1 ? true : false"
                                >DATOS GENERALES</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount == 2,
                                    active: formCount == 2,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 0 ||
                                        formCount === 3
                                }"
                                class="nav-link"
                                id="custom-tabs-one-lis-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-lis"
                                role="tab"
                                aria-controls="custom-tabs-one-lis"
                                :aria-selected="formCount == 2 ? true : false"
                                >INFORMACIÓN CLÍNICA</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    ['bg-secondary']: formCount == 3,
                                    active: formCount == 3,
                                    disabled:
                                        formCount === 1 ||
                                        formCount === 2 ||
                                        formCount === 0
                                }"
                                class="nav-link"
                                id="custom-tabs-one-test-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-test"
                                role="tab"
                                aria-controls="custom-tabs-one-test"
                                :aria-selected="formCount == 3 ? true : false"
                                >DATOS LIS</a
                            >
                        </li>
                    </ul>
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
                                    formCount == 0 ? ['show', 'active'] : ''
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
                                                <label>Código</label>
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
                                                <label>Nombre</label>
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
                                                <label>Tipo muestra</label>
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
                                                class="btn btn-default"
                                                @click.prevent="
                                                    nextTab();
                                                    getGeneralOneFormItems();
                                                "
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
                                    formCount == 1 ? ['show', 'active'] : ''
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
                                                    <input
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
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .mainAnalytes
                                                                .length
                                                        "
                                                        name="PRESTACIÓN: "
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
                                                    <select2
                                                        v-if="
                                                            collections.samples
                                                                .length
                                                        "
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
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .collectionMethods
                                                                .length
                                                        "
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
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .containers
                                                                .length
                                                        "
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
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .workAreas
                                                                .length
                                                        "
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
                                                    <select2
                                                        v-if="
                                                            collections.vihKeys
                                                                .length
                                                        "
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
                                        </div>
                                        <div class="float-right">
                                            <div class="row">
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
                                                    @click.prevent="
                                                        nextTab();
                                                        getGeneralTwoFormItems();
                                                    "
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
                                    formCount == 2 ? ['show', 'active'] : ''
                                "
                                class="tab-pane fade"
                                id="custom-tabs-one-lis"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-lis-tab"
                            >
                                <div>
                                    <div
                                        v-if="
                                            !collections.timeReceptions.length
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
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        >Información
                                                        general</label
                                                    >
                                                    <textarea
                                                        v-model="
                                                            analyte.observation
                                                        "
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="Escriba una breve reseña sobre la utilidad del examen..."
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-sm-4 col-12 col-md-4"
                                            >
                                                <div class="form-group">
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .timeReceptions
                                                                .length
                                                        "
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
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .timeProcesses
                                                                .length
                                                        "
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
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .availables
                                                                .length
                                                        "
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
                                                    @click.prevent="
                                                        nextTab();
                                                        getTestFormItems();
                                                    "
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
                                    formCount == 3 ? ['show', 'active'] : ''
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
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .hcaLaboratories
                                                                .length
                                                        "
                                                        name="PRUEBA HCA"
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
                                                    <select2
                                                        v-if="
                                                            collections
                                                                .infinityLabdateTests
                                                                .length
                                                        "
                                                        name="PRUEBA LABDATE"
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
                                                    <select2
                                                        v-if="
                                                            collections.states
                                                                .length
                                                        "
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
                                            ? ""
                                            : item.hca_laboratory.internal_code
                                    }}
                                    -
                                    {{
                                        item.hca_laboratory == null
                                            ? ""
                                            : item.hca_laboratory.description
                                    }}
                                </td>
                                <td>
                                    {{
                                        item.infinity_labdate_test == null
                                            ? ""
                                            : item.infinity_labdate_test.code
                                    }}
                                    -
                                    {{
                                        item.infinity_labdate_test == null
                                            ? ""
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
                                        <a
                                            @click.prevent="setEdit(item)"
                                            class="btn btn-warning mx-1"
                                            href="#"
                                            ><i class="fas fa-pencil-alt"></i
                                        ></a>
                                        <a
                                            class="btn btn-danger mx-1"
                                            href="#"
                                            @click.prevent="destroy(item)"
                                            ><i class="fas fa-trash"></i
                                        ></a>
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
            id: "",
            analyte: {
                id: "",
                description: "",
                observation: "",
                mainAnalyte: {
                    id: 0,
                    description: ""
                },
                container: {
                    id: 0,
                    description: ""
                },
                sample: {
                    id: 0,
                    description: ""
                },
                collectionMethod: {
                    id: 0,
                    description: ""
                },
                loinc: {
                    id: "",
                    code: "",
                    sample: "",
                    description: ""
                },
                state: {
                    id: 0,
                    description: ""
                },
                available: {
                    id: 0,
                    description: ""
                },
                workArea: {
                    id: 0,
                    description: ""
                },
                vihKey: {
                    id: 0,
                    description: ""
                },
                timeProcess: {
                    id: 0,
                    description: ""
                },
                timeReception: {
                    id: 0,
                    description: ""
                },
                hcaLaboratory: {
                    id: 0,
                    code: "",
                    description: ""
                },
                infinityLabdateTest: {
                    id: 0,
                    code: "",
                    description: ""
                },
                labels: []
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
                labels: []
            },
            idAnalyteSampleContainer: "",
            selectedLabels: [],
            loinc_code: "",
            editing: false,
            createItem: false,
            formCount: 0,
            search_label: "",
            search_analyte: "",
            formContent: false,
            contentReady: false,
            pages: [],
            page: 1,
            perPage: 5,
            disabledPrev: "disabled",
            disabledNext: "",
            progress: 0
        };
    },
    created() {
        this.startProgressiveBar();
        this.getAnalytes();
        this.getLabel();
    },
    watch: {
        loinc_code() {
            if (!this.editing) {
                this.analyte.loinc.id = 0;
                this.analyte.loinc.description = "";
                this.analyte.loinc.sample = "";
                this.analyte.loinc.code = "";
            }
        },
        id() {
            if (!this.editing) {
                this.id = "";
            }
        },
        page() {
            this.isPrevDisabled();
            this.isNextDisabled();
        },
        filterData() {
            this.pages = [];
            this.page = 1;
            this.setPages();
        },
        pages() {
            if (this.pages.length <= 1) {
                this.disabledNext = "disabled";
            } else {
                this.disabledNext = "";
            }
        },
        perPage() {
            this.pages = [];
            this.page = 1;
            this.setPages();
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
                );
            });
        },
        setPaginate() {
            return this.paginate(this.filterData);
        },
        filterData() {
            const filtered = this.collections.analytes.filter(analyte => {
                return analyte.description
                    .toLowerCase()
                    .match(this.search_analyte.toLowerCase());
            });
            return filtered;
        },
        from() {
            if (this.page === 1 && this.setPaginate.length == 0) {
                return 0;
            } else if (this.page === 1) {
                return 1;
            } else {
                return this.page * this.setPaginate.length - this.perPage;
            }
        },
        to() {
            if (this.page === 1) {
                return this.setPaginate.length;
            }
            return this.page * this.perPage;
        }
    },
    methods: {
        startProgressiveBar() {
            let width = 0;
            const vm = this;
            let progress = setInterval(function() {
                if (vm.progress <= 99) {
                    vm.progress += width;
                    width += 0.1;
                }
                if (vm.collections.analytes.length) {
                    vm.progress = 100;
                    clearInterval(progress);
                    vm.contentReady = true;
                }
            }, 300);
        },
        currentPage(page) {
            this.page = page;
        },
        prevPage() {
            this.page--;
        },
        nextPage() {
            this.page++;
        },
        isPrevDisabled() {
            if (this.page !== 1) {
                this.disabledPrev = "";
            } else {
                this.disabledPrev = "disabled";
            }
        },
        isNextDisabled() {
            if (this.page < this.pages.length) {
                this.disabledNext = "";
            } else {
                this.disabledNext = "disabled";
            }
        },
        setPages() {
            let numberOfPages = [];
            numberOfPages = Math.ceil(this.filterData.length / this.perPage);
            for (let i = 1; i <= numberOfPages; i++) {
                this.pages.push(i);
            }
        },
        paginate(array) {
            let page = this.page;
            let perpage = this.perPage;
            let from = page * perpage - perpage;
            let to = page * perpage;

            return array.slice(from, to);
        },
        setFormContent() {
            this.formContent = true;
        },
        nextTab() {
            this.formCount++;
        },
        backTab() {
            this.formCount--;
        },
        cancelCreate() {
            this.createItem = false;
            this.resetForm();
            this.editing = false;
        },
        newRegister() {
            this.createItem = true;
        },
        parseSelect(data) {
            var newData = [];
            if (data) {
                data.forEach(item => {
                    let obj = null;
                    if (item.code) {
                        obj = {
                            id: item.id,
                            text: "(" + item.code + ") " + item.description
                        };
                    } else if (item.internal_code) {
                        obj = {
                            id: item.id,
                            text:
                                "(" +
                                item.internal_code +
                                ") " +
                                item.description
                        };
                    } else {
                        obj = {
                            id: item.id,
                            text: item.description
                        };
                    }

                    newData.push(obj);
                });
            }
            return newData;
        },
        addSelectedLabel: function(label) {
            label.selected = true;

            this.selectedLabels = this.collections.labels.filter(
                labelFilter => {
                    return labelFilter.selected;
                }
            );
            this.search_label = "";
        },
        removeSelectedLabel: function(label) {
            label.selected = false;
            this.selectedLabels = this.collections.labels.filter(
                labelFilter => {
                    return labelFilter.selected;
                }
            );
        },
        getLabel: function() {
            fetch("/api/label")
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw Error("Error en el backend");
                    }
                })
                .then(json => {
                    this.collections.labels = json.labels.map(label => {
                        label.selected = false;
                        return label;
                    });
                })
                .catch(error => console.log(error.message));
        },
        async search_loinc() {
            const response = await axios.get(`/api/loinc/${this.loinc_code}`);
            console.log(response);

            if (response.data !== "") {
                this.analyte.loinc.code = response.data.loinc_num;
                this.analyte.loinc.description = response.data.long_common_name;
                this.analyte.loinc.sample = response.data.system_;
                this.analyte.loinc.id = response.data.id;
            } else {
                toast.fire({
                    icon: "error",
                    title: "El código LOINC no existe"
                });
            }
        },
        async getAnalytes() {
            const resAnalyte = await axios.get("/api/analyte");

            this.collections.analytes = resAnalyte.data.analytes;
        },
        async getTestFormItems() {
            if (this.collections.hcaLaboratories.length == 0) {
                const testInfinity = await axios.get(
                    "/api/infinityLabdateTest"
                );

                this.collections.infinityLabdateTests = await this.parseSelect(
                    testInfinity.data
                );

                const testHca = await axios.get("/api/hcaLaboratory");
                this.collections.hcaLaboratories = await this.parseSelect(
                    testHca.data
                );

                const state = await axios.get("/api/state");

                this.collections.states = await this.parseSelect(
                    state.data.states
                );
            }
        },
        async getGeneralOneFormItems() {
            if (this.collections.containers.length == 0) {
                const workarea = await axios.get("/api/workarea");
                this.collections.workAreas = await this.parseSelect(
                    workarea.data.workareas
                );

                const mainAnalyte = await fetch("/api/mainAnalyte");
                const jsonMainAnalyte = await mainAnalyte.json();
                this.collections.mainAnalytes = this.parseSelect(
                    jsonMainAnalyte.mainAnalytes
                );

                const sample = await fetch("/api/sample");
                const jsonSample = await sample.json();
                this.collections.samples = this.parseSelect(jsonSample.samples);

                const vihkey = await axios.get("/api/vihkey");
                this.collections.vihKeys = await this.parseSelect(
                    vihkey.data.vihKeys
                );

                const collectionMethod = await fetch("/api/collectionMethod");
                const jsonCollectionMethod = await collectionMethod.json();
                this.collections.collectionMethods = this.parseSelect(
                    jsonCollectionMethod.collectionMethods
                );

                const container = await fetch("/api/container");
                const jsonContainer = await container.json();
                this.collections.containers = this.parseSelect(
                    jsonContainer.containers
                );
            }
        },
        async getGeneralTwoFormItems() {
            if (this.collections.timeReceptions == 0) {
                const available = await axios.get("/api/available");
                this.collections.availables = await this.parseSelect(
                    available.data.availables
                );

                const timeProcess = await axios.get("/api/timeProcess");
                this.collections.timeProcesses = await this.parseSelect(
                    timeProcess.data.timeProcesses
                );

                const timeReception = await axios.get("/api/timeReception");
                this.collections.timeReceptions = await this.parseSelect(
                    timeReception.data.timeReceptions
                );
            }
        },
        async save() {
            if (this.validateInput()) {
                let labelsSelected = [];
                this.selectedLabels.forEach(label => {
                    labelsSelected.push(label.id);
                });
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
                    time_reception_id: this.analyte.timeReception.id
                };

                const resAnalyte = await axios.post("/api/analyte", params);

                console.log(resAnalyte.data);
                this.collections.analytes.push(resAnalyte.data);

                params = {
                    labels: labelsSelected,
                    analyte_id: resAnalyte.data.id
                };

                console.log(params);

                const resAnalyteLabel = await axios.post(
                    "/api/analyteLabel",
                    params
                );
                console.log("analyteLabel:", resAnalyteLabel);

                const resSampleCollection = await axios.get(
                    `/api/sampleCollectionMethod/${this.analyte.sample.id}`
                );

                console.log("resSampleCollection", resSampleCollection);

                const filter = resSampleCollection.data.filter(dataFilter => {
                    return (
                        dataFilter.collection_method_id ==
                        this.analyte.collectionMethod.id
                    );
                });

                console.log("filter", filter);

                let sample_method = null;

                if (filter.length === 0) {
                    params = {
                        sample_id: this.analyte.sample.id,
                        collection_method_id: this.analyte.collectionMethod.id
                    };
                    const respInsert = await axios.post(
                        "/api/sampleCollectionMethod",
                        params
                    );
                    console.log("collectionMethodInsert:", respInsert);
                    sample_method = respInsert.data.id;
                } else {
                    sample_method = filter[0].id;
                }

                console.log("sample_method", sample_method);

                params = {
                    analyte_id: resAnalyte.data.id,
                    main_analyte_id: this.analyte.mainAnalyte.id,
                    sample_collection_method_id: sample_method,
                    container_id: this.analyte.container.id,
                    state_id: this.analyte.state.id
                };

                console.log("params analyteSampleContainer: ", params);

                const resAnalyteSampleContainer = await axios.post(
                    "/api/analyteSampleContainer",
                    params
                );
                console.log(
                    "analyteSampleContainer:",
                    resAnalyteSampleContainer
                );

                toast.fire({
                    icon: "success",
                    title: "Registro creado exitosamente"
                });

                this.resetForm();
            } else {
                toast.fire({
                    icon: "errir",
                    title: "Complete los datos solicitados"
                });
            }
        },
        async edit() {
            if (this.validateInput()) {
                let labelsSelected = [];
                this.selectedLabels.forEach(label => {
                    labelsSelected.push(label.id);
                });
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
                    time_reception_id: this.analyte.timeReception.id
                };

                console.log(params);
                const resAnalyte = await axios.put(
                    `/api/analyte/${this.analyte.id}`,
                    params
                );

                const index = this.collections.analytes.findIndex(
                    find => find.id === this.analyte.id
                );

                this.collections.analytes.splice(index, 1, resAnalyte.data);

                params = {
                    labels: labelsSelected,
                    analyte_id: this.analyte.id
                };

                console.log(params);

                const resAnalyteLabel = await axios.put(
                    `/api/analyteLabel/${this.analyte.id}`,
                    params
                );
                console.log("analyteLabel:", resAnalyteLabel);

                const resSampleCollection = await axios.get(
                    `/api/sampleCollectionMethod/${this.analyte.sample.id}`
                );

                console.log("resSampleCollection", resSampleCollection);

                const filter = resSampleCollection.data.filter(dataFilter => {
                    return (
                        dataFilter.collection_method_id ==
                        this.analyte.collectionMethod.id
                    );
                });

                console.log("filter", filter);

                let sample_method = null;

                if (filter.length === 0) {
                    params = {
                        sample_id: this.analyte.sample.id,
                        collection_method_id: this.analyte.collectionMethod.id
                    };
                    const respInsert = await axios.post(
                        "/api/sampleCollectionMethod",
                        params
                    );
                    console.log("collectionMethodInsert:", respInsert);
                    sample_method = respInsert.data.id;
                } else {
                    sample_method = filter[0].id;
                }

                console.log("sample_method", sample_method);

                params = {
                    analyte_id: resAnalyte.data.id,
                    main_analyte_id: this.analyte.mainAnalyte.id,
                    sample_collection_method_id: sample_method,
                    container_id: this.analyte.container.id,
                    state_id: this.analyte.state.id
                };
                console.log("params analyteSampleContainer: ", params);

                if (this.idAnalyteSampleContainer === null) {
                    console.log('true')
                    const resAnalyteSampleContainer = await axios.post(
                        `/api/analyteSampleContainer`,
                        params
                    );
                } else {
                    console.log('false')
                    const resAnalyteSampleContainer = await axios.put(
                        `/api/analyteSampleContainer/${this.idAnalyteSampleContainer}`,
                        params
                    );
                }

                toast.fire({
                    icon: "success",
                    title: "Registro editado exitosamente"
                });

                this.resetForm();
            } else {
                toast.fire({
                    icon: "error",
                    title: "Complete los datos solicitados"
                });
            }
        },
        async setEdit(selected) {
            console.log("selected", selected);

            this.editing = true;
            this.analyte.description = selected.description;
            this.analyte.observation = selected.observation;
            this.analyte.state.id = selected.state.id;
            this.analyte.id = selected.id;
            this.analyte.workArea.id = selected.work_area.id;
            this.analyte.available.id = selected.available.id;
            this.analyte.loinc.id = selected.loinc.id;
            this.loinc_code = selected.loinc.loinc_num;
            this.analyte.loinc.code = selected.loinc.loinc_num;
            this.analyte.loinc.description = selected.loinc.long_common_name;
            this.analyte.loinc.sample = selected.loinc.system_;
            this.analyte.hcaLaboratory.id = selected.hca_laboratory.id;
            this.analyte.infinityLabdateTest.id =
                selected.infinity_labdate_test.id;
            this.analyte.vihKey.id = selected.vih_key.id;
            this.analyte.timeProcess.id = selected.time_process.id;
            this.analyte.timeReception.id = selected.time_reception.id;

            const resAnalyteLabel = await axios.get(
                `/api/analyteLabel/${selected.id}`
            );

            if (resAnalyteLabel.data.length != 0) {
                this.analyte.labels = resAnalyteLabel.data;

                this.setSelectedFalse();
                this.selectedLabels = this.collections.labels
                    .map(label => {
                        this.analyte.labels.forEach(element => {
                            if (element.id === label.id) {
                                label.selected = true;
                            }
                        });
                        return label;
                    })
                    .filter(filterTest => {
                        return filterTest.selected;
                    });
            }

            const resAnalyteSampleContainer = await axios.get(
                `/api/analyteSampleContainer/findByAnalyte/${selected.id}`
            );

            if (resAnalyteSampleContainer.data.length != 0) {
                this.analyte.sample.id =
                    resAnalyteSampleContainer.data[0].sample_collection_method.sample_id;
                this.analyte.collectionMethod.id =
                    resAnalyteSampleContainer.data[0].sample_collection_method.collection_method_id;
                this.analyte.container.id =
                    resAnalyteSampleContainer.data[0].container_id;
                this.analyte.mainAnalyte.id =
                    resAnalyteSampleContainer.data[0].main_analyte_id;
                this.idAnalyteSampleContainer =
                    resAnalyteSampleContainer.data[0].id;
            }else{
                this.idAnalyteSampleContainer = null
            }

            this.formContent = true;
        },
        async destroy(item) {
            const confirmation = await swal.fire({
                title: "¿Estás seguro?",
                text: "El registro se eliminará permanentemente",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "No, cancelar",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar"
            });
            if (confirmation.value) {
                try {
                    const respAnalyteLabel = await axios.delete(
                        `/api/analyteLabel/${item.id}`
                    );

                    console.log("respAnalyteLabel", respAnalyteLabel);

                    const respAnalyteTest = await axios.delete(
                        `/api/analyteTest/${item.id}`
                    );

                    console.log("respAnalyteTest", respAnalyteTest);
                    const analyteSampleContainer = await axios.get(
                        `/api/analyteSampleContainer/findByAnalyte/${item.id}`
                    );

                    console.log(
                        "analyteSampleContainer",
                        analyteSampleContainer
                    );
                    const respAnalyteSampleContainer = await axios.delete(
                        `/api/analyteSampleContainer/${analyteSampleContainer.data[0].id}`
                    );

                    console.log(
                        "respAnalyteSampleContainer",
                        respAnalyteSampleContainer
                    );

                    const respAnalyte = await axios.delete(
                        `/api/analyte/${item.id}`
                    );

                    console.log("respAnalyte", respAnalyte);

                    toast.fire({
                        icon: "success",
                        title: "Registro eliminado exitosamente"
                    });

                    const index = this.collections.analytes.findIndex(
                        find => find.id === item.id
                    );

                    this.collections.analytes.splice(index, 1);
                } catch (e) {
                    console.log(e.message);
                    toast.fire({
                        icon: "error",
                        title: "Ha ocurrido un error"
                    });
                }
            }
        },
        resetForm() {
            this.analyte = {
                id: "",
                description: "",
                observation: "",
                mainAnalyte: {
                    id: 0,
                    description: ""
                },
                container: {
                    id: 0,
                    description: ""
                },
                sample: {
                    id: 0,
                    description: ""
                },
                collectionMethod: {
                    id: 0,
                    description: ""
                },
                loinc: {
                    id: "",
                    code: "",
                    sample: "",
                    description: ""
                },
                state: {
                    id: 0,
                    description: ""
                },
                available: {
                    id: 0,
                    description: ""
                },
                workArea: {
                    id: 0,
                    description: ""
                },
                vihKey: {
                    id: 0,
                    description: ""
                },
                timeProcess: {
                    id: 0,
                    description: ""
                },
                timeReception: {
                    id: 0,
                    description: ""
                },
                hcaLaboratory: {
                    id: 0,
                    code: "",
                    description: ""
                },
                infinityLabdateTest: {
                    id: 0,
                    code: "",
                    description: ""
                },
                labels: []
            };

            this.collections.mainAnalytes = [];
            this.collections.samples = [];
            this.collections.collectionMethods = [];
            this.collections.states = [];
            this.collections.availables = [];
            this.collections.workAreas = [];
            this.collections.vihKeys = [];
            this.collections.timeProcesses = [];
            this.collections.timeReceptions = [];
            this.collections.hcaLaboratories = [];
            this.collections.infinityLabdateTests = [];
            this.collections.containers = [];

            this.selectedLabels = [];
            this.loinc_code = "";
            this.editing = false;
            this.createItem = false;
            this.formCount = 0;
            this.search_label = "";
            this.search_analyte = "";
            this.formContent = false;
            this.idAnalyteSampleContainer = "";
        },
        validateInput() {
            if (this.analyte.state.id == 0) {
                return false;
            } else {
                return true;
            }
        },
        resetCheck() {
            this.checkDescription = "";
        },
        setSelectedFalse() {
            this.collections.labels.map(label => {
                label.selected = false;
                return label;
            });
        }
    }
};
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
    max-height: 100px;
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
