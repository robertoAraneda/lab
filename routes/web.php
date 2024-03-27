<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

//Routes view
Route::get('/', function () {
  return view('welcome');

  // redirect()->away('http://hhha.elabnote.cl');
});
Route::get('/admin/section', 'SectionController@page')->name('section');
Route::get('/admin/user', 'UserController@page')->name('user');
Route::get('/admin/state', 'StateController@page')->name('state');
Route::get('/admin/workarea', 'WorkareaController@page')->name('workarea');
Route::get('/admin/sample', 'SampleController@page')->name('sample');
Route::get('/admin/collectionMethod', 'CollectionMethodController@page')->name('collectionMethod');
Route::get('/admin/container', 'ContainerController@page')->name('container');
Route::get('/admin/mainAnalyte', 'MainAnalyteController@page')->name('mainAnalyte');
Route::get('/admin/label', 'LabelController@page')->name('label');
Route::get('/admin/hcaLaboratory', 'HcaLaboratoryController@page')->name('hcaLaboratory');
Route::get('/admin/fetch', 'LoincController@fetch')->name('loinc.fetch');
Route::get('/admin/loinc', 'LoincController@page')->name('loinc');
Route::get('/admin/infinitySupergroup', 'InfinitySupergroupController@page')->name('infinitySupergroup');
Route::get('/admin/infinitySample', 'InfinitySampleController@page')->name('infinitySample');
Route::get('/admin/infinityTypeTube', 'InfinityTypeTubeController@page')->name('infinityTypeTube');
Route::get('/admin/infinityTest', 'InfinityTestController@page')->name('infinityTest');
Route::get('/admin/infinityGroup', 'InfinityGroupController@page')->name('infinityGroup');
Route::get('/admin/vihkey', 'VihKeyController@page')->name('admin.vihkey');
Route::get('/admin/available', 'AvailableController@page')->name('available');
Route::get('/admin/infinityRelGroupTest', 'InfinityRelGroupTestController@page')->name('infinityRelGroupTest');
Route::get('/admin/infinityRelGroupTest/{id}', 'InfinityRelGroupTestController@fetch');
Route::get('/admin/fonasa', 'FonasaTestController@page')->name('fonasa');
Route::get('/admin/method', 'MethodController@page')->name('method');
Route::get('/admin/timeProcess', 'TimeProcessController@page')->name('timeProcess');
Route::get('/admin/infinityLabdateTest', 'InfinityLabdateTestController@page')->name('infinityLabdateTest');
Route::get('/admin/timeReception', 'TimeReceptionController@page')->name('timeReception');
Route::get('/admin/analyte', 'AnalyteController@page')->name('analyte');
Route::get('/api/loinc/{loinc_code}', 'LoincController@findByCode');
Route::get('/user/infinity', function () {
  return view('user.infinityTest');
})->name('user.infinityTest');
Route::get('/admin/unit', 'UnitController@page')->name('admin.unit');
Route::get('/admin/test', 'TestController@page')->name('admin.test');
Route::get('/admin/analyteTest', 'AnalyteTestsController@page')->name('admin.analyteTest');
Route::get('/admin/gender', 'GenderController@page')->name('admin.gender');
Route::get('/admin/ageUnit', 'AgeUnitController@page')->name('admin.ageUnit');
Route::get('/admin/referenceRange', 'ReferenceRangeController@page')->name('admin.referenceRange');
Route::get('/admin/analyteSampleContainer', 'MainAnalyteSampleContainerController@page')->name('admin.analyteSampleContainer');
Route::get('/admin/sampleCollectionMethod', 'SampleCollectionMethodController@page')->name('admin.sampleCollectionMethod');
Route::get('/search-word/{id}', 'SearchTestController@page')->name('search-word');
Route::get('/search-letter/{id}', 'SearchTestController@pageByLetter')->name('search-letter');
Route::get('/search-workarea/{id}', 'SearchTestController@pageByWorkarea')->name('search-workarea');
Route::get('/search-section/{name}', 'SearchTestController@pageBySection')->name('search-section');
Route::get('/search/advanced/{id}', 'SearchTestController@detailPage')->name('detail');



Route::get('/codigos-laboratorio', 'SearchTestController@codesLabPage');
Route::get('/admin/indication', 'IndicationController@page')->name('admin.indication');
Route::get('/admin/medicalOrder', 'MedicalOrderController@page')->name('admin.medicalOrder');
Route::get('/admin/timeResponse', 'TimeResponseController@page')->name('admin.timeResponse');
Route::get('/admin/analyteIndication', 'AnalyteIndicationController@page')->name('admin.analyteIndication');
Route::get('/admin/quantity-sample', 'QuantitySampleController@page')->name('admin.quantitySample');
Route::get('/admin/verification', function () {
  return view('admin.verificationAnalyteComponent');
})->name('admin.verification');
Route::get('/admin/sampleCondition', 'SampleConditionController@page')->name('admin.sampleCondition');
Route::get('/admin/dashboard', 'DashboardController@page')->name('admin.dashboard');



