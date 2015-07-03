<?php

namespace App\Http\Controllers;

use App\Torrent;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TorrentRequest;
use App\Tag;

use Auth;

use Illuminate\Http\Request;
use App\Steven\CustomVendor\PaginationLinks as Pagination;

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

        //variable
        $perPage = 1;
        $page = $request->input('page');
        if(!$page){$page = 1;}
        $skip = ($page*$perPage)-$perPage;

        //tableau
        
        $input = $request->input('q');
        if($input) {
            $rows = Torrent::where('title', 'LIKE', '%t%')
                    ->sorted()->paginate($perPage);
        } else {
            $rows = Torrent::sorted()->paginate($perPage);
        }
        
        $table = \Table::create($rows,['description']);
        /*changé nom colomne dans la BD*/
        $table->addColumn('title', 'Nom', function($model) {
            return $model->title;
        });
        $table->addColumn('created_at', 'Ajouté', function($model) {
            return $model->created_at->diffForHumans();
        });

        return view('torrents.index', ['table' => $table]);

        

        // Check if user has sent a search query
        $input = $request->input('q');
        if($input) {
            // Use the Elasticquent search method to search ElasticSearch
            $torrents = Torrent::searchByQuery([
                    'multi_match' => [
                        'query' => $input,
                        'fields' => ["title^5" , "description"]
                    ]
                ],null,null,$perPage,$skip);
            $total = $torrents->totalHits();
        } else {
            // Show all posts if no query is set
            $total = Torrent::count();
            $torrents = Torrent::orderBy('created_at', 'desc')->take($perPage)->skip($skip)->get();
            
        }
        
        $torrents = $this->generatePagination($request,$page,$perPage,$total,$torrents);
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

    /**
     * generate the pagination
     * @return pagination
     */
    private function generatePagination(Request $request,$page,$perPage,$total,$content){
        
        return $torrents = Pagination::makeLengthAware($content, $total, $perPage )->appends($request->except('page'));
    }
}
