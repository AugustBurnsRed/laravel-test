<?php
use App\Torrent;

/*general pages*/

Route::get('/', ['as' => 'home', function () {
    return view('home');
}]);

Route::get('about', [
    'as' => 'about', 'uses' => 'PagesController@about'
]);
Route::get('contact', 'PagesController@contact');

/*torrents pages*/
//Route::get('torrents', 'TorrentsController@index');
Route::get('torrents/ajouter', 'TorrentsController@create');
//Route::post('torrents/findSerie', 'TorrentsController@findSerie');
//Route::get('torrents/{id}/éditer', 'TorrentsController@edit');
//Route::post('torrents','TorrentsController@store');

/*recherche*/
//Route::get('torrents/recherche', ['as' => 'search', 'uses' => 'TorrentsController@search']);
Route::get('torrents', 'TorrentsController@search');
Route::get('torrents/findAutocompleteInfo', 'TorrentsController@findAutocompleteInfo');
resource('torrents', 'TorrentsController');

/*serie page*/
Route::get('séries/{serieId}', [
    'as' => 'series.show', 'uses' => 'SeriesController@show'
]);

/*movie page*/
//Route::get('séries/{serieId}/épisode/{episodeId}', 'SeriesController@showEpisode');
Route::get('séries/{serieId}/film/{episodeId}', [
    'as' => 'movies.show', 'uses' => 'MoviesController@show'
]);

/*authentication*/
Route::controller('auth', 'Auth\AuthController', [
    'getRegister' => 'auth.register',
    'getLogin'    => 'auth.login',
]);

/**
 * messages
 */
resource('messages', 'MessagesController');


/*admin*/
Route::get('admin', ['middleware' => 'admin', function ()
{
    return 'this page may only be seen by admin';
}]);

//tags
Route::get('tags/{tags}', 'TagsController@show');
