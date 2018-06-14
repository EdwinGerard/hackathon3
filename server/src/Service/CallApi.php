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
    /**
     * @param int $id
     * @return mixed
     */
    public function connect (int $id)
    {
        $curlService = new CurlService();
        $resf = $curlService->generateAPiUrl('works', $id);
        $res = $resf->hits->hits[ 0 ]->_source;
        if (isset($res->id)) {
            $work[ 'apiId' ] = $res->id;

        }
        if (isset($res->collections[ 0 ]->name->fr)) {
            $work[ 'collection' ] = $res->collections[ 0 ]->name->fr;

        }
        if (isset($res->periods[ 0 ]->suggest_fr->input)) {
            $work[ 'periodStart' ] = $res->periods[ 0 ]->suggest_fr->input;

        }
        if (isset($res->periods[ 0 ]->suggest_fr->output)) {
            $work[ 'periodEnd' ] = $res->periods[ 0 ]->suggest_fr->output;

        }
        if (isset($res->location->name->fr)) {
            $work[ 'locationName' ] = $res->location->name->fr;

        }
        if (isset($res->location->city->fr)) {
            $work[ 'locationCity' ] = $res->location->city->fr;

        }
        if (isset($res->images[ 0 ]->urls->huge->url)) {
            $work[ 'image' ] = $res->images[ 0 ]->urls->huge->url;

        }
        if (isset($res->title->fr)) {
            $work[ 'title' ] = $res->title->fr;

        }
        if (isset($res->authors[ 0 ]->name->fr)) {
            $authorName = $res->authors[ 0 ]->name->fr;

        }
        $work[ 'technique' ] = '';
        if (isset($res->techniques[ 0 ])) {
            $work[ 'technique' ] = $res->techniques[ 0 ]->suggest_fr->input;
        }
        $work[ 'description' ] = '';
        $work[ 'descriptionUrl' ] = '';
        if (isset($res->wikipedia_extract->fr)) {
            $work[ 'description' ] = $res->wikipedia_extract->fr;
            $work[ 'descriptionUrl' ] = $res->wikipedia_url->fr;
        }
        $work[ 'date' ] = '';
        if (isset($res->date->display)) {
            $work[ 'creationDate' ] = $res->date->display;
        }
        $resf = $curlService->generateAPiUrl('authors', $authorName);
        $res = $resf->hits->hits[ 0 ];
        $work[ 'authorName' ] = $authorName;
        $work[ 'authorApiId' ] = $res->_id;
//        $authors = $res->_source;
//        $author[ 'name' ] = $authors->name->fr;
//        $author[ 'birthday' ] = $authors->birth->display;
//        $author[ 'death' ] = $authors->death->display;
//        $author[ 'wikipedia_extract' ] = '';
//        $author[ 'wikipedia_url' ] = '';
//        if (isset($authors->wikipedia_url->fr)) {
//            $author[ 'wikipedia_extract' ] = $authors->wikipedia_extract->fr;
//            $author[ 'wikipedia_url' ] = $authors->wikipedia_url->fr;
//        }

        return $work;
    }

    /**
     * @param string $request
     * @return mixed
     */
    public function searchResultsWork (string $request)
    {
        $curlService = new CurlService();

        $resf = $curlService->generateAPiUrl('works', $request);
        $count = 0;
        foreach ($resf->hits->hits as $hit) {
            if (isset($hit->_source->images[ 0 ]->urls->huge->url)) {
                $images[ $count ][ 'image' ] = $hit->_source->images[ 0 ]->urls->huge->url;

            }
            if (isset($hit->_source->id)) {
                $images[ $count ][ 'id' ] = $hit->_source->id;

            }
            if (isset($hit->_source->title->fr)) {
                $images[ $count ][ 'title' ] = $hit->_source->title->fr;

            }
            if (isset($hit->_source->authors[ 0 ]->name->fr)) {
                $images[ $count ][ 'authorName' ] = $hit->_source->authors[ 0 ]->name->fr;

            }
            $count++;
        }

        return $images;
    }

    /**
     * @param string $request
     * @return array
     */
    public function searchResultAuthor (string $request)
    {
        $curlService = new CurlService();
        $resf = $curlService->generateAPiUrl('authors', $request);
        foreach ($resf->hits->hits as $hit) {
            $titles[] = $hit->_source->name->fr;
        }

        return $titles;
    }

}