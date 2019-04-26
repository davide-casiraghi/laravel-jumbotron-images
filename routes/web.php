<?php

    Route::group(['namespace' => 'DavideCasiraghi\LaravelJumbotronImages\Http\Controllers', 'middleware' => 'web'], function () {

        /* Jumbrotron images */
        Route::resource('jumbotron-images', 'JumbotronImageController');
        //Route::get('/random-quote/', 'ResponsiveQuoteController@showRandomQuote');

        /* Jumbrotron images data translations */
        Route::get('jumbotron-images-translation/{imageId}/{languageCode}/create', 'JumbotronImageTranslationController@create')->name('jumbotron-images-translation.create');
        Route::get('jumbotron-images-translation/{imageId}/{languageCode}/edit', 'JumbotronImageTranslationController@edit')->name('jumbotron-images-translation.edit');
        Route::resource('jumbotron-images-translation', 'JumbotronImageTranslationController')->except(['create', 'edit']);
    });
