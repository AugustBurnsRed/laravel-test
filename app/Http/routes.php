<?php

/*general pages*/

Route::get('/',function(){
    return 'Home Page';
});

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

/*torrents pages*/
//Route::get('torrents', 'TorrentsController@index');
Route::get('torrents/ajouter', 'TorrentsController@create');
//Route::get('torrents/{id}/éditer', 'TorrentsController@edit');
//Route::post('torrents','TorrentsController@store');

Route:resource('torrents', 'TorrentsController');


/*series pages*/
Route::get('séries/{serieId}/épisode/{episodeId}', 'SeriesController@showEpisode');

/*authentication*/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*admin*/
Route::get('admin', ['middleware' => 'admin', function()
{
    return 'this page may only be seen by admin';
}]);
