<?php

namespace App\Http\Controllers;

use App\Tag;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        $torrents = $tag->torrents;

        return view('torrents.index', compact('torrents'));
    }
}
