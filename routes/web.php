<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::group(['middleware' => ['web']], function () {
  Auth::routes();
  Route::get('/home', 'HomeController@index')->name('home');

  Route::group(['prefix' => 'farm'], function(){
    Route::get('/',['as' => 'farm.index', 'uses' => 'FarmController@index']);

    // Swine Routes
   
    // Route::get('add_sow_record', ['as' => 'farm.pig.add_sow_record', 'uses' => 'FarmController@getAddSowRecordPage']);
    // Route::post('submit_sow_record', ['as' => 'farm.pig.submit_sow_record', 'uses' => 'FarmController@addSowRecord']);
    // Route::get('add_sow_record', ['as' => 'farm.pig.add_sow_record', 'uses' => 'FarmController@getAddSowRecordPage']);
    // Route::get('add_boar_record', ['as' => 'farm.pig.add_boar_record', 'uses' => 'FarmController@getAddBoarRecordPage']);
    // Route::post('submit_boar_record', ['as' => 'farm.pig.submit_boar_record', 'uses' => 'FarmController@addBoarRecord']);
    Route::get('breeding_record', ['as' => 'farm.pig.breeding_record', 'uses' => 'FarmController@getBreedingRecordPage']);
    Route::post('get_breeding_record', ['as' => 'farm.pig.get_breeding_record', 'uses' => 'FarmController@addBreedingRecord']);
    Route::get('sowlitter_record/{id}', ['as' => 'farm.pig.sowlitter_record', 'uses' => 'FarmController@getAddSowLitterRecordPage']);
    //Route::post('add_offspring', ['as' => 'farm.pig.add_offspring', 'uses' => 'FarmController@addOffspring']);
    Route::post('get_sowlitter_record', ['as' => 'farm.pig.get_sowlitter_record', 'uses' => 'FarmController@addSowlitterRecord']);
    Route::get('individual_records', ['as' => 'farm.pig.individual_records', 'uses' => 'FarmController@getAnimalRecordPage']);
    Route::get('add_pig', ['as' => 'farm.pig.add_pig', 'uses' => 'FarmController@getAddPigPage']);
    Route::post('fetch_new_pig', ['as' => 'farm.pig.fetch_new_pig', 'uses' => 'FarmController@fetchNewPigRecord']);
    Route::get('view_sow/{id}', ['as' => 'farm.pig.view_sow', 'uses' => 'FarmController@getViewSowPage']);
    Route::get('view_boar/{id}', ['as' => 'farm.pig.view_boar', 'uses' => 'FarmController@getViewBoarPage']);
    Route::get('gross_morphology/{id}', ['as' => 'farm.pig.gross_morphology_page', 'uses' => 'FarmController@getGrossMorphologyPage']);
    Route::post('fetch_gross_morphology', ['as' => 'farm.pig.fetch_gross_morphology', 'uses' => 'FarmController@fetchGrossMorphology']);
    Route::get('pig_morphometric_characteristics/{id}', ['as' => 'farm.pig.pig_morphometric_characteristics_page', 'uses' => 'FarmController@getMorphometricCharsPage']);
    Route::post('fetch_morphometric_characteristics', ['as' => 'farm.pig.fetch_morphometric_characteristics', 'uses' => 'FarmController@fetchMorphometricCharacteristics']);
    Route::get('weight_records/{id}', ['as' => 'farm.pig.weight_records_page', 'uses' => 'FarmController@getWeightRecordsPage']);
    Route::post('fetch_weight_records', ['as' => 'farm.pig.fetch_weight_records', 'uses' => 'FarmController@fetchWeightRecords']);
    // Route::get('sow_record/{id}', ['as' => 'farm.pig.sow_record_page', 'uses' => 'FarmController@getSowRecordPage']);
    // Route::post('fetch_sow_record_id', ['as' => 'farm.pig.fetch_sow_record_id', 'uses' => 'FarmController@fetchSowRecord'])
    // Route::get('boar_record/{id}', ['as' => 'farm.pig.boar_record_page', 'uses' => 'FarmController@getBoarRecordPage']);
    // Route::post('fetch_boar_record_id', ['as' => 'farm.pig.fetch_boar_record_id', 'uses' => 'FarmController@fetchBoarRecord']);
    Route::get('mortality_and_sales', ['as' => 'farm.pig.mortality_and_sales', 'uses' => 'FarmController@getMortalityAndSalesPage']);
    Route::post('get_mortality_record', ['as' => 'farm.pig.get_mortality_record', 'uses' => 'FarmController@addMortalityRecord']);
    Route::post('get_sales_record', ['as' => 'farm.pig.get_sales_record', 'uses' => 'FarmController@addSalesRecord']);
    Route::post('get_removed_animal_record', ['as' => 'farm.pig.get_removed_animal_record', 'uses' => 'FarmController@addRemovedAnimalRecord']);
    Route::get('farm_profile', ['as' => 'farm.pig.farm_profile', 'uses' => 'FarmController@getFarmProfilePage']);
    Route::post('get_farm_profile', ['as' => 'farm.pig.get_farm_profile', 'uses' => 'FarmController@addFarmProfile']);
    
    // Chicken and Duck Routes
    Route::get('test_page', ['as' => 'farm.test', 'uses' => 'FarmController@getTestPage']);

    Route::get('dashboard', ['as' => 'farm.poultry.dashboard', 'uses' => 'FarmController@getIndex']); // Make as landing page after login when doing backend for Native Chicken
    Route::get('family_record', ['as' => 'farm.poultry.page_family_record', 'uses' => 'FarmController@getPageFamilyRecord']);
    Route::get('add_to_breeder', ['as' => 'farm.poultry.page_add_to_breeder', 'uses' => 'FarmController@getPageAddToBreeder']);
    Route::get('create_family/{id}', ['as' => 'farm.poultry.create_family_id', 'uses' => 'FarmController@createFamily']);
    Route::get('daily_records', ['as' => 'farm.poultry.page_daily_records', 'uses' => 'FarmController@getDailyRecords']);
    Route::get('egg_quality', ['as' => 'farm.poultry.page_egg_quality', 'uses' => 'FarmController@getPageEggQuality']);
    Route::get('hatchery_parameters', ['as' => 'farm.poultry.page_hatchery_parameters', 'uses' => 'FarmController@getPageHatcheryParameter']);
    Route::get('morphometric_characteristics', ['as' => 'farm.poultry.page_morphometric_characteristics', 'uses' => 'FarmController@getPageMorphometricCharacteristic']);
    Route::get('phenotypic_characteristics', ['as' => 'farm.poultry.page_phenotypic_characteristics', 'uses' => 'FarmController@getPagePhenotypicCharacteristic']);

    Route::get('replacement_individual_record', ['as' => 'farm.poultry.page_replacement_individual_record', 'uses' => 'FarmController@getPageReplacementIndividualRecord']);
    Route::post('get_replacement_individual_record', ['as' => 'farm.poultry.get_replacement_individual_record', 'uses' => 'FarmController@addReplacementIndividualRecord']);
    Route::get('replacement_growth_performance', ['as' => 'farm.poultry.page_replacement_growth_performance', 'uses' => 'FarmController@getPageReplacementGrowthPerformance']);
    Route::get('replacement_search_id', ['as' => 'farm.poultry.page_phenomorphosearchid', 'uses' => 'FarmController@getPageSearchID']);
    Route::get('replacement_phenotypic/{id}', ['as' => 'farm.poultry.page_replacement_phenotypic_id', 'uses' => 'FarmController@getPageReplacementPhenotypic']);
    Route::post('fetch_replacement_phenotypic', ['as' => 'farm.poultry.fetch_replacement_phenotypic_id', 'uses' => 'FarmController@fetchDataReplacementPhenotypic']);
    Route::get('replacement_morphometric/{id}', ['as' => 'farm.poultry.page_replacement_morphometric_id', 'uses' => 'FarmController@getPageReplacementMorphometric']);
    Route::post('fetch_replacement_morphometric', ['as' => 'farm.poultry.fetch_replacement_morphometric_id', 'uses' => 'FarmController@fetchDataReplacementMorphometric']);
    Route::post('replacement_search_id_value', ['as' => 'farm.poultry.page_phenomorphosearchid_value', 'uses' => 'FarmController@searchID']);

    Route::get('feeding_records', ['as' => 'farm.poultry.page_feeding_records', 'uses' => 'FarmController@getPageFeedingRecords']);
    Route::get('monthly_sales', ['as' => 'farm.poultry.page_monthly_sales', 'uses' => 'FarmController@getPageMonthlySales']);

    Route::post('fetch_family_record', ['as' => 'farm.chicken.submit_family_record', 'uses' => 'FarmController@getFamilyRecord']);
  });

  // Route::group(['prefix' => 'admin'], function(){
  //   Route::get('/',['as' => 'farm.index', 'uses' => 'AdminController@index']);
  // });

});


// Socialite Routes
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');
