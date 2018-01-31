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
    Route::get('mating_record', ['as' => 'farm.pig.mating_record', 'uses' => 'FarmController@getMatingRecordPage']);
    Route::post('get_mating_record', ['as' => 'farm.pig.get_mating_record', 'uses' => 'FarmController@addMatingRecord']);
    Route::get('add_sowlitter_record', ['as' => 'farm.pig.add_sowlitter_record', 'uses' => 'FarmController@getAddSowLitterRecordPage']);
    //Route::post('add_offspring', ['as' => 'farm.pig.add_offspring', 'uses' => 'FarmController@addOffspring']);
    Route::post('get_sowlitter_record', ['as' => 'farm.pig.get_sowlitter_record', 'uses' => 'FarmController@addSowlitterRecord']);
    Route::get('animal_record', ['as' => 'farm.pig.animal_record', 'uses' => 'FarmController@getAnimalRecordPage']);
    Route::get('sow_record/{id}', ['as' => 'farm.pig.sow_record_page', 'uses' => 'FarmController@getSowRecordPage']);
    Route::post('fetch_sow_record_id', ['as' => 'farm.pig.fetch_sow_record_id', 'uses' => 'FarmController@fetchSowRecord']);
    Route::get('boar_record/{id}', ['as' => 'farm.pig.boar_record_page', 'uses' => 'FarmController@getBoarRecordPage']);
    Route::post('fetch_boar_record_id', ['as' => 'farm.pig.fetch_boar_record_id', 'uses' => 'FarmController@fetchBoarRecord']);
    Route::get('mortality_and_sales', ['as' => 'farm.pig.mortality_and_sales', 'uses' => 'FarmController@getMortalityAndSalesPage']);
    // Route::get('mortality_record', ['as' => 'farm.pig.mortality_record', 'uses' => 'FarmController@getMortalityRecordPage']);
    Route::post('get_mortality_record', ['as' => 'farm.pig.get_mortality_record', 'uses' => 'FarmController@addMortalityRecord']);
    // Route::get('sales_record', ['as' => 'farm.pig.sales_record', 'uses' => 'FarmController@getSalesRecordPage']);
    Route::post('get_sales_record', ['as' => 'farm.pig.get_sales_record', 'uses' => 'FarmController@addSalesRecord']);
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
