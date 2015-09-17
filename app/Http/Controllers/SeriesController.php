<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Serie;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SeriesController extends Controller
{

    public function show($serieId){

        $serieBD = Serie::findOrFail($serieId);
        $output =  \Tmdb::getSearchApi()->searchCollection($serieBD->title,array('language' => 'fr'));
        $serie = $output['results'][0];

        $moviesBD = Movie::collectionMovie($serieBD['id']);

        foreach($moviesBD as $movie){
            $array = \Tmdb::getMoviesApi()->getMovie($movie->tmdb_id,array('language' => 'fr'));
            $array['movieBdId'] = $movie['id'];
            $movies[] = $array;
        }
        $serie['bdId'] = $serieBD['id'];

        return view('serie.show', compact('serie', 'movies'));
    }
    /**
     * Find series ID by name
     *
     * @param $name
     * @return \SimpleXMLElement[]
     */
    /*public function findSerieID($name)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://thetvdb.com/api/GetSeries.php?seriesname=.'$name'.&language=fr");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $xml = simplexml_load_string($output);
        curl_close($ch);

        return $xml->Series[0]->seriesid;
    }*/
}
