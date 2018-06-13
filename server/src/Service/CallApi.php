<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 13/06/18
 * Time: 18:19
 */

namespace App\Service;


class CallApi
{
    public function connect(int $id)
    {
        $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/works/' . $id;
        $apiKey = '210ccc2ea7fc69e80d2bcd929ed801d4d19f21675addf8541be51da48e2b19d8';
        $headers = array(
            'Authorization: ' . $apiKey,
            'ApiKey:' . $apiKey,
        );
        $ch = curl_init();
        //On lui transmet la variable qui contient l'URL
        curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
        //On lui demdande de nous retourner la page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //On envoie un user-agent pour ne pas être considéré comme un bot malicieux
        //On exécute notre requête et met le résultat dans une variable
        $resultat = curl_exec($ch);
        //On ferme la connexion cURL
        curl_close($ch);
        //echo $resultat;
        $resf = json_decode($resultat);
        $res = $resf->hits->hits[ 0 ]->_source;
        $work[ 'id' ] = $res->id;
        $work[ 'collection' ] = $res->collections[ 0 ]->name->fr;
        $work[ 'period' ][ 'start' ] = $res->periods[ 0 ]->suggest_fr->input;
        $work[ 'period' ][ 'end' ] = $res->periods[ 0 ]->suggest_fr->output;
        $work[ 'techniques' ] = '';
        if (isset($res->techniques[ 0 ])) {
            $work[ 'techniques' ] = $res->techniques[ 0 ]->suggest_fr->input;
        }
        $work[ 'location' ][ 'name' ] = $res->location->name->fr;
        $work[ 'location' ][ 'city' ] = $res->location->city->fr;
        $work[ 'image' ] = $res->images[ 0 ]->urls->huge->url;
        $work[ 'title' ] = $res->title->fr;
        $work[ 'wikipedia_extract' ] = '';
        $work[ 'wikipedia_url' ] = '';
        if (isset($res->wikipedia_extract->fr)) {
            $work[ 'wikipedia_extract' ] = $res->wikipedia_extract->fr;
            $work[ 'wikipedia_url' ] = $res->wikipedia_url->fr;
        }
        $work[ 'date' ] = '';
        if (isset($res->date->display)) {
            $work[ 'date' ] = $res->date->display;
        }
        $authors = $res->authors[ 0 ];
        $author[ 'name' ] = $authors->name->fr;
        $author[ 'birthday' ] = $authors->birth->display;
        $author[ 'death' ] = $authors->death->display;
        $author[ 'wikipedia_extract' ] = '';
        $author[ 'wikipedia_url' ] = '';
        if (isset($authors->wikipedia_url->fr)) {
            $author[ 'wikipedia_extract' ] = $authors->wikipedia_extract->fr;
            $author[ 'wikipedia_url' ] = $authors->wikipedia_url->fr;
        }
        $work[ 'author' ] = $author;

        $workJson = json_encode($work);

        return $work;
    }

    public function searchResultsWork(string $string)
    {
        $q = $string;
        $q = urlencode($q);
        //$wikipediaURL = 'https://api.art.rmngp.fr:443/v1/authors?q=title:'.$a.'&lang=fr&&&&&&&&&&&';
        $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/works?q=' . $q . '&lang=fr&&&&&&&&&&&&&&&&per_page=10&&&&&&&&&&&&&&&&&&';
        $apiKey = '210ccc2ea7fc69e80d2bcd929ed801d4d19f21675addf8541be51da48e2b19d8';
        $headers = array(
            'Authorization: ' . $apiKey,
            'ApiKey:' . $apiKey,
        );
        $ch = curl_init();
        //On lui transmet la variable qui contient l'URL
        curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
        //On lui demdande de nous retourner la page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //On envoie un user-agent pour ne pas être considéré comme un bot malicieux
        //On exécute notre requête et met le résultat dans une variable
        $resultat = curl_exec($ch);
        //On ferme la connexion cURL
        curl_close($ch);
        //echo $resultat;
        $resf = json_decode($resultat);
        foreach ($resf->hits->hits as $hit) {
            $images[] = '<a href="/show/'.$hit->_source->id.'"> <img src='. $hit->_source->images[ 0 ]->urls->huge->url .' style="width: 150px;height: 200px;" ></a>';
            //    var_dump($hit->_source->images[0]->urls->huge->url);
        }
        $body = '';
        foreach ($images as $image) {
            $body .= $image.'';
        }

        return $body;
    }

    public function searchResultAuthor(string $string)
    {
        $q = $string;
        $q = urlencode($q);
        $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/authors?q='.$string.'&lang=fr&&&&&&&&&&&';
//        $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/works?q=' . $q . '&lang=fr&&&&&&&&&&&&&&&&per_page=10&&&&&&&&&&&&&&&&&&';
        $apiKey = '210ccc2ea7fc69e80d2bcd929ed801d4d19f21675addf8541be51da48e2b19d8';
        $headers = array(
            'Authorization: ' . $apiKey,
            'ApiKey:' . $apiKey,
        );
        $ch = curl_init();
        //On lui transmet la variable qui contient l'URL
        curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
        //On lui demdande de nous retourner la page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //On envoie un user-agent pour ne pas être considéré comme un bot malicieux
        //On exécute notre requête et met le résultat dans une variable
        $resultat = curl_exec($ch);
        //On ferme la connexion cURL
        curl_close($ch);
        //echo $resultat;
        $resf = json_decode($resultat);
//        foreach ($resf->hits->hits as $hit) {
//            $images[] = '<a href="/show/'.$hit->_source->id.'"> <img src='. $hit->_source->images[ 0 ]->urls->huge->url .' style="width: 150px;height: 200px;" ></a>';
//            //    var_dump($hit->_source->images[0]->urls->huge->url);
//        }
//        $body = '';
//        foreach ($images as $image) {
//            $body .= $image.'';
//        }

        return $resf->hits->hits;
    }
}