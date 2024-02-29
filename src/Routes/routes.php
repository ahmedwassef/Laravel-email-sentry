<?php


Route::get('/', 'IndexController@index')->name('emails.index');

Route::get('/email/{id}', 'IndexController@show')->name('emails.details');
