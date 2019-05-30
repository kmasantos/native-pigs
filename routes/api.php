<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getAllFarms', "ApiController@getAllFarms");
Route::post('fetchNewPigRecord', "ApiController@fetchNewPigRecord");
Route::get('getViewSowPage', "ApiController@getViewSowPage");
Route::get('getAllSows', "ApiController@getAllSows");
Route::get('getAllBoars', "ApiController@getAllBoars");
Route::get('getAllFemaleGrowers', "ApiController@getAllFemaleGrowers");
Route::get('getAllMaleGrowers', "ApiController@getAllMaleGrowers");
Route::get('getAnimalProperties', "ApiController@getAnimalProperties");
Route::get('getGroupingProperties', "ApiController@getGroupingProperties");
Route::post('fetchGrossMorphology',"ApiController@fetchGrossMorphology");
Route::post('fetchMorphometricCharacteristics',"ApiController@fetchMorphometricCharacteristics");
Route::get('getAllCount', "ApiController@getAllCount");
Route::post('fetchWeightRecords',"ApiController@fetchWeightRecords");
Route::post('addAsBreeder',"ApiController@addAsBreeder");
Route::post('addMortalityRecord', "ApiController@addMortalityRecord");
Route::post('addSalesRecord', "ApiController@addSalesRecord");
Route::post('addRemovedAnimalRecord', "ApiController@addRemovedAnimalRecord");
Route::get('getMortalityPage', "ApiController@getMortalityPage");
Route::get('getSalesPage', "ApiController@getSalesPage");
Route::get('getOthersPage', "ApiController@getOthersPage");
Route::get('searchPig',"ApiController@searchPig");
Route::get('searchSows',"ApiController@searchSows");
Route::get('searchBoars',"ApiController@searchBoars");
Route::post('addBreedingRecord',"ApiController@addBreedingRecord");
Route::get('getBreedingRecord',"ApiController@getBreedingRecord");
Route::get('findGroupingId', "ApiController@findGroupingId");
Route::get('getAddSowLitterRecordPage', "ApiController@getAddSowLitterRecordPage");
Route::post('addSowLitterRecord', "ApiController@addSowLitterRecord");
Route::post('editSowLitterRecord', "ApiController@editSowLitterRecord");
Route::post('addIndividualSowLitterRecord', "ApiController@addIndividualSowLitterRecord");
Route::post('addGroupSowLitterRecord', "ApiController@addGroupSowLitterRecord");
Route::get('viewOffsprings', "ApiController@viewOffsprings");
Route::post('editRegistryId', "ApiController@editRegistryId");
Route::post('editSex', "ApiController@editSex");
Route::post('updateOffspringRecord', "ApiController@updateOffspringRecord");
Route::post('editBirthWeight', "ApiController@editBirthWeight");

// api functions for adding from local to server
Route::post('addToAnimalDb', "ApiController@addToAnimalDb");
Route::post('addToAnimalPropertiesDb', "ApiController@addToAnimalPropertiesDb");
Route::post('addToGroupingDb', "ApiController@addToGroupingDb");
Route::post('addToGroupingMembersDb', "ApiController@addToGroupingMembersDb");
Route::post('addToGroupingPropertiesDb', "ApiController@addToGroupingPropertiesDb");
Route::post('addToMortalitiesDb', "ApiController@addToMortalitiesDb");
Route::post('addToRemovedAnimalsDb', "ApiController@addToRemovedAnimalsDb");
Route::post('addToSalesDb', "ApiController@addToSalesDb");

// api functions for getting from server to local
Route::get('getAnimalDb', "ApiController@getAnimalDb");
Route::get('getAnimalPropertiesDb', "ApiController@getAnimalPropertiesDb");
Route::get('getGroupingsDb', "ApiController@getGroupingsDb");
Route::get('getGroupingMembersDb', "ApiController@getGroupingMembersDb");
Route::get('getGroupingPropertiesDb', "ApiController@getGroupingPropertiesDb");
Route::get('getMortalitiesDb', "ApiController@getMortalitiesDb");
Route::get('getRemovedAnimalsDb', "ApiController@getRemovedAnimalsDb");
Route::get('getSalesDb', "ApiController@getSalesDb");
Route::post('editFarmProfile', "ApiController@editFarmProfile");
Route::post('getFarmProfilePage', "ApiController@getFarmProfilePage");
Route::post('getEmail', "ApiController@getEmail");
