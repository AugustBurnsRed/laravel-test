<?php
use App\Torrent;

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

//tags
Route::get('tags/{tags}', 'TagsController@show');

/*search*/
Route::get('/', ['as' => 'search', 'uses' => function() {

  // Check if user has sent a search query
  if($query = Input::get('query', false)) {
    // Use the Elasticquent search method to search ElasticSearch
    $posts = Torrent::search($query);
  } else {
    // Show all posts if no query is set
    $posts = Torrent::all(); 
  }

return View::make('home', compact('posts'));
}]);