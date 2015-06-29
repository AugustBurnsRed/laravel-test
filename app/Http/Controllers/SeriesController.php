<?php

namespace App\Http\Controllers;

use App\Torrent;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function showEpisode($seasonId,$episodeId)
    {
        $torrent = Torrent::findOrFail($episodeId);

        return view('series.show', compact('torrent'));
    }
}
