<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Serie;
use App\Torrent;
use App\Http\Requests\TorrentRequest;
use App\Tag;
use Auth;
use Illuminate\Http\Request;

class TorrentsController extends Controller
{
    /**
     * Create a new torrents controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth', ['only' => 'create']);
    }

    /**
     * show all torrent or one based on search.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$output =  \Tmdb::getSearchApi()->searchMovies('saw',array('language' => 'fr'));

        $perPage = 2;
        $input = $request->input('q');
        $tags = '';
        if ($request->input('tags') != '') {
            $tags = explode(',', $request->input('tags'));
        }

        if ($input && !$tags) {
            $rows = Movie::title($input)->sortAndPaginate($perPage);
        } elseif ($tags) {
            $rows = Movie::title($input)->tags($tags)->sortAndPaginate($perPage);
        } else {
            $rows = Movie::sortAndPaginate($perPage);
        }
        if (!$tags) {
            $tags = [];
        }
        $table = \Table::create($rows, ['test']);

        $table->addColumn('title', 'Nom', function ($torrent) {
            return $torrent->title;
        });

        $table->addColumn('created_at', 'Ajouté', function ($torrent) {
            return $torrent->created_at->diffForHumans();
        });

        return view('torrents.index', ['table' => $table, 'input' => $input, 'tags' => implode(',', $tags)]);
    }

    /**
     * Show the series page according to the torrent.
     *
     * @param Torrent $torrent
     *
     * @return \Illuminate\View\View
     */
    public function show(Torrent $torrent)
    {
        return view('series.show', compact('torrent'));
    }

    /** Upload torrent
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::lists('name', 'id');

        return view('torrents.create', compact('tags'));
    }

    /**
     * Save new torrent in BD.
     *
     * @param TorrentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TorrentRequest $request)
    {
        $this->createTorrent($request);

        flash('Votre torrent a été ajouté');

        return redirect('torrents');
    }

    /**
     * Edit a torrent.
     *
     * @param Torrent $torrent
     *
     * @return \Illuminate\View\View
     */
    public function edit(Torrent $torrent)
    {
        $tags = Tag::lists('name', 'id');

        return view('torrents.edit', compact('torrent', 'tags'));
    }

    /**
     * Update a torrent.
     *
     * @param Torrent        $torrent
     * @param TorrentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Torrent $torrent, TorrentRequest $request)
    {
        $torrent->update($request->all());

        $this->syncTags($torrent, $request->input('tag_list'));

        return redirect('torrents');
    }

    /**
     * Sync up the list of tags in the database.
     *
     * @param Torrent $torrent
     * @param array   $tags
     */
    private function syncTags(Movie $movie, array $tags)
    {
        $movie->tags()->sync($tags);
    }

    /**
     * Save a new article.
     *
     * @param TorrentRequest $request
     *
     * @return mixed
     */
    private function createTorrent(TorrentRequest $request)
    {
        $collection = \Tmdb::getMoviesApi()->getMovie($request->input('tmdb_id'))['belongs_to_collection'];

        if ($collection['name'] != null) {
            $serie = Serie::firstOrCreate(['title' => $collection['name'], 'tmdb_id' => $collection['id']]);
        } else {
            $serie['id'] = 0;
        }

        $movie = Movie::firstOrCreate(['serie_id' => $serie['id'], 'title' => $request->input('title'), 'tmdb_id' => $request->input('tmdb_id')]);

        $request->request->add(['movie_id' => $movie->id, 'serie_id' => $serie['id']]);

        $torrent = Auth::user()->torrents()->create($request->all());

        $this->syncTags($movie, $request->input('tag_list'));

        return $torrent;
    }

    /**
     * Find information for the upload autocomplete.
     *
     * @param Request $request
     */
    public function findAutocompleteInfo(Request $request)
    {
        //dd($request->all());
      $name = $request->input('query');
        $output = \Tmdb::getSearchApi()->searchMovies($name, array('language' => 'fr', 'search_type' => 'ngram', 'year' => $request->input('year')));
        //$output = \Tmdb::getMoviesApi()->getImages($output['results'][0]['id']);

        foreach ($output['results'] as $value) {
            $image = \Tmdb::getMoviesApi()->getImages($value['id']);
            if (isset($image['posters'][0])) {
                $image = $image['posters'][0]['file_path'];
            } else {
                $image = '';
            }

            $array = array('image' => $image,'value' => $value['title'].' ('.substr($value['release_date'], 0, 4).')', 'data' => $value['id']);
            $result[] = $array;
        }

        $result['suggestions'] = $result;
        echo json_encode($result);
    }
}
