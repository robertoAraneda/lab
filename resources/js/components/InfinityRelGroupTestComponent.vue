<template>
    <div>
        <div
            v-if="!collections.infinityTests.length"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div v-if="formContent">
                <div class="card mt-2 card-secondary">
                    <div v-if="dmlOperation" class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title m-2">{{ titleCard }}</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-12 col-md-12">
                                    <div class="form-group">
                                        <label v-if="infinityGroupID !== 0"
                                            >GRUPO INFINITY:</label
                                        >
                                        <label v-else>&nbsp;</label>
                                        <select2
                                            name="GRUPO INFINITY: "
                                            :options="computedCollectionGroup"
                                            v-model="infinityGroupID"
                                        ></select2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                Prueba Infinity
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="input-group">
                                                <input
                                                    v-model="
                                                        search_infinityTest
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Buscar prueba"
                                                />
                                                <div class="input-group-append">
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
                                                        addSelectedInfinityTest(
                                                            infinityTest
                                                        )
                                                    "
                                                    v-for="infinityTest in filteredListInfinityTest"
                                                    :key="infinityTest.id"
                                                    type="button"
                                                    class="list-group-item list-group-item-action"
                                                >
                                                    <span class="text-bold ">
                                                        {{ infinityTest.code }}
                                                    </span>
                                                    -
                                                    <span
                                                        >{{
                                                            infinityTest.description
                                                        }}
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                Pruebas seleccionadas:
                                            </h5>
                                            <h5>
                                                <span
                                                    class="badge badge-info float-right"
                                                    >{{
                                                        selectedInfinityTests.length
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
                                                    v-for="selectedInfinityTest in selectedInfinityTests"
                                                    :key="
                                                        selectedInfinityTest.id
                                                    "
                                                    class="col-md-6"
                                                >
                                                    <div class="info-box">
                                                        <div
                                                            class="info-box-content overflow-hidden"
                                                        >
                                                            <span
                                                                class="info-box-number"
                                                                >{{
                                                                    selectedInfinityTest.code
                                                                }}
                                                            </span>
                                                            <span
                                                                class="info-box-text"
                                                            >
                                                                {{
                                                                    selectedInfinityTest.description
                                                                }}
                                                            </span>
                                                        </div>
                                                        <button
                                                            @click.prevent="
                                                                removeSelectedInfinityTest(
                                                                    selectedInfinityTest
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
                        </div>
                        <div class="card-footer bg-white">
                            <button
                                @click.prevent="save"
                                class="btn btn-default float-right ml-2"
                            >
                                Guardar
                            </button>
                            <button
                                @click.prevent="cancelButton"
                                class="btn btn-danger float-right "
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header bg-secondary">
                    <div class="input-group card-title" style="width: 500px;">
                        <h5 v-if="infinitySupergroup.id !== 0">
                            <span class="mt-2">SUPERGRUPO INFINITY:</span>
                        </h5>
                        <h5 v-else><span class="mt-2">&nbsp;</span></h5>
                        <div
                            class="input-group-append ml-2"
                            style="min-width: 300px;"
                        >
                            <select2
                                v-if="infinitySupergroups.length"
                                name="SUPERGRUPO INFINITY: "
                                :options="infinitySupergroups"
                                v-model="infinitySupergroup.id"
                            ></select2>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button
                            v-if="!editing"
                            @click="setFormContent"
                            type="button"
                            class="btn btn-success float-right"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="CREAR REGISTRO"
                        >
                            <i class="fas fa-plus"></i> Agregar/Editar
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
                </div>
                <div v-if="dmlOperation" class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm">
                        <tr>
                            <th scope="col">Código groupo infinity</th>
                            <th scope="col">Descripción groupo infinity</th>
                            <th scope="col">Código prueba infinity</th>
                            <th scope="col">Descripción prueba infinity</th>
                        </tr>
                        <tbody
                            v-for="infinitySGroupTest in setPaginate"
                            :key="infinitySGroupTest.id"
                        >
                            <td>{{ infinitySGroupTest.infinityGroup.code }}</td>
                            <td>
                                {{
                                    infinitySGroupTest.infinityGroup.description
                                }}
                            </td>
                            <td>{{ infinitySGroupTest.infinityTest.code }}</td>
                            <td>
                                {{
                                    infinitySGroupTest.infinityTest.description
                                }}
                            </td>
                        </tbody>
                    </table>
                    <div v-if="!setPaginate.length" class="mt-3 text-center">
                        <h4>
                            <span class="lead text-secondary"
                                >No existen registros</span
                            >
                        </h4>
                    </div>
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

            selectedInfinityTests: [],
            collections: {
                infinityGroups: [],
                infinityTests: [],
                infinitySupergroups: []
            },
            infinityGroup: {
                id: "",
                code: "",
                description: ""
            },
            infinitySupergroup: {
                id: 0,
                description: ""
            },
            infinityTest: {
                id: "",
                description: ""
            },
            collectionGroups: [],
            infinityGroupID: 0,
            editing: false,
            dmlOperation: false,
            search_infinityTest: "",
            titleCard: "",
            formContent: false,
            pages: [],
            page: 1,
            perPage: 10,
            disabledPrev: "disabled",
            disabledNext: "",
            indexSelectedTestCopy: []
        };
    },
    created() {
        this.fetchInfinityTest();
        this.fetchInfinitySupergroup();
        this.fetchInfinityGroup();
    },
    computed: {
        supergroupId() {
            return this.infinitySupergroup.id;
        },
        computedCollectionGroup() {
            return this.collectionGroups.map(group => {
                return {
                    id: group.id,
                    text: `${group.code} - ${group.description}`
                };
            });
        },
        filteredListInfinityTest() {
            return this.collections.infinityTests.filter(infinityTest => {
                return (
                    (infinityTest.description
                        .toLowerCase()
                        .match(this.search_infinityTest.toLowerCase()) ||
                        infinityTest.code
                            .toLowerCase()
                            .match(this.search_infinityTest.toLowerCase())) &&
                    !infinityTest.selected
                );
            });
        },
        infinitySupergroups() {
            return this.collections.infinitySupergroups.map(
                infinitySupergroup => {
                    return {
                        id: infinitySupergroup.id,
                        text: `${infinitySupergroup.description}`
                    };
                }
            );
        },
        infinityGroups() {
            return this.collections.infinityGroups;
        },
        filterData() {
            let filterInfinityTests = [];
            this.infinityGroups.map(infinityGroup => {
                infinityGroup.infinity_tests.forEach(test => {
                    filterInfinityTests.push({
                        infinityTest: test,
                        infinityGroup: infinityGroup
                    });
                });
            });
            return filterInfinityTests;
        },
        setPaginate() {
            return this.paginate(this.filterData);
        },
        from() {
            if (this.page === 1 && this.setPaginate.length === 0) {
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
    watch: {
        infinityGroupID(oldVal, newVal) {
            if (oldVal !== newVal) {
                this.collectionGroups.forEach(infinityGroup => {
                    if (
                        Number.parseInt(this.infinityGroupID) ===
                        infinityGroup.id
                    ) {
                        this.selectedInfinityTests =
                            infinityGroup.infinity_tests;
                        this.removeSelectedTest(this.indexSelectedTestCopy);
                        this.indexSelectedTestCopy = [];
                        this.selectedInfinityTests.forEach(test =>
                            this.indexSelectedTestCopy.push(test.id)
                        );
                        this.setInitialSelectedTest(this.indexSelectedTestCopy);
                    }
                });
            }
        },
        supergroupId(oldVal, newVal) {
            if (oldVal !== newVal) {
                this.collections.infinitySupergroups.filter(
                    infinitySupergroup => {
                        if (
                            Number.parseInt(this.infinitySupergroup.id) ===
                            infinitySupergroup.id
                        ) {
                            this.collections.infinityGroups =
                                infinitySupergroup.infinity_groups;
                        }
                    }
                );
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
    methods: {
        addSelectedInfinityTest: function(infinityTest) {
            infinityTest.selected = true;

            this.selectedInfinityTests.push(infinityTest);
            this.indexSelectedTestCopy.push(infinityTest.id);

            this.search_infinityTest = "";
        },
        removeSelectedInfinityTest: function(infinityTest) {
            infinityTest.selected = false;

            const index = this.selectedInfinityTests.findIndex(
                find => find.id === infinityTest.id
            );

            this.selectedInfinityTests.splice(index, 1);
            this.indexSelectedTestCopy.splice(index, 1);
        },
        setInitialSelectedTest(array) {
            array.forEach(element => {
                this.collections.infinityTests.map(test => {
                    if (Number.parseInt(test.id) === Number.parseInt(element)) {
                        test.selected = true;
                    }
                    return test;
                });
            });
        },
        removeSelectedTest(array) {
            array.forEach(element => {
                this.collections.infinityTests.map(test => {
                    if (Number.parseInt(test.id) === Number.parseInt(element)) {
                        test.selected = false;
                    }
                    return test;
                });
            });
        },
        async fetchInfinitySupergroup() {
            try {
                const response = await fetch("/api/infinitySupergroup");

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json();
                    this.collections.infinitySupergroups =
                        json.infinitySupergroups;
                } else {
                    this.showErrorToast(response);
                }
            } catch (error) {
                console.log(error);
                this.showErrorSwal(error);
            }
        },
        async fetchInfinityGroup() {
            try {
                const response = await fetch("/api/infinityGroup");

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json();
                    this.collectionGroups = json.infinityGroups;
                } else {
                    this.showErrorToast(response);
                }
            } catch (error) {
                console.log(error);
                this.showErrorSwal(error);
            }
        },
        async fetchInfinityTest() {
            try {
                const response = await fetch("/api/infinityTest");

                if (response.status >= 200 && response.status < 300) {
                    const json = await response.json();
                    this.collections.infinityTests = json.infinityTests.map(
                        test => {
                            test.selected = false;
                            return test;
                        }
                    );
                } else {
                    this.showErrorToast(response);
                }
            } catch (error) {
                console.log(error);
                this.showErrorSwal(error);
            }
        },
        async save() {
            if (this.infinityGroupID !== 0) {
                this.dmlOperation = true;
                try {
                    const params = {
                        infinity_test_ids: this.indexSelectedTestCopy,
                        infinity_group_id: this.infinityGroupID
                    };

                    const crfToken = document.head.querySelector(
                        'meta[name="csrf-token"]'
                    );
                    const token = crfToken.getAttribute("content");
                    const url = "/api/infinityRelGroupTest";

                    const options = {
                        method: "POST",
                        body: JSON.stringify(params),
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json"
                        }
                    };

                    const postResponse = await fetch(url, options);
                    if (
                        postResponse.status >= 200 &&
                        postResponse.status < 299
                    ) {
                        const json = await postResponse.json();
                        toast.fire({
                            icon: "success",
                            title: "Registro creado con éxito"
                        });
                        this.dmlOperation = false;
                        this.editing = false;
                        this.resetForm();
                    } else {
                        this.showErrorToast(postResponse);
                    }
                } catch (error) {
                    this.showErrorSwal(error);
                }
            } else {
                toast.fire({
                    icon: "warning",
                    title: "Seleccione un grupo"
                });
            }
        },
        resetForm() {
            this.formContent = false;
            this.infinityGroupID = 0;
            this.selectedInfinityTests = [];
            this.indexSelectedTestCopy = [];
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
            const numberOfPages = Math.ceil(
                this.filterData.length / this.perPage
            );
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
        cancelButton() {
            this.editing = false;
            this.resetForm();
        },
        showErrorSwal(error) {
            swal.fire({
                icon: "error",
                title: error.message,
                text: "Error grave. Contacte a desarrollo informático"
            });
        },
        showErrorToast(response) {
            toast.fire({
                icon: "error",
                title: `Error: ${response.status}: ${response.statusText}`
            });
        },
        setFormContent() {
            this.titleCard = "Crear nuevo registro";
            this.formContent = true;
        },
        setInfinityTestSelectedFalse() {
            this.collections.infinityTests.map(infinityTest => {
                infinityTest.selected = false;
                return infinityTest;
            });
        },
        showErrorSwal(error) {
            swal.fire({
                icon: "error",
                title: error.message,
                text: "Error grave. Contacte a desarrollo informático"
            });
        },
        showErrorToast(response) {
            toast.fire({
                icon: "error",
                title: `Error: ${response.status}: ${response.statusText}`
            });
        }
    }
};
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

.badge {
    font-size: 1em;
}

.info-box {
    min-height: 0px;
}
</style>