//routes pages bodega

Route::get('/store/category', 'ControllerStore\CategoryController@page')->name('store.category');
Route::get('/store/ubication', 'ControllerStore\UbicationController@page')->name('store.ubication');
Route::get('/store/product', 'ControllerStore\ProductController@page')->name('store.product');
Route::get('/store/movement-products', 'ControllerStore\MovementProductController@page')->name('store.movementProducts');
Route::get('/store/presentation', 'ControllerStore\PresentationController@page')->name('store.presentation');
Route::get('/store/dashboard', 'ControllerStore\DashboardController@page')->name('store.dashboard');


//routes pages gestión

Route::get('/management/statistic-covid', 'ControllerManagement\StatisticsCovidController@page')->name('management.statisticsCovid');
Route::get('/store/tracing-laboratory-request', 'ControllerManagement\TracingLaboratoryRequest@page')->name('management.tracingLaboratoryRequest');
Route::get('/management/file-input', 'ControllerManagement\UploadFileController@page')->name('management.uploadFile');
Route::get('/management/export-report-hhha', 'ControllerManagement\DownloadFileController@page')->name('management.exportHHHA');


//Routes Api

Route::apiResource('/api/section', 'SectionController')->names('api.section');
Route::apiResource('/api/user', 'UserController')->names('api.user');
Route::apiResource('/api/state', 'StateController')->names('api.state');
Route::apiResource('/api/workarea', 'WorkareaController')->names('api.workarea');
Route::apiResource('/api/sample', 'SampleController')->names('api.sample');
Route::apiResource('/api/collectionMethod', 'CollectionMethodController')->names('api.collectionMethod');
Route::apiResource('/api/container', 'ContainerController')->names('api.container');
Route::apiResource('/api/mainAnalyte', 'MainAnalyteController')->names('api.mainAnalyte');
Route::apiResource('/api/label', 'LabelController')->names('api.label');
Route::apiResource('/api/hcaLaboratory', 'HcaLaboratoryController')->names('api.hcaLaboratory');
Route::apiResource('/api/infinitySupergroup', 'InfinitySupergroupController')->names('api.infinitySupergroup');
Route::apiResource('/api/infinitySample', 'InfinitySampleController')->names('api.infinitySample');
Route::apiResource('/api/infinityTypeTube', 'InfinityTypeTubeController')->names('api.infinityTypeTube');
Route::apiResource('/api/infinityTest', 'InfinityTestController')->names('api.infinityTest');
Route::apiResource('/api/infinityGroup', 'InfinityGroupController')->names('api.infinityGroup');
Route::apiResource('/api/infinityRelGroupTest', 'InfinityRelGroupTestController')->names('api.infinityRelGroupTest');
Route::apiResource('/api/vihkey', 'VihKeyController')->names('api.vihkey');
Route::apiResource('/api/available', 'AvailableController')->names('api.available');
Route::apiResource('/api/fonasa', 'FonasaTestController')->names('api.fonasa');
Route::apiResource('/api/method', 'MethodController')->names('api.method');
Route::apiResource('/api/timeProcess', 'TimeProcessController')->names('api.timeProcess');
Route::apiResource('/api/infinityLabdateTest', 'InfinityLabdateTestController')->names('api.infinityLabdateTest');
Route::apiResource('/api/timeReception', 'TimeReceptionController')->names('api.timeReception');
Route::apiResource('/api/analyte', 'AnalyteController')->names('api.analyte');
Route::apiResource('/api/unit', 'UnitController')->names('api.unit');
Route::apiResource('/api/test', 'TestController')->names('api.test');
Route::apiResource('/api/analyteTest', 'AnalyteTestsController')->names('api.analyteTest');
Route::apiResource('/api/gender', 'GenderController')->names('api.gender');
Route::apiResource('/api/ageUnit', 'AgeUnitController')->names('api.ageUnit');
Route::apiResource('/api/referenceRange', 'ReferenceRangeController')->names('api.referenceRange');
Route::apiResource('/api/criticalRange', 'CriticalRangeController')->names('api.criticalRange');
Route::apiResource('/api/analyteLabel', 'AnalyteLabelController')->names('api.analyteLabel');
Route::apiResource('/api/analyteSampleContainer', 'MainAnalyteSampleContainerController')->names('api.analyteSampleContainer');
Route::apiResource('/api/sampleCollectionMethod', 'SampleCollectionMethodController')->names('api.sampleCollectionMethod');
Route::apiResource('/api/indication', 'IndicationController')->names('api.indication');
Route::apiResource('/api/medicalOrder', 'MedicalOrderController')->names('api.medicalOrder');
Route::apiResource('/api/timeResponse', 'TimeResponseController')->names('api.timeResponse');
Route::apiResource('/api/analyteIndication', 'AnalyteIndicationController')->names('api.analyteIndication');
Route::apiResource('/api/quantity-sample', 'QuantitySampleController')->names('api.quantitySample');
Route::apiResource('/api/sampleCondition', 'SampleConditionController')->names('api.sampleCondition');
Route::apiResource('/api/analyteSampleCondition', 'AnalyteSampleConditionController')->names('api.analyteSampleCondition');

