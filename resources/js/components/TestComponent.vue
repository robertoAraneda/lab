<template>
    <div>
        <div v-if="!contentReady">
            <div
                v-if="!collections.LISTests.length"
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
                    <h5 class="card-title m-2">
                        Crear nuevo registro -
                        <span class="lead">{{ test.description }}</span>
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
                                    'bg-secondary': formCount == 0,
                                    active: formCount == 0,
                                    disabled: formCount === 1 || formCount === 2
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
                                    <!--                                    <i-->
                                    <!--                                        class="fas fa-check text-success fa-lg"-->
                                    <!--                                    ></i>-->
                                </span></a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                :class="{
                                    'bg-secondary': formCount == 1,
                                    active: formCount == 1,
                                    disabled: formCount === 0 || formCount === 2
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
                                    ['bg-secondary']: formCount === 2,
                                    active: formCount === 2,
                                    disabled: formCount === 1 || formCount === 0
                                }"
                                class="nav-link"
                                id="custom-tabs-one-test-tab"
                                data-toggle="pill"
                                href="#custom-tabs-one-test"
                                role="tab"
                                aria-controls="custom-tabs-one-test"
                                :aria-selected="formCount === 3"
                                >VALORES DE REFERENCIA</a
                            >
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div
                            :class="formCount == 0 ? ['show', 'active'] : ''"
                            class="tab-pane fade"
                            id="custom-tabs-one-loinc"
                            role="tabpanel"
                            aria-labelledby="custom-tabs-one-loinc-tab"
                        >
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Código</label>
                                        <input
                                            v-model="loinc_code"
                                            @keypress.enter.prevent="
                                                search_loinc
                                            "
                                            :class="check.loinc.code"
                                            type="text"
                                            class="form-control"
                                            placeholder="Ingrese código"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input
                                        type="hidden"
                                        v-model="test.loincTest.id"
                                    />

                                    <input
                                        type="hidden"
                                        v-model="test.loincTest.code"
                                    />
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input
                                            readonly
                                            v-model="test.loincTest.name"
                                            :class="check.loinc.name"
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
                                            v-model="test.loincTest.sample"
                                            :class="check.loinc.sample"
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
                                        @click.prevent="validateInputLoincData"
                                    >
                                        Continuar
                                        <i class="fas fa-angle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            :class="formCount == 1 ? ['show', 'active'] : ''"
                            class="tab-pane fade"
                            id="custom-tabs-one-general-1"
                            role="tabpanel"
                            aria-labelledby="custom-tabs-one-general-1-tab"
                        >
                            <div>
                                <div
                                    v-if="!collections.LISTests.length"
                                    class="d-flex justify-content-center"
                                >
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="row">
                                        <div class="col-8 col-sm-8">
                                            <div class="form-group">
                                                <label
                                                    v-if="
                                                        test.description !== ''
                                                    "
                                                    >NOMBRE:</label
                                                >
                                                <label v-else>&nbsp;</label>
                                                <input
                                                    v-model="test.description"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="NOMBRE:"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-4">
                                            <div class="form-group">
                                                <label
                                                    v-if="test.LISTest.id !== 0"
                                                    >CÓDIGO LIS:</label
                                                >
                                                <label v-else>&nbsp;</label>
                                                <select2
                                                    v-if="formCount == 1"
                                                    :options="
                                                        collections.LISTests
                                                    "
                                                    v-model="test.LISTest.id"
                                                    name="PRUEBA LIS:"
                                                ></select2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label v-if="test.unit.id !== 0"
                                                    >UNIDAD:</label
                                                >
                                                <label v-else>&nbsp;</label>
                                                <select2
                                                    v-if="formCount == 1"
                                                    :options="collections.units"
                                                    v-model="test.unit.id"
                                                    name="UNIDAD:"
                                                ></select2>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label
                                                    v-if="test.method.id !== 0"
                                                    >MÉTODO:</label
                                                >
                                                <label v-else>&nbsp;</label>
                                                <select2
                                                    v-if="formCount == 1"
                                                    :options="
                                                        collections.methods
                                                    "
                                                    v-model="test.method.id"
                                                    name="MÉTODO:"
                                                ></select2>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label
                                                    v-if="test.state.id !== 0"
                                                    >ESTADO:</label
                                                >
                                                <label v-else>&nbsp;</label>
                                                <select2
                                                    v-if="formCount == 1"
                                                    :options="
                                                        collections.states
                                                    "
                                                    v-model="test.state.id"
                                                    name="ESTADO:"
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
                                                    validateInputGeneralData
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
                            :class="formCount === 2 ? ['show', 'active'] : ''"
                            class="tab-pane fade"
                            id="custom-tabs-one-test"
                            role="tabpanel"
                            aria-labelledby="custom-tabs-one-test-tab"
                        >
                            <div>
                                <div
                                    v-if="!collections.ageUnits.length"
                                    class="d-flex justify-content-center"
                                >
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div v-else class="table-responsive">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group col-md-6">
                                            <select
                                                :readonly="blockTypeValue"
                                                class="form-control"
                                                v-model="
                                                    referenceRange.typeValue
                                                "
                                            >
                                                <option value="0"
                                                    >SELECCIONE TIPO VALOR:
                                                </option>
                                                <option value="1"
                                                    >SIN VALOR DE
                                                    REFERENCIA</option
                                                >
                                                <option value="CUALITATIVO">
                                                    CUALITATIVO
                                                </option>
                                                <option value="CUANTITATIVO">
                                                    CUANTITATIVO
                                                </option>
                                            </select>
                                        </div>
                                        <button
                                            @click="addRow"
                                            style="max-height: 40px;"
                                            class="btn btn-success btn-sm"
                                        >
                                            <i class="fas fa-plus"></i> Agregar
                                            VR
                                        </button>
                                    </div>
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="min-width: 150px;">
                                                    Unidad edad
                                                </th>
                                                <th style="min-width: 150px;">
                                                    Género
                                                </th>
                                                <th>
                                                    Edad
                                                </th>
                                                <th></th>
                                                <th
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    Normal
                                                </th>
                                                <th
                                                    v-show="cuantitativeBoolean"
                                                ></th>
                                                <th
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    Crítico
                                                </th>
                                                <th
                                                    v-show="cuantitativeBoolean"
                                                ></th>
                                                <th
                                                    style="min-width: 150px;"
                                                    v-show="cualitativeBoolean"
                                                >
                                                    Valor normal
                                                </th>
                                                <th
                                                    v-show="cuantitativeBoolean"
                                                    style="min-width: 150px;"
                                                >
                                                    Interpretación
                                                </th>
                                                <th style="min-width: 250px;">
                                                    Opciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(n, index) in rangesForm"
                                                :key="index"
                                            >
                                                <th>{{ n }}</th>
                                                <td>
                                                    <select2
                                                        v-if="formCount == 2"
                                                        :options="
                                                            collections.ageUnits
                                                        "
                                                        v-model="
                                                            referenceRange
                                                                .ageUnit[index]
                                                        "
                                                        name="UNIDAD EDAD:"
                                                        :id="'ageUnit' + index"
                                                    ></select2>
                                                </td>
                                                <td>
                                                    <select2
                                                        v-if="formCount == 2"
                                                        :options="
                                                            collections.genders
                                                        "
                                                        v-model="
                                                            referenceRange
                                                                .gender[index]
                                                        "
                                                        name="GÉNERO:"
                                                        :id="'gender' + index"
                                                    ></select2>
                                                </td>
                                                <td>
                                                    <input
                                                        :id="'ageStart' + index"
                                                        class="form-control form-lenght-input"
                                                        placeholder="Mín"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .ageStart[index]
                                                        "
                                                    />
                                                </td>
                                                <td>
                                                    <input
                                                        :id="'ageEnd' + index"
                                                        class="form-control form-lenght-input"
                                                        placeholder="Máx"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .ageEnd[index]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    class="table-success"
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    <input
                                                        :id="
                                                            'normalMinimum' +
                                                                index
                                                        "
                                                        class="form-control form-lenght-input"
                                                        placeholder="Mín"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .normalMinimum[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    class="table-success"
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    <input
                                                        :id="
                                                            'normalMaximum' +
                                                                index
                                                        "
                                                        class="form-control form-lenght-input"
                                                        placeholder="Máx"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .normalMaximum[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    class="table-danger"
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    <input
                                                        :id="
                                                            'criticalMinimum' +
                                                                index
                                                        "
                                                        class="form-control form-lenght-input"
                                                        placeholder="Mín"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .criticalMinimum[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    class="table-danger"
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    <input
                                                        :id="
                                                            'criticalMaximum' +
                                                                index
                                                        "
                                                        class="form-control form-lenght-input"
                                                        placeholder="Máx"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .criticalMaximum[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td v-show="cualitativeBoolean">
                                                    <input
                                                        :id="
                                                            'cualitativeValue' +
                                                                index
                                                        "
                                                        class="form-control"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .cualitativeValue[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    v-show="cuantitativeBoolean"
                                                >
                                                    <input
                                                        :id="
                                                            'interpretation' +
                                                                index
                                                        "
                                                        class="form-control"
                                                        type="text"
                                                        v-model="
                                                            referenceRange
                                                                .interpretation[
                                                                index
                                                            ]
                                                        "
                                                    />
                                                </td>
                                                <td
                                                    class="text-center py-1 align-middle"
                                                >
                                                    <div
                                                        class="btn-group btn-group-sm"
                                                    >
                                                        <button
                                                            v-if="
                                                                referenceRange
                                                                    .validateState[
                                                                    index
                                                                ]
                                                            "
                                                            @click.prevent="
                                                                dValidate(index)
                                                            "
                                                            class="btn btn-success mx-1"
                                                        >
                                                            <i
                                                                class="fas fa-check"
                                                            ></i>
                                                            Validado
                                                        </button>
                                                        <button
                                                            v-if="
                                                                !referenceRange
                                                                    .validateState[
                                                                    index
                                                                ]
                                                            "
                                                            @click.prevent="
                                                                validate(index)
                                                            "
                                                            class="btn btn-warning mx-1"
                                                        >
                                                            <i
                                                                class="fas fa-info"
                                                            ></i>
                                                            Validar VR
                                                        </button>
                                                        <button
                                                            v-if="
                                                                !referenceRange
                                                                    .validateState[
                                                                    index
                                                                ]
                                                            "
                                                            class="btn btn-danger mx-1"
                                                            @click.prevent="
                                                                destroyRow(
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-times"
                                                            ></i>
                                                            Eliminar VR
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                        class="btn btn-default mr-1"
                                        @click.prevent="backTab"
                                    >
                                        <i class="fas fa-angle-left"></i>
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

            <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Listado general de pruebas</h3>
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
                        style="width: 250px;"
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
                                v-model="search_item"
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

                    <div class="card-body table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Prueba infinity</th>
                                <th scope="col">Método</th>
                                <th scope="col">Unidades</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </thead>
                            <tbody
                                v-for="(item, index) in setPaginate"
                                :key="item.id"
                            >
                                <th scope="row">{{ item.id }}</th>
                                <td>{{ item.description }}</td>
                                <td>
                                    {{ item.infinity_test.code }} -
                                    {{ item.infinity_test.description }}
                                </td>
                                <td>{{ item.method.description }}</td>
                                <td>{{ item.unit.description }}</td>
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
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar registro"
                                            @click.prevent="setEdit(item)"
                                            class="btn btn-warning mx-1"
                                        >
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar registro"
                                            class="btn btn-danger mx-1"
                                            @click.prevent="
                                                destroy(item, index)
                                            "
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" :class="disabledPrev">
                                        <button
                                            @click="prevPage"
                                            class="page-link"
                                        >
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
                                            @click="
                                                currentPage($event, pageNumber)
                                            "
                                            class="page-link"
                                        >
                                            {{ pageNumber }}
                                        </button>
                                    </li>
                                    <li class="page-item" :class="disabledNext">
                                        <button
                                            @click="nextPage"
                                            class="page-link"
                                        >
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
    </div>
</template>

<script>
export default {
    name: 'TestComponent',
    data: function() {
        return {
            collections: {
                LISTests: [],
                methods: [],
                units: [],
                states: [],
                genders: [],
                ageUnits: []
            },
            test: {
                id: '',
                description: '',
                loincTest: {
                    id: '',
                    code: '',
                    name: '',
                    sample: ''
                },
                LISTest: {
                    id: 0,
                    code: '',
                    description: ''
                },
                method: {
                    id: 0,
                    description: ''
                },
                unit: {
                    id: 0,
                    description: ''
                },
                state: {
                    id: 0,
                    description: ''
                }
            },
            referenceRange: {
                id: [],
                typeValue: 0,
                ageUnit: [],
                gender: [],
                ageStart: [],
                ageEnd: [],
                normalMinimum: [],
                normalMaximum: [],
                criticalMinimum: [],
                criticalMaximum: [],
                cualitativeValue: [],
                interpretation: [],
                validateState: []
            },
            tests: [],
            referenceRangeDestroyed: [],
            search_item: '',
            editing: false,
            createRegister: false,
            contentReady: false,
            formContent: false,
            formCount: 0,
            createItem: false,
            id: '',
            loinc_code: '',
            check: {
                loinc: {
                    code: '',
                    name: '',
                    sample: ''
                }
            },
            cualitativeBoolean: false,
            cuantitativeBoolean: true,
            currentValue: 1,
            isActive: false,
            rangesForm: 0,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: 'disabled',
            disabledNext: ''
        }
    },
    created() {
        this.getTests()
        this.getStates()
        this.getUnits()
        this.getMethods()
        this.getInfinityTests()
        this.getGenders()
        this.getAgeUnit()
    },
    watch: {
        rangesForm(newVal, oldVal) {
            if (newVal < oldVal) {
                this.referenceRange.validateState.forEach(validate => {
                    validate = false
                })
            }
        },
        typeValue() {
            if (this.referenceRange.typeValue === 'CUALITATIVO') {
                this.cualitativeBoolean = true
                this.cuantitativeBoolean = false
            } else {
                this.cualitativeBoolean = false
                this.cuantitativeBoolean = true
            }
        },
        loinc_code() {
            if (!this.editing) {
                this.test.loincTest.id = 0
                this.test.loincTest.name = ''
                this.test.loincTest.sample = ''
                this.test.loincTest.code = ''
            }
        },
        id() {
            if (!this.editing) {
                this.test.id = ''
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
        blockTypeValue() {
            return this.rangesForm !== 0
        },
        checkAllValidateState() {
            let boolean = false
            if (this.rangesForm === 0) {
                boolean = true
            }
            this.referenceRange.validateState.forEach(range => {
                if (range) {
                    boolean = range
                }
            })
            return boolean
        },
        checkValidate() {
            return this.referenceRange.validateState[this.currentValue]
        },
        typeValue() {
            return this.referenceRange.typeValue
        },
        filterData() {
            const filtered = this.tests.filter(test => {
                const test_infinity =
                    test.infinity_test.description +
                    ' - ' +
                    test.infinity_test.code
                return (
                    test.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase()) ||
                    test_infinity
                        .toLowerCase()
                        .match(this.search_item.toLowerCase()) ||
                    test.method.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase()) ||
                    test.unit.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase()) ||
                    test.state.description
                        .toLowerCase()
                        .match(this.search_item.toLowerCase())
                )
            })

            return filtered
        },
        setPaginate() {
            return this.paginate(this.filterData)
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
        addRow() {
            if (this.referenceRange.typeValue <= 1) {
                if (this.referenceRange.typeValue === 0) {
                    toast.fire({
                        icon: 'warning',
                        title: 'Seleccione tipo de valor de referencia'
                    })
                }
            } else {
                if (this.checkAllValidateState) {
                    this.rangesForm++
                    this.referenceRange.validateState.push(false)
                    this.referenceRange.id.push(null)
                } else {
                    toast.fire({
                        icon: 'warning',
                        title:
                            'Antes de agregar un nuevo valor, valide el rango en edición'
                    })
                }
            }
        },
        getRow(n) {
            this.currentValue = n
        },
        validate(n) {
            const ageStart = document.getElementById('ageStart' + n)
            const ageEnd = document.getElementById('ageEnd' + n)
            const ageUnit = document.getElementById('ageUnit' + n)
            const gender = document.getElementById('gender' + n)

            if (
                ageStart.value === '' ||
                ageEnd.value === '' ||
                ageUnit.value === 0 ||
                gender.value === 0
            ) {
                toast.fire({
                    icon: 'warning',
                    title: 'Falta información de valor de referencia'
                })
            } else {
                this.getRow(n)
                ageStart.readOnly = true
                ageEnd.readOnly = true
                ageUnit.disabled = true
                gender.disabled = true

                if (this.referenceRange.typeValue === 'CUANTITATIVO') {
                    const normalMinimum = document.getElementById(
                        'normalMinimum' + n
                    )
                    const normalMaximum = document.getElementById(
                        'normalMaximum' + n
                    )
                    const criticalMinimum = document.getElementById(
                        'criticalMinimum' + n
                    )
                    const criticalMaximum = document.getElementById(
                        'criticalMaximum' + n
                    )
                    const interpretation = document.getElementById(
                        'interpretation' + n
                    )

                    normalMaximum.readOnly = true
                    normalMinimum.readOnly = true
                    criticalMinimum.readOnly = true
                    criticalMaximum.readOnly = true
                    interpretation.readOnly = true
                } else {
                    const cualitativeValue = document.getElementById(
                        'cualitativeValue' + n
                    )
                    cualitativeValue.readOnly = true
                }

                this.referenceRange.validateState.splice(n, 1, true)
            }
        },
        dValidate(n) {
            this.getRow(n)
            const dVal = false
            const ageStart = document.getElementById('ageStart' + n)
            const ageEnd = document.getElementById('ageEnd' + n)
            const ageUnit = document.getElementById('ageUnit' + n)
            const gender = document.getElementById('gender' + n)

            ageStart.readOnly = dVal
            ageEnd.readOnly = dVal
            ageUnit.disabled = dVal
            gender.disabled = dVal

            if (this.referenceRange.typeValue === 'CUANTITATIVO') {
                const normalMinimum = document.getElementById(
                    'normalMinimum' + n
                )
                const normalMaximum = document.getElementById(
                    'normalMaximum' + n
                )
                const criticalMinimum = document.getElementById(
                    'criticalMinimum' + n
                )
                const criticalMaximum = document.getElementById(
                    'criticalMaximum' + n
                )
                const interpretation = document.getElementById(
                    'interpretation' + n
                )

                normalMaximum.readOnly = dVal
                normalMinimum.readOnly = dVal
                criticalMinimum.readOnly = dVal
                criticalMaximum.readOnly = dVal
                interpretation.readOnly = dVal
            } else {
                const cualitativeValue = document.getElementById(
                    'cualitativeValue' + n
                )
                cualitativeValue.readOnly = dVal
            }

            this.referenceRange.validateState.splice(
                this.currentValue,
                1,
                false
            )
        },
        destroyRow(n) {
            if (
                this.referenceRange.id[n] !== undefined &&
                this.referenceRange.id[n] !== null
            ) {
                this.referenceRangeDestroyed.push(this.referenceRange.id[n])
            }

            this.referenceRange.ageUnit.splice(n, 1)
            this.referenceRange.gender.splice(n, 1)
            this.referenceRange.ageStart.splice(n, 1)
            this.referenceRange.ageEnd.splice(n, 1)
            this.referenceRange.validateState.splice(n, 1)
            this.referenceRange.id.splice(n, 1)

            this.referenceRange.normalMinimum.splice(n, 1)
            this.referenceRange.normalMaximum.splice(n, 1)
            this.referenceRange.criticalMinimum.splice(n, 1)
            this.referenceRange.criticalMaximum.splice(n, 1)
            this.referenceRange.interpretation.splice(n, 1)

            this.referenceRange.cualitativeValue.splice(n, 1)

            if (this.rangesForm !== 0) {
                this.rangesForm--
            }
        },
        backTab() {
            this.formCount--
        },
        currentPage(event, page) {
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
        async save() {
            if (this.validateInput() && this.checkAllValidateState) {
                const params = {
                    loinc_id: this.test.loincTest.id,
                    description: this.test.description,
                    infinity_test_id: this.test.LISTest.id,
                    method_id: this.test.method.id,
                    unit_id: this.test.unit.id,
                    state_id: this.test.state.id
                }
                const response = await axios.post('/api/test', params)

                const test = response.data.test
                const count = this.referenceRange.validateState.length

                console.log(test)

                for (let i = 0; i < count; i++) {
                    if (this.referenceRange.typeValue === 'CUANTITATIVO') {
                        let params = {
                            test_id: test.id,
                            type_value: this.referenceRange.typeValue,
                            gender_id: this.referenceRange.gender[i],
                            age_unit_id: this.referenceRange.ageUnit[i],
                            age_start: this.referenceRange.ageStart[i],
                            age_end: this.referenceRange.ageEnd[i],
                            normal_minimum: this.referenceRange.normalMinimum[
                                i
                            ],
                            normal_maximum: this.referenceRange.normalMaximum[
                                i
                            ],
                            critical_minimum: this.referenceRange
                                .criticalMinimum[i],
                            critical_maximum: this.referenceRange
                                .criticalMaximum[i],
                            interpretation: this.referenceRange.interpretation[
                                i
                            ],
                            state_id: 1
                        }

                        const response = await axios.post(
                            '/api/referenceRange',
                            params
                        )
                    } else if (
                        this.referenceRange.typeValue === 'CUALITATIVO'
                    ) {
                        let params = {
                            test_id: test.id,
                            type_value: this.referenceRange.typeValue,
                            gender_id: this.referenceRange.gender[i],
                            age_unit_id: this.referenceRange.ageUnit[i],
                            age_start: this.referenceRange.ageStart[i],
                            age_end: this.referenceRange.ageEnd[i],
                            cualitative_value: this.referenceRange
                                .cualitativeValue[i],
                            state_id: 1
                        }

                        const response = await axios.post(
                            '/api/referenceRange',
                            params
                        )
                    }
                }

                toast.fire({
                    icon: 'success',
                    title: 'Registro creado exitosamente'
                })

                this.tests.push(test)
                this.createRegister = false
                this.resetForm()
            } else {
                toast.fire({
                    icon: 'warning',
                    title: 'Valide los valores de referencia antes de editar'
                })
            }
        },
        async edit() {
            if (this.validateInput() && this.checkAllValidateState) {
                const params = {
                    loinc_id: this.test.loincTest.id,
                    description: this.test.description,
                    infinity_test_id: this.test.LISTest.id,
                    method_id: this.test.method.id,
                    unit_id: this.test.unit.id,
                    state_id: this.test.state.id
                }

                const response = await axios.put(
                    `/api/test/${this.test.id}`,
                    params
                )

                if (response.status === 200) {
                    const test = response.data.test
                    const count = this.referenceRange.validateState.length

                    if (this.referenceRangeDestroyed.length > 0) {
                        for (
                            let i = 0;
                            i < this.referenceRangeDestroyed.length;
                            i++
                        ) {
                            const deleteReferenceRange = await axios.delete(
                                `/api/referenceRange/${this.referenceRangeDestroyed[i]}`
                            )
                        }
                    }

                    for (let i = 0; i < count; i++) {
                        if (this.referenceRange.typeValue === 'CUANTITATIVO') {
                            let params = {
                                test_id: this.test.id,
                                type_value: this.referenceRange.typeValue,
                                gender_id: this.referenceRange.gender[i],
                                age_unit_id: this.referenceRange.ageUnit[i],
                                age_start: this.referenceRange.ageStart[i],
                                age_end: this.referenceRange.ageEnd[i],
                                normal_minimum: this.referenceRange
                                    .normalMinimum[i],
                                normal_maximum: this.referenceRange
                                    .normalMaximum[i],
                                critical_minimum: this.referenceRange
                                    .criticalMinimum[i],
                                critical_maximum: this.referenceRange
                                    .criticalMaximum[i],
                                interpretation: this.referenceRange
                                    .interpretation[i],
                                state_id: 1
                            }

                            if (
                                this.referenceRange.id[i] === undefined ||
                                this.referenceRange.id[i] === null
                            ) {
                                const response = await axios.post(
                                    '/api/referenceRange',
                                    params
                                )
                            } else {
                                const response = await axios.patch(
                                    `/api/referenceRange/${this.referenceRange.id[i]}`,
                                    params
                                )
                            }
                        } else if (
                            this.referenceRange.typeValue === 'CUALITATIVO'
                        ) {
                            let params = {
                                test_id: this.test.id,
                                type_value: this.referenceRange.typeValue,
                                gender_id: this.referenceRange.gender[i],
                                age_unit_id: this.referenceRange.ageUnit[i],
                                age_start: this.referenceRange.ageStart[i],
                                age_end: this.referenceRange.ageEnd[i],
                                cualitative_value: this.referenceRange
                                    .cualitativeValue[i],
                                state_id: 1
                            }

                            console.log('edit reference cuali', params)
                            console.log(this.referenceRange)

                            if (
                                this.referenceRange.id[i] === undefined ||
                                this.referenceRange.id[i] === null
                            ) {
                                const response = await axios.post(
                                    '/api/referenceRange',
                                    params
                                )
                            } else {
                                const response = await axios.patch(
                                    `/api/referenceRange/${this.referenceRange.id[i]}`,
                                    params
                                )
                            }
                        }
                    }

                    toast.fire({
                        icon: 'success',
                        title: 'El registro ha sido editado exitosamente'
                    })

                    const index = this.tests.findIndex(
                        find => find.id === response.data.test.id
                    )

                    this.tests.splice(index, 1, response.data.test)

                    this.resetForm()
                } else {
                    toast.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error. Contacte al administrador'
                    })
                }
            } else {
                toast.fire({
                    icon: 'warning',
                    title: 'Valide los valores de referencia antes de editar'
                })
            }
        },
        cancelCreate() {
            this.createRegister = false
            this.editing = false
            this.resetForm()
        },
        resetForm() {
            this.test = {
                id: '',
                description: '',
                loincTest: {
                    id: '',
                    code: '',
                    name: '',
                    sample: ''
                },
                LISTest: {
                    id: 0,
                    code: '',
                    description: ''
                },
                method: {
                    id: 0,
                    description: ''
                },
                unit: {
                    id: 0,
                    description: ''
                },
                state: {
                    id: 0,
                    description: ''
                }
            }
            this.referenceRange = {
                id: [],
                typeValue: 0,
                ageUnit: [],
                gender: [],
                ageStart: [],
                ageEnd: [],
                normalMinimum: [],
                normalMaximum: [],
                criticalMinimum: [],
                criticalMaximum: [],
                cualitativeValue: [],
                interpretation: [],
                validateState: []
            }

            this.currentValue = 1
            this.isActive = false
            this.rangesForm = 0
            this.id = 0
            this.loinc_code = ''
            this.search_item = ''
            this.editing = false
            this.createRegister = false
            this.formContent = false
            this.formCount = 0
            this.createItem = false
            this.referenceRangeDestroyed = []
        },
        validateInput() {
            if (
                this.test.description === '' ||
                this.test.loincTest.name === '' ||
                this.test.LISTest.id === 0 ||
                this.test.method === 0 ||
                this.test.unit === 0
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
        validateInputLoincData() {
            if (this.test.loincTest.name === '') {
                toast.fire({
                    icon: 'error',
                    title: 'Ingresa un código LOINC válido'
                })

                return false
            } else {
                this.formCount++
                return true
            }
        },
        validateInputGeneralData() {
            if (
                this.test.description === '' ||
                this.test.LISTest.id === 0 ||
                this.test.method.id === 0 ||
                this.test.unit.id === 0 ||
                this.test.state.id === 0
            ) {
                toast.fire({
                    icon: 'error',
                    title: 'Tienes campos sin información'
                })
                return false
            } else {
                this.formCount++
                return true
            }
        },
        async setEdit(test) {
            this.editing = true

            this.id = test.id
            this.test.id = test.id
            this.test.description = test.description
            this.test.LISTest.id = test.infinity_test.id
            this.test.method.id = test.method.id
            this.test.unit.id = test.unit.id
            this.test.state.id = test.state.id
            this.loinc_code = test.loinc.loinc_num
            this.test.loincTest.id = test.loinc.id
            this.test.loincTest.name = test.loinc.long_common_name
            this.test.loincTest.sample = test.loinc.system_
            this.test.loincTest.code = test.loinc.loinc_num

            const respReferenceRange = await axios.get(
                `/api/referenceRange/findByTest/${test.id}`
            )

            const referenceRange = respReferenceRange.data.referenceRangeByTest

            if (referenceRange.length !== 0) {
                this.referenceRange.typeValue = referenceRange[0].type_value
                this.rangesForm = referenceRange.length

                for (let i = 0; i < referenceRange.length; i++) {
                    this.referenceRange.id[i] = referenceRange[i].id
                    this.referenceRange.ageUnit[i] =
                        referenceRange[i].age_unit.id
                    this.referenceRange.gender[i] = referenceRange[i].gender.id
                    this.referenceRange.ageStart[i] =
                        referenceRange[i].age_start
                    this.referenceRange.ageEnd[i] = referenceRange[i].age_end
                    this.referenceRange.validateState[i] = false
                    if (referenceRange[i].type_value === 'CUANTITATIVO') {
                        this.referenceRange.normalMinimum[i] =
                            referenceRange[i].normal_minimum
                        this.referenceRange.normalMaximum[i] =
                            referenceRange[i].normal_maximum
                        this.referenceRange.criticalMinimum[i] =
                            referenceRange[i].critical_minimum
                        this.referenceRange.criticalMaximum[i] =
                            referenceRange[i].critical_maximum
                        this.referenceRange.interpretation[i] =
                            referenceRange[i].interpretation

                        this.referenceRange.cualitativeValue[i] = ''
                    } else {
                        this.referenceRange.cualitativeValue[i] =
                            referenceRange[i].cualitative_value
                        this.referenceRange.normalMinimum[i] = ''
                        this.referenceRange.normalMaximum[i] = ''
                        this.referenceRange.criticalMinimum[i] = ''
                        this.referenceRange.criticalMaximum[i] = ''
                        this.referenceRange.interpretation[i] = ''
                    }
                }
            }

            this.formContent = true
        },
        async destroy(test, index) {
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
                console.log(test)

                try {
                    const respReferenceRange = await axios.get(
                        `/api/referenceRange/findByTest/${test.id}`
                    )

                    for (
                        let i = 0;
                        i < respReferenceRange.data.referenceRangeByTest.length;
                        i++
                    ) {
                        const deleteReferenceRange = await axios.delete(
                            `/api/referenceRange/${respReferenceRange.data.referenceRangeByTest[i].id}`
                        )
                    }

                    const responseDelete = await axios.delete(
                        `/api/test/${test.id}`
                    )

                    toast.fire({
                        icon: 'success',
                        title: 'Registro eliminado exitosamente'
                    })
                    const response = this.tests.filter(function(obj) {
                        if (obj.id !== test.id) {
                            return obj
                        }
                    })

                    this.tests = response
                } catch (e) {
                    console.log(e)
                    toast.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error'
                    })
                }
            }
        },
        getTests() {
            fetch('/api/test')
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    this.tests = json.tests
                    this.contentReady = true
                })
                .catch(error => console.log(error))
        },
        getStates() {
            fetch('/api/state')
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    const res = json.states.map(function(obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    console.log(res)
                    this.collections.states = res
                })
                .catch(error => console.log(error))
        },
        async getAgeUnit() {
            try {
                let response = await fetch('/api/ageUnit')
                let json = await response.json()
                this.collections.ageUnits = this.parseSelect(json.ageUnits)
            } catch (error) {
                console.log(error)
            }
        },
        async getGenders() {
            try {
                let response = await fetch('/api/gender')

                let json = await response.json()

                this.collections.genders = this.parseSelect(json.genders)
            } catch (error) {
                console.log(error)
            }
        },
        getUnits() {
            fetch('/api/unit')
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    const res = json.units.map(function(obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    this.collections.units = res
                })
                .catch(error => console.log(error))
        },
        getInfinityTests() {
            fetch('/api/infinityTest')
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    let res = json.infinityTests.map(function(obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.code + ' - ' + obj.description
                        return newObj
                    })

                    this.collections.LISTests = res
                })
                .catch(error => {
                    console.log(error.message)
                })
        },
        getMethods() {
            fetch('/api/method')
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('Error en el backend')
                    }
                })
                .then(json => {
                    const res = json.methods.map(function(obj) {
                        let newObj = {}
                        newObj['id'] = obj.id
                        newObj['text'] = obj.description

                        return newObj
                    })
                    this.collections.methods = res
                })
                .catch(error => console.log(error.message))
        },
        search_loinc() {
            fetch(`/api/loinc/${this.loinc_code}`)
                .then(res => {
                    if (res.ok) {
                        return res.json()
                    } else {
                        throw Error('No se encuentra el código')
                    }
                })
                .then(json => {
                    this.test.loincTest.name = json.long_common_name
                    this.test.loincTest.sample = json.system_
                    this.test.loincTest.id = json.id
                })
                .catch(error => {
                    toast.fire({
                        icon: 'error',
                        title: 'Código LOINC no encontrado'
                    })
                })
        },
        setFormContent() {
            this.formContent = true
        },
        parseSelect: function(array) {
            const res = array.map(function(obj) {
                return {
                    id: obj.id,
                    text: obj.description
                }
            })
            return res
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

.form-lenght-input {
    width: 4em;
}
</style>
