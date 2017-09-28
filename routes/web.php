<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'SearchController@index')->name('index');
    Route::get('search', 'SearchController@index')->name('search');
    Route::post('search/typeahead', 'SearchController@typeahead')->name('search.typeahead');
});