Route::apiResource('/api/timeResponseDetail', 'TimeResponseAnalyteDetailController')->names('api.timeResponseAnalyteDetail');


//custom routes
Route::get('/api/infinityGroup/collection/{id}', 'InfinityGroupController@findBySupergroup');
Route::get('/api/infinityRelGroupTest/collection/{id}', 'InfinityRelGroupTestController@findByGroup');
Route::get('/api/analyteTestGroup', 'AnalyteTestsController@agregateData');
Route::get('/api/analyteSampleContainer/findByAnalyte/{id}', 'MainAnalyteSampleContainerController@findByAnalyte');
Route::get('/api/referenceRange/findByTest/{id}', 'ReferenceRangeController@findByTest');
Route::get('/api/criticalRange/findByTest/{id}', 'CriticalRangeController@findByTest');
Route::get('/api/search-word/{id}', 'SearchTestController@getAnalyteByName');
Route::get('/api/search-letter/{id}', 'SearchTestController@getAnalyteByFirstLetter');
Route::get('/api/search-workarea/{id}', 'SearchTestController@getAnalyteByWorkarea');

//Route::get('/api/analyte/{idAnalyte}/timeResponseDetail')

Route::get('/api/analytes/all', 'SearchTestController@getAllAnalyte');

//custom post routes

Route::put('/api/analyte/check/{id}', 'AnalyteController@updateChecked');


//api bodega

Route::apiResource('/api/store/categories', 'ControllerStore\CategoryController')->names('api.store.categories');
Route::apiResource('/api/store/ubications', 'ControllerStore\UbicationController')->names('api.store.ubications');
Route::apiResource('/api/store/products', 'ControllerStore\ProductController')->names('api.store.products');
Route::apiResource('/api/store/movement-products', 'ControllerStore\MovementProductController')->names('api.store.movementProducts');
Route::apiResource('/api/store/presentations', 'ControllerStore\PresentationController')->names('api.store.presentations');
Route::get('/api/store/download-file-product', 'ControllerStore\ProductController@export');
Route::get('/api/store/download-file-movement', 'ControllerStore\MovementProductController@export');


//estadisticas bodega


//api management

Route::post('/api/management/upload-file', 'ControllerManagement\UploadFileController@fileSubmit');
Route::get('/api/management/download-file', 'ControllerManagement\DownloadFileController@export');
Route::get('/api/management/download-file-presidency', 'ControllerManagement\DownloadFileController@exportPresidency');
Route::get('/api/management/agregate-data', 'ControllerManagement\StatisticsCovidController@agregateData');
Route::get('/api/management/get-in-process-request', 'ControllerManagement\TracingLaboratoryRequest@getInProcessRequest');
Route::get('/api/management/received-request', 'ControllerManagement\TracingLaboratoryRequest@getReceivedRequest');
Route::get('/api/management/all-request', 'ControllerManagement\FollowResultDayController@getAllRequestSamples');
Route::get('/api/management/latest-file', 'ControllerManagement\UploadHistoryController@index');
Route::get('/api/management/tat-received-notified/{date}/{time}', 'ControllerManagement\FollowResultDayController@getTATReceivedNotified');
Route::get('/api/management/tat-validated/{date}/{time}', 'ControllerManagement\FollowResultDayController@getTATValidated');
Route::get('/api/management/minsal-details', 'ControllerManagement\MinsalDetailController@index');
Route::put('/api/management/minsal-details/{id}', 'ControllerManagement\MinsalDetailController@update');
Route::get('/api/management/presidency-consolidate', 'ControllerManagement\FollowResultDayController@dailyStatistic');
Route::apiResource('/api/management/presidencies-statistics', 'ControllerManagement\PresidencyConsolidateController');

Route::get('/api/management/statusSamplesByLastFiveDays', 'ControllerManagement\StatisticsCovidController@statusSamplesByLastFiveDays');


Route::get('/api/management/filterBySenderInstitution', 'ControllerManagement\StatisticsCovidController@filterBySenderInstitution');
//mail

Route::get('sendbasicemail', 'MailController@basic_email');
Route::get('sendhtmlemail', 'MailController@html_email');
Route::get('sendattachmentemail', 'MailController@attachment_email');


Route::get('/analytes/download-file', 'DownloadFileController@export');
Route::get('/analytes/download-file-tm', 'DownloadFileController@exportSampleAnalyte');


Route::get('send-mail', 'MailController@covid_mail');
