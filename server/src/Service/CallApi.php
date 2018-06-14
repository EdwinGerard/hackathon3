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
    public function connect(int $id)
    {
        $curlService = new CurlService();
        $resf = $curlService->generateAPiUrl('works', $id);
        $res = $resf->hits->hits[ 0 ]->_source;
        $work[ 'apiId' ] = $res->id;
        $work[ 'collection' ] = $res->collections[ 0 ]->name->fr;
        $work[ 'periodStart' ] = $res->periods[ 0 ]->suggest_fr->input;
        $work[ 'periodEnd' ] = $res->periods[ 0 ]->suggest_fr->output;
        $work[ 'technique' ] = '';
        if (isset($res->techniques[ 0 ])) {
            $work[ 'technique' ] = $res->techniques[ 0 ]->suggest_fr->input;
        }
        $work[ 'locationName' ] = $res->location->name->fr;
        $work[ 'locationCity' ] = $res->location->city->fr;
        $work[ 'image' ] = $res->images[ 0 ]->urls->huge->url;
        $work[ 'title' ] = $res->title->fr;
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
        $authorName = $res->authors[0]->name->fr;
        $resf = $curlService->generateAPiUrl('authors', $authorName);
        $res = $resf->hits->hits[ 0 ];
        $work[ 'authorName' ] = $authorName;
        $work['authorApiId'] = $res->_id;
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
    public function searchResultsWork(string $request)
    {
        $curlService = new CurlService();

        $resf = $curlService->generateAPiUrl('works', $request);
        foreach ($resf->hits->hits as $hit) {
            $images[]['image'] = $hit->_source->images[ 0 ]->urls->huge->url;
            $images[]['id'] = $hit->_source->id;
        }

        return $images;
    }

    /**
     * @param string $request
     * @return array
     */
    public function searchResultAuthor(string $request)
    {
        $curlService = new CurlService();
        $resf = $curlService->generateAPiUrl('authors', $request);
        foreach ($resf->hits->hits as $hit) {
            $titles[] = $hit->_source->name->fr;
        }

        return $titles;
    }

}