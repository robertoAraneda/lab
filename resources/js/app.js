require('./bootstrap')

window.Vue = require('vue')
import Vuetify from 'vuetify'
import es from 'vuetify/es5/locale/es'

//support vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from './store/index'

const store = new Vuex.Store(storeData)

Vue.use(Vuetify)

window.swal = require('sweetalert2')

const toast = swal.mixin({
    toast: true,
    showConfirmButton: false,
    timer: 3000,
    position: 'top-end'
})

window.toast = toast

Vue.use(Vuex)

Vue.component(
    'select2',
    require('./components/partials/Select2Component').default
)

Vue.component(
    'table-component',
    require('./components/TableSectionComponent.vue').default
)
Vue.component(
    'table-state-component',
    require('./components/TableStateComponent').default
)
Vue.component(
    'workarea-component',
    require('./components/WorkareaComponent').default
)
Vue.component('test-table', require('./components/TestTable').default)
Vue.component(
    'sample-component',
    require('./components/SampleComponent').default
)
Vue.component(
    'collection-method-component',
    require('./components/CollectionMethodComponent').default
)
Vue.component(
    'container-component',
    require('./components/ContainerComponent').default
)
Vue.component(
    'main-analyte-component',
    require('./components/MainAnalyteComponent').default
)
Vue.component('label-component', require('./components/LabelComponent').default)
Vue.component('loinc-component', require('./components/LoincComponent').default)
Vue.component(
    'infinity-supergroup-component',
    require('./components/InfinitySupergroupComponent').default
)
Vue.component(
    'infinity-sample-component',
    require('./components/InfinitySampleComponent').default
)
Vue.component(
    'infinity-type-tube-component',
    require('./components/InfinityTypeTubeComponent').default
)
Vue.component(
    'infinity-test-component',
    require('./components/InfinityTestComponent').default
)
Vue.component(
    'infinity-group-component',
    require('./components/InfinityGroupComponent').default
)
Vue.component(
    'infinity-rel-supergroup-test-component',
    require('./components/InfinityRelGroupTestComponent').default
)
Vue.component(
    'hca-laboratory-component',
    require('./components/HcaLaboratoryComponent').default
)
Vue.component(
    'available-component',
    require('./components/AvailableComponent').default
)
Vue.component(
    'vih-key-component',
    require('./components/VihKeyComponent').default
)
Vue.component(
    'fonasa-test-component',
    require('./components/FonasaTestComponent').default
)
Vue.component(
    'method-component',
    require('./components/MethodComponent').default
)
Vue.component(
    'time-process-component',
    require('./components/TimeProcessComponent').default
)
Vue.component(
    'infinity-labdate-component',
    require('./components/InfinityLabdateComponent').default
)
Vue.component(
    'time-reception-component',
    require('./components/TimeReceptionComponent').default
)
Vue.component(
    'analyte-component',
    require('./components/AnalyteComponent').default
)
Vue.component(
    'view-user-infinity-test-component',
    require('./components/ViewUserInfinityTest').default
)
Vue.component('unit-component', require('./components/UnitComponent').default)
Vue.component('test-component', require('./components/TestComponent').default)
Vue.component(
    'rel-analyte-test-component',
    require('./components/RelAnalyteTestComponent').default
)
Vue.component(
    'gender-component',
    require('./components/GenderComponent').default
)
Vue.component(
    'age-unit-component',
    require('./components/AgeUnitComponent').default
)
Vue.component(
    'reference-range-component',
    require('./components/ReferenceRangeComponent').default
)
Vue.component(
    'main-app-component',
    require('./pages/laboratorio/index').default
)
Vue.component(
    'search-analyte-component',
    require('./pages/laboratorio/searchList').default
)
Vue.component(
    'detail-analyte-component',
    require('./pages/laboratorio/detail').default
)
Vue.component(
    'indication-component',
    require('./components/Indication').default
)
Vue.component(
    'time-response-component',
    require('./components/TimeResponse').default
)
Vue.component(
    'medical-order-component',
    require('./components/MedicalOrder').default
)
Vue.component(
    'verification-analyte-test-component',
    require('./components/VerificationAnalyteTestComponent').default
)
Vue.component(
    'quantity-sample-component',
    require('./components/QuantitySampleComponent').default
)
Vue.component(
    'sample-condition-component',
    require('./components/SampleConditionComponent').default
)

Vue.component(
    'store-category-component',
    require('./pages/store/category').default
)
Vue.component(
    'store-ubication-component',
    require('./pages/store/ubication').default
)

Vue.component(
    'store-presentation-component',
    require('./pages/store/presentation').default
)

Vue.component(
    'store-dashboard-component',
    require('./pages/store/dashboard').default
)

Vue.component(
    'store-product-component',
    require('./pages/store/product').default
)
Vue.component(
    'movement-product-component',
    require('./pages/store/movementProduct').default
)

Vue.component('dashboard-component', require('./components/Dashboard').default)

Vue.component(
    'code-lab-component',
    require('./pages/laboratorio/labcodes.vue').default
)

Vue.component(
    'statistics-covid-component',
    require('./pages/management/statisticsCovid').default
)

Vue.component(
    'upload-file-component',
    require('./pages/management/uploadFile').default
)

Vue.component(
    'export-hhha-component',
    require('./pages/management/downloadReportHHHA').default
)

Vue.component(
    'tracing-laboratory-request-component',
    require('./pages/management/tracingLaboratoryRequest').default
)

Vue.component('mail-test-component', require('./pages/mail/test').default)

const app = new Vue({
    el: '#el',
    store,
    vuetify: new Vuetify({
        lang: {
            locales: { es },
            current: 'es'
        }
    })
})
