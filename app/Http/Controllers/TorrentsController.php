<?php

namespace App\Http\Controllers;

use App\Torrent;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        $this->middleware('auth',['only' => 'create']);
    }

    /**
     * show all torrents
     * 
     * @return [array] [torrents]
     */ 
    public function index(Request $request)
    {
        // Check if user has sent a search query
        $input = $request->input('q');
        if($input) {
            // Use the Elasticquent search method to search ElasticSearch
            $torrents = Torrent::search($input);
        } else {
            // Show all posts if no query is set
            $torrents = Torrent::latest('created_at')->get();
        }
        
        return view('torrents.index',compact('torrents'));
    }

    /**
     * Show the series page according to the torrent
     * @param  Torrent $torrent
     * @return view
     */
    public function show(Torrent $torrent){
        return view('series.show', compact('torrent'));
    }

    /**
     * upload torrent
     * 
     * @return view
     */
    public function create()
    {
        $tags = Tag::lists('name', 'id');
        return view('torrents.create', compact('tags'));
    }

    /**
     * save new torrent in BD
     * 
     * @return redirect
     */
    public function store(TorrentRequest $request)
    {
        $this->createTorrent($request);
        
        flash('Votre torrent a été ajouté');

        return redirect('torrents');
    }

    /**
     * Edit a torrent
     * 
     * @param  Torrent $torrent
     * @return Response           
     */
    public function edit(Torrent $torrent)
    {
        $tags = Tag::lists('name', 'id');
        return view('torrents.edit', compact('torrent', 'tags'));
    }

    /**
     * Update a torrent.
     * 
     * @param  Torrent        $torrent
     * @param  TorrentRequest $request
     * @return Response                  
     */
    public function update(Torrent $torrent, TorrentRequest $request)
    {
        $torrent->update($request->all());

        $this->syncTags($torrent, $request->input('tag_list'));

        /*add to elastic*/
        $torrent->addToIndex();

        return redirect ('torrents');
    }

    /**
     * Sync up the list of tags in the database
     * 
     * @param  Torrent $torrent
     * @param  array   $tags    
     */
    private function syncTags(Torrent $torrent, array $tags)
    {
        $torrent->tags()->sync($tags);
    }

    /**
     * Save a new article.
     * 
     * @param  ArticleRequest $request
     * @return mixed
     */
    private function createTorrent(TorrentRequest $request)
    {
        $torrent = Auth::user()->torrents()->create($request->all());

        $this->syncTags($torrent, $request->input('tag_list'));

        /*add to elastic*/
        $torrent->addToIndex();

        return $torrent;
    }
}
