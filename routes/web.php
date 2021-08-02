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
Route::get('/breed/q-black', function(){
    return view('qblack');
});
Route::get('/breed/benguet', function(){
    return view('benguet');
});
Route::get('/breed/sinirangan', function(){
    return view('sinirangan');
});
Route::get('/breed/isubela', function(){
    return view('isubela');
});
Route::get('/breed/yookah', function(){
    return view('yookah');
});
Route::get('/breed/marinduke', function(){
    return view('marinduke');
});
Route::get('/coming_soon', function(){
    return view('comingsoon');
});
Route::get('/news/increasing_demand_of_marinduque_native_pigs', function(){
    return view('mscnews1');
});

Route::group(['middleware' => ['web']], function () {
  Auth::routes();
  Route::get('/home', 'FarmController@index')->name('home');

  Route::group(['prefix' => 'farm'], function(){
    Route::get('/',['as' => 'farm.index', 'uses' => 'FarmController@index']);

    // Swine Routes

    Route::get('pedigree', ['as' => 'farm.pig.pedigree', 'uses' => 'FarmController@getPedigreePage']);
    Route::post('find_pig', ['as' => 'farm.pig.find_pig', 'uses' => 'FarmController@findPig']);
    Route::post('get_selected_pig', ['as' => 'farm.pig.get_selected_pig', 'uses' => 'FarmController@selectPig']);
    Route::get('breeding_record', ['as' => 'farm.pig.breeding_record', 'uses' => 'FarmController@getBreedingRecordPage']);
    Route::post('get_breeding_record', ['as' => 'farm.pig.get_breeding_record', 'uses' => 'FarmController@addBreedingRecord']);
    Route::get('edit_breeding_record/{id}', ['as' => 'farm.pig.edit_breeding_record', 'uses' => 'FarmController@getEditBreedingRecordPage']);
    Route::post('update_breeding_record', ['as' => 'farm.pig.update_breeding_record', 'uses' => 'FarmController@editBreedingRecord']);
    Route::post('change_status_bred/{id}', ['as' => 'farm.pig.change_status_bred', 'uses' => 'FarmController@changeStatusFromBred']);
    Route::post('change_status_pregnant/{id}', ['as' => 'farm.pig.change_status_pregnant', 'uses' => 'FarmController@changeStatusFromPregnant']);
    Route::post('add_date_aborted', ['as' => 'farm.pig.add_date_aborted', 'uses' => 'FarmController@addDateAborted']);
    Route::get('sowlitter_record/{id}', ['as' => 'farm.pig.sowlitter_record', 'uses' => 'FarmController@getAddSowLitterRecordPage']);
    Route::post('fetch_date_farrowed/{id}/{datefarrowed}', ['as' => 'farm.pig.fetch_date_farrowed', 'uses' => 'FarmController@fetchDateFarrowedAjax']);
    Route::post('fetch_date_weaned/{id}/{dateweaned}', ['as' => 'farm.pig.fetch_date_weaned', 'uses' => 'FarmController@fetchDateWeanedAjax']);
    Route::post('fetch_parity/{id}/{parity}', ['as' => 'farm.pig.fetch_parity', 'uses' => 'FarmController@fetchParityAjax']);
    Route::post('fetch_stillborn/{id}/{stillborn}', ['as' => 'farm.pig.fetch_stillborn', 'uses' => 'FarmController@fetchStillbornAjax']);
    Route::post('fetch_mummified/{id}/{mummified}', ['as' => 'farm.pig.fetch_mummified', 'uses' => 'FarmController@fetchMummifiedAjax']);
    Route::post('fetch_weighing_option/{id}/{option}', ['as' => 'farm.pig.fetch_weighing_option', 'uses' => 'FarmController@fetchWeighingOptionAjax']);
    Route::post('get_sowlitter_record', ['as' => 'farm.pig.get_sowlitter_record', 'uses' => 'FarmController@addSowlitterRecord']);
    Route::post('add_sowlitter_record_individual', ['as' => 'farm.pig.add_sowlitter_record_individual', 'uses' => 'FarmController@addSowlitterRecordIndividualWeighing']);
    Route::post('add_sowlitter_record_group', ['as' => 'farm.pig.add_sowlitter_record_group', 'uses' => 'FarmController@addSowlitterRecordGroupWeighing']);
    Route::post('edit_id', ['as' => 'farm.pig.edit_id', 'uses' => 'FarmController@editRegistryId']);
    Route::post('edit_sex', ['as' => 'farm.pig.edit_sex', 'uses' => 'FarmController@editSex']);
    Route::post('edit_birth_weight', ['as' => 'farm.pig.edit_birth_weight', 'uses' => 'FarmController@editBirthWeight']);
    Route::post('edit_temporary_registryid', ['as' => 'farm.pig.edit_temporary_registryid', 'uses' => 'FarmController@editTemporaryRegistryId']);
    Route::post('get_weaning_weights', ['as' => 'farm.pig.get_weaning_weights', 'uses' => 'FarmController@addWeaningWeights']);
    Route::post('edit_weaning_weight', ['as' => 'farm.pig.edit_weaning_weight', 'uses' => 'FarmController@editWeaningWeight']);
    Route::get('grower_records', ['as' => 'farm.pig.grower_records', 'uses' => 'FarmController@getGrowerRecordsPage']);
    Route::post('fetch_breeders/{id}', ['as' => 'farm.pig.fetch_breeders', 'uses' => 'FarmController@fetchBreedersAjax']);
    Route::post('change_earnotch_sow', ['as' => 'farm.pig.change_earnotch_sow', 'uses' => 'FarmController@changeEarnotchSow']);
    Route::post('change_earnotch_boar', ['as' => 'farm.pig.change_earnotch_boar', 'uses' => 'FarmController@changeEarnotchBoar']);
    Route::post('make_candidate_breeder/{id}/{status}', ['as' => 'farm.pig.make_candidate_breeder', 'uses' => 'FarmController@makeCandidateBreederAjax']);
    Route::get('view_adg/{id}', ['as' => 'farm.pig.view_adg', 'uses' => 'FarmController@getViewADGPage']);
    Route::get('breeder_records', ['as' => 'farm.pig.breeder_records', 'uses' => 'FarmController@getBreederRecordsPage']);
    Route::post('search_mortality_and_sales', ['as' => 'farm.pig.search_mortality_and_sales', 'uses' => 'FarmController@searchForMortalityAndSales']);
    Route::post('search_breeders', ['as' => 'farm.pig.search_breeders', 'uses' => 'FarmController@searchBreeders']);
    Route::post('search_growers', ['as' => 'farm.pig.search_growers', 'uses' => 'FarmController@searchGrowers']);
    Route::post('search_breeding_record', ['as' => 'farm.pig.search_breeding_record', 'uses' => 'FarmController@searchBreedingRecord']);
    Route::get('add_pig', ['as' => 'farm.pig.add_pig', 'uses' => 'FarmController@getAddPigPage']);
    Route::post('fetch_new_pig', ['as' => 'farm.pig.fetch_new_pig', 'uses' => 'FarmController@fetchNewPigRecord']);
    Route::get('view_sow/{id}', ['as' => 'farm.pig.view_sow', 'uses' => 'FarmController@getViewSowPage']);
    Route::get('view_boar/{id}', ['as' => 'farm.pig.view_boar', 'uses' => 'FarmController@getViewBoarPage']);
    Route::get('gross_morphology/{id}', ['as' => 'farm.pig.gross_morphology_page', 'uses' => 'FarmController@getGrossMorphologyPage']);
    Route::get('edit_gross_morphology/{id}', ['as' => 'farm.pig.edit_gross_morphology_page', 'uses' => 'FarmController@getEditGrossMorphologyPage']);
    Route::post('fetch_gross_morphology', ['as' => 'farm.pig.fetch_gross_morphology', 'uses' => 'FarmController@fetchGrossMorphology']);
    Route::post('update_gross_morphology', ['as' => 'farm.pig.update_gross_morphology', 'uses' => 'FarmController@editGrossMorphology']);
    Route::get('pig_morphometric_characteristics/{id}', ['as' => 'farm.pig.pig_morphometric_characteristics_page', 'uses' => 'FarmController@getMorphometricCharsPage']);
    Route::get('edit_pig_morphometric_characteristics/{id}', ['as' => 'farm.pig.edit_pig_morphometric_characteristics_page', 'uses' => 'FarmController@getEditMorphometricCharsPage']);
    Route::post('fetch_morphometric_characteristics', ['as' => 'farm.pig.fetch_morphometric_characteristics', 'uses' => 'FarmController@fetchMorphometricCharacteristics']);
    Route::post('update_morphometric_characteristics', ['as' => 'farm.pig.update_morphometric_characteristics', 'uses' => 'FarmController@editMorphometricCharacteristics']);
    Route::get('weight_records/{id}', ['as' => 'farm.pig.weight_records_page', 'uses' => 'FarmController@getWeightRecordsPage']);
    Route::get('edit_weight_records/{id}', ['as' => 'farm.pig.edit_weight_records_page', 'uses' => 'FarmController@getEditWeightRecordsPage']);
    Route::post('fetch_weight_records', ['as' => 'farm.pig.fetch_weight_records', 'uses' => 'FarmController@fetchWeightRecords']);
    Route::post('update_weight_records', ['as' => 'farm.pig.update_weight_records', 'uses' => 'FarmController@editWeightRecords']);
    Route::get('mortality_and_sales', ['as' => 'farm.pig.mortality_and_sales', 'uses' => 'FarmController@getMortalityAndSalesPage']);
    Route::post('get_mortality_record', ['as' => 'farm.pig.get_mortality_record', 'uses' => 'FarmController@addMortalityRecord']);
    Route::post('get_sales_record', ['as' => 'farm.pig.get_sales_record', 'uses' => 'FarmController@addSalesRecord']);
    Route::post('get_removed_animal_record', ['as' => 'farm.pig.get_removed_animal_record', 'uses' => 'FarmController@addRemovedAnimalRecord']);
    Route::get('gross_morpho_all_download_pdf', ['as' => 'farm.pig.gross_morpho_all_download_pdf', 'uses' => 'FarmController@grossMorphoAllDownloadPDF']);
    Route::get('gross_morpho_sow_download_pdf', ['as' => 'farm.pig.gross_morpho_sow_download_pdf', 'uses' => 'FarmController@grossMorphoSowDownloadPDF']);
    Route::get('gross_morpho_boar_download_pdf', ['as' => 'farm.pig.gross_morpho_boar_download_pdf', 'uses' => 'FarmController@grossMorphoBoarDownloadPDF']);
    Route::get('morpho_chars_all_download_pdf', ['as' => 'farm.pig.morpho_chars_all_download_pdf', 'uses' => 'FarmController@morphoCharsAllDownloadPDF']);
    Route::get('morpho_chars_sow_download_pdf', ['as' => 'farm.pig.morpho_chars_sow_download_pdf', 'uses' => 'FarmController@morphoCharsSowDownloadPDF']);
    Route::get('morpho_chars_boar_download_pdf', ['as' => 'farm.pig.morpho_chars_boar_download_pdf', 'uses' => 'FarmController@morphoCharsBoarDownloadPDF']);
    Route::get('growth_perf_download_pdf', ['as' => 'farm.pig.growth_perf_download_pdf', 'uses' => 'FarmController@growthPerfDownloadPDF']);
    Route::get('production_perf_summary_download_pdf', ['as' => 'farm.pig.production_perf_summary_download_pdf', 'uses' => 'FarmController@productionPerfSummaryDownloadPDF']);
    Route::get('sow_production_perf_download_pdf/{id}', ['as' => 'farm.pig.sow_production_perf_download_pdf', 'uses' => 'FarmController@sowProductionPerfDownloadPDF']);
    Route::get('boar_production_perf_download_pdf/{id}', ['as' => 'farm.pig.boar_production_perf_download_pdf', 'uses' => 'FarmController@boarProductionPerfDownloadPDF']);
    Route::get('cumulative_download_pdf/{filter}', ['as' => 'farm.pig.cumulative_download_pdf', 'uses' => 'FarmController@cumulativeDownloadPDF']);
    Route::get('monthly_download_pdf/{filter}', ['as' => 'farm.pig.monthly_download_pdf', 'uses' => 'FarmController@monthlyPerfDownloadPDF']);
    Route::get('breeder_inventory_download_pdf', ['as' => 'farm.pig.breeder_inventory_download_pdf', 'uses' => 'FarmController@breederInventoryDownloadPDF']);
    Route::get('grower_inventory_download_pdf/{filter}', ['as' => 'farm.pig.grower_inventory_download_pdf', 'uses' => 'FarmController@growerInventoryDownloadPDF']);
    Route::get('mortality_and_sales_download_pdf', ['as' => 'farm.pig.mortality_and_sales_download_pdf', 'uses' => 'FarmController@mortalityAndSalesDownloadPDF']);
    Route::get('sowlitter_record_download_pdf/{id}', ['as' => 'farm.pig.sowlitter_record_download_pdf', 'uses' => 'FarmController@sowLitterRecordDownloadPDF']);
    Route::get('gross_morpho_all_download_csv', ['as' => 'farm.pig.gross_morpho_all_download_csv', 'uses' => 'FarmController@grossMorphoAllDownloadCSV']);
    Route::get('gross_morpho_sow_download_csv', ['as' => 'farm.pig.gross_morpho_sow_download_csv', 'uses' => 'FarmController@grossMorphoSowDownloadCSV']);
    Route::get('gross_morpho_boar_download_csv', ['as' => 'farm.pig.gross_morpho_boar_download_csv', 'uses' => 'FarmController@grossMorphoBoarDownloadCSV']);
    Route::get('morpho_chars_all_download_csv', ['as' => 'farm.pig.morpho_chars_all_download_csv', 'uses' => 'FarmController@morphoCharsAllDownloadCSV']);
    Route::get('morpho_chars_sow_download_csv', ['as' => 'farm.pig.morpho_chars_sow_download_csv', 'uses' => 'FarmController@morphoCharsSowDownloadCSV']);
    Route::get('morpho_chars_boar_download_csv', ['as' => 'farm.pig.morpho_chars_boar_download_csv', 'uses' => 'FarmController@morphoCharsBoarDownloadCSV']);
    Route::get('growth_perf_download_csv', ['as' => 'farm.pig.growth_perf_download_csv', 'uses' => 'FarmController@growthPerfDownloadCSV']);
    Route::get('production_perf_summary_download_csv', ['as' => 'farm.pig.production_perf_summary_download_csv', 'uses' => 'FarmController@productionPerfSummaryDownloadCSV']);
    Route::get('sow_production_perf_download_csv/{id}', ['as' => 'farm.pig.sow_production_perf_download_csv', 'uses' => 'FarmController@sowProductionPerfDownloadCSV']);
    Route::get('boar_production_perf_download_csv/{id}', ['as' => 'farm.pig.boar_production_perf_download_csv', 'uses' => 'FarmController@boarProductionPerfDownloadCSV']);
    Route::get('sowlitter_record_download_csv/{id}', ['as'=> 'farm.pig.sowlitter_record_download_csv', 'uses' => 'FarmController@sowLitterRecordDownloadCSV']);
    Route::get('gross_morphology_report', ['as' => 'farm.pig.gross_morphology_report', 'uses' => 'FarmController@getGrossMorphologyReportPage']);
    Route::get('morpho_chars_report', ['as' => 'farm.pig.morpho_chars_report', 'uses' => 'FarmController@getMorphometricCharacteristicsReportPage']);
    Route::get('growth_performance_report', ['as' => 'farm.pig.growth_performance_report', 'uses' => 'FarmController@getGrowthPerformanceReportPage']);
    Route::post('filter_gross_morphology_report', ['as' => 'farm.pig.filter_gross_morphology_report', 'uses' => 'FarmController@filterGrossMorphologyReport']);
    Route::post('filter_morpho_chars_report', ['as' => 'farm.pig.filter_morpho_chars_report', 'uses' => 'FarmController@filterMorphometricCharacteristicsReport']);
    Route::resource('farm', 'FarmController');
    Route::get('breeder_production_report', ['as' => 'farm.pig.breeder_production_report', 'uses' => 'FarmController@getBreederProductionReportPage']);
    Route::get('production_performance_report', ['as' => 'farm.pig.production_performance_report', 'uses' => 'FarmController@getProductionPerformancePage']);
    Route::post('prod_performance_parity', ['as' => 'farm.pig.prod_performance_parity', 'uses' => 'FarmController@fetchProdPerformanceParity']);
    Route::post('prod_performance_month', ['as' => 'farm.pig.prod_performance_month', 'uses' => 'FarmController@fetchProdPerformanceMonth']);
    Route::get('sow_production_performance/{id}', ['as' => 'farm.pig.sow_production_performance', 'uses' => 'FarmController@getSowProductionPerformancePage']);
    Route::get('sow_production_performance_per_parity/{id}', ['as' => 'farm.pig.sow_production_performance_per_parity', 'uses' => 'FarmController@getSowProductionPerformancePerParityPage']);
    Route::get('boar_production_performance/{id}', ['as' => 'farm.pig.boar_production_performance', 'uses' => 'FarmController@getBoarProductionPerformancePage']);
    Route::get('boar_production_performance_per_service/{id}', ['as' => 'farm.pig.boar_production_performance_per_service', 'uses' => 'FarmController@getBoarProductionPerformancePerServicePage']);
    Route::get('cumulative_report/{year}', ['as' => 'farm.pig.cumulative_report', 'uses' => 'FarmController@getCumulativeReportPage']);
    Route::post('filter_cumulative_report', ['as' => 'farm.pig.filter_cumulative_report', 'uses' => 'FarmController@filterCumulativeReport']);
    Route::get('monthly_performance_report/{filter}', ['as' => 'farm.pig.monthly_performance_report', 'uses' => 'FarmController@getMonthlyPerformanceReportPage']);
    Route::post('filter_monthly_performance', ['as' => 'farm.pig.filter_monthly_performance', 'uses' => 'FarmController@filterMonthlyPerformance']);
    Route::get('breeder_inventory_report', ['as' => 'farm.pig.breeder_inventory_report', 'uses' => 'FarmController@getBreederInventoryPage']);
    Route::get('grower_inventory_report/{filter}', ['as' => 'farm.pig.grower_inventory_report', 'uses' => 'FarmController@getGrowerInventoryPage']);
    Route::post('filter_grower_inventory', ['as' => 'farm.pig.filter_grower_inventory', 'uses' => 'FarmController@filterGrowerInventory']);
    Route::get('mortality_and_sales_report', ['as' => 'farm.pig.mortality_and_sales_report', 'uses' => 'FarmController@getMortalityAndSalesReportPage']);
    Route::get('farm_profile', ['as' => 'farm.pig.farm_profile', 'uses' => 'FarmController@getFarmProfilePage']);
    Route::get('downloadable_files', ['as' => 'farm.pig.downloadable_files', 'uses' => 'FarmController@getDownloadableFilesPage']);
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

  Route::group(['prefix' => 'admin'], function(){
    Route::get('/',['as' => 'admin.index', 'uses' => 'AdminController@index']);

    Route::get('breed_mgt', ['as' => 'admin.breed_mgt', 'uses' => 'AdminController@getBreedMgtPage']);
    Route::post('fetch_breed', ['as' => 'admin.fetch_breed', 'uses' => 'AdminController@fetchNewBreed']);
    Route::post('edit', ['as' => 'admin.edit_breed', 'uses' => 'AdminController@editBreed']);
    Route::post('delete_breed', ['as' => 'admin.delete_breed', 'uses' => 'AdminController@deleteBreed']);
    Route::get('farm_mgt', ['as' => 'admin.farm_mgt', 'uses' => 'AdminController@getFarmMgtPage']);
    Route::post('fetch_farm', ['as' => 'admin.fetch_farm', 'uses' => 'AdminController@fetchNewFarm']);
    Route::post('edit_farm', ['as' => 'admin.edit_farm', 'uses' => 'AdminController@editFarm']);
    Route::post('delete_farm', ['as' => 'admin.delete_farm', 'uses' => 'AdminController@deleteFarm']);
    Route::get('user_mgt', ['as' => 'admin.user_mgt', 'uses' => 'AdminController@getUserMgtPage']);
    Route::post('fetch_user', ['as' => 'admin.fetch_user', 'uses' => 'AdminController@fetchNewUser']);
    Route::post('edit_user', ['as' => 'admin.edit_user', 'uses' => 'AdminController@editUser']);
    Route::post('delete_user', ['as' => 'admin.delete_user', 'uses' => 'AdminController@deleteUser']);
    Route::post('mimic_user', ['as' => 'admin.mimic_user', 'uses' => 'AdminController@mimicUser']);
  });

});


// Socialite Routes
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/link/{token}', 'Auth\LoginController@loginLink');
Route::get('farm/logout', 'Auth\LoginController@logout');
Route::get('admin/logout', 'Auth\LoginController@logout');
Route::get('logout', 'Auth\LoginController@logout');
