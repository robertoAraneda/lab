<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//API ROUTES
//Route::get('/api/section', function () {return new SectionCollection(Section::orderBy('id')->with('state_id')->with('created_user_id')->with('updated_user_id')->get());});
//Route::get('api/state', function(){ return new StateCollection(State::orderBy('description')->get());});
//Route::get('api/user', function(){return new UserCollection(User::orderBy('id')->get());});
//Route::get('api/workarea', function (){
//    return new WorkareaCollection(Workarea::orderBy('description')
//        ->with('state_id')
//        ->with('created_user_id')
//        ->with('updated_user_id')
//        ->with('section_id')
//        ->with('chief_user_id')
//        ->get()
//    );
//});

//Routes view
Route::get('/home', 'HomeController@index')->name('home');
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
Route::get('/user/infinity', function(){return view('user.infinityTest');})->name('user.infinityTest');
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
Route::get('/search/advanced/{id}', 'SearchTestController@detailPage')->name('detail');
Route::get('/admin/indication', 'IndicationController@page')->name('admin.indication');
Route::get('/admin/medicalOrder', 'MedicalOrderController@page')->name('admin.medicalOrder');
Route::get('/admin/timeResponse', 'TimeResponseController@page')->name('admin.timeResponse');
Route::get('/admin/analyteIndication', 'AnalyteIndicationController@page')->name('admin.analyteIndication');


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
Route::apiResource('/api/analyteLabel', 'AnalyteLabelController')->names('api.analyteLabel');
Route::apiResource('/api/analyteSampleContainer', 'MainAnalyteSampleContainerController')->names('api.analyteSampleContainer');
Route::apiResource('/api/sampleCollectionMethod', 'SampleCollectionMethodController')->names('api.sampleCollectionMethod');
Route::apiResource('/api/indication', 'IndicationController')->names('api.indication');
Route::apiResource('/api/medicalOrder', 'MedicalOrderController')->names('api.medicalOrder');
Route::apiResource('/api/timeResponse', 'TimeResponseController')->names('api.timeResponse');
Route::apiREsource('/api/analyteIndication', 'AnalyteIndicationController')->names('api.analyteIndication');


//custom routes
Route::get('/api/infinityGroup/collection/{id}', 'InfinityGroupController@findBySupergroup');
Route::get('/api/infinityRelGroupTest/collection/{id}', 'InfinityRelGroupTestController@findByGroup');
Route::get('/api/analyteTestGroup', 'AnalyteTestsController@agregateData');
Route::get('/api/analyteSampleContainer/findByAnalyte/{id}', 'MainAnalyteSampleContainerController@findByAnalyte');
Route::get('/api/referenceRange/findByTest/{id}', 'ReferenceRangeController@findByTest');
Route::get('/api/search-word/{id}', 'SearchTestController@getAnalyteByName');
Route::get('/api/search-letter/{id}', 'SearchTestController@getAnalyteByFirstLetter');
Route::get('/api/search-workarea/{id}', 'SearchTestController@getAnalyteByWorkarea');

