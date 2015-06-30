<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        $torrents = $tag->torrents;

        return view('torrents.index', compact('torrents'));
    }
}
