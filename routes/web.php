<?php

Auth::routes();

Route::any('/{any}', 'AppController@index')->where('any', '.*');
