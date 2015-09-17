<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gbrock\Table\Traits\Sortable;

class Torrent extends Model
{
    use Sortable;

    /*enlever le title quand il va être généré automatiquement....pas sûre à tester*/
    protected $fillable = [
        'movie_id',
        'serie_id',
    ];

    /**
     * The attributes which may be used for sorting dynamically.
     *
     * @var array
     */
    protected $sortable = ['title', 'created_at'];

    /**
     * A torrent is owned by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * A torrent belongs to a movie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return  $this->belongsTo('App\Movie');
    }

    /**
     * Search torrents by title.
     *
     * @param $query
     * @param $input
     *
     * @return mixed
     */
    public function scopeTitle($query, $input)
    {
        return $query->with('movie')->where('title', 'LIKE', '%'.$input.'%');
        /*$result = $query->with('movie')->where('title', 'LIKE', '%' . $input . '%')
                ->join('movie_tag', 'torrents.movie_id', '=', 'movie_tag.movie_id')
                ->join('tags', 'movie_tag.tag_id', '=', 'tags.id')->get();*/
    }

    /**
     * Search torrents by tags.
     *
     * @param $query
     * @param $tags
     *
     * @return mixed
     */
    public function scopeTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
          $query->whereIn('name', $tags);
        });
    }

    /**
     * Sort and paginate the query.
     *
     * @param $query
     * @param $perPage
     *
     * @return mixed
     */
    public function scopeSortAndPaginate($query, $perPage)
    {
        return $query->sorted()->paginate($perPage);
    }

    /**
     * See all torrent related to this movie.
     *
     * @return array
     */
    public function scopeTorrentRelatedMovie($query, $movieId)
    {
        return $query->where('movie_id', '=', $movieId)->get();
    }
}
