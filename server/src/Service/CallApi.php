<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 13/06/18
 * Time: 18:19
 */

namespace App\Service;


use DateTime;

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
        $res = $resf->hits->hits[0]->_source;
        $work['apiId'] = null;
        $work['collection'] = '';
        $work['periodStart'] = '';
        $work['periodEnd'] = '';
        $work['locationName'] = '';
        $work['locationCity'] = '';
        $work['image'] = '';
        $work['title'] = '';
        $work['technique'] = '';
        $work['description'] = '';
        $work['descriptionUrl'] = '';
        $work['creationDate'] = '';
        $work['authorName'] = '';
        $work['authorApiId'] = null;
        if (isset($res->id)) {
            $work['apiId'] = $res->id;

        }
        if (isset($res->collections[0]->name->fr)) {
            $work['collection'] = $res->collections[0]->name->fr;

        }
        if (isset($res->periods[0]->suggest_fr->input)) {
            $work['periodStart'] = $res->periods[0]->suggest_fr->input;

        }
        if (isset($res->periods[0]->suggest_fr->output)) {
            $work['periodEnd'] = $res->periods[0]->suggest_fr->output;

        }
        if (isset($res->location->name->fr)) {
            $work['locationName'] = $res->location->name->fr;

        }
        if (isset($res->location->city->fr)) {
            $work['locationCity'] = $res->location->city->fr;

        }
        if (isset($res->images[0]->urls->huge->url)) {
            $work['image'] = $res->images[0]->urls->huge->url;

        }
        if (isset($res->title->fr)) {
            $work['title'] = $res->title->fr;

        }

        if (isset($res->techniques[0])) {
            $work['technique'] = $res->techniques[0]->suggest_fr->input;
        }

        if (isset($res->wikipedia_extract->fr)) {
            $work['description'] = $res->wikipedia_extract->fr;
            $work['descriptionUrl'] = $res->wikipedia_url->fr;
        }
        if (isset($res->date->display)) {
            $work['creationDate'] = intval($res->date->display);
        }
        if (isset($res->authors[0]->name->fr)) {
            $authorName = $res->authors[0]->name->fr;
            $resf2 = $curlService->generateAPiUrl('authors', $authorName);
            $res2 = $resf2->hits->hits[0];
            $work['authorName'] = $authorName;
            $work['authorApiId'] = $res2->_id;
            $work['author'] = $this->buildAuthor($res->authors[0]);
            if (isset($res->authors[0]->citizenship)) $data['author']['citizen'] = $res->authors[0]->citizenship;
            $work['author']['apiId'] = $work['authorApiId'];

        }


        return $work;
    }

    private function buildAuthor($author)
    {

        $data['name'] = '';
        $data['description'] = '';
        $data['descriptionUrl'] = '';
        $data['birth'] = '';
        $data['death'] = '';
        if (isset($author->citizenship)) $data['citizen'] = $author->citizenship;
        if (isset($author->name->fr)) $data['name'] = $author->name->fr;
        if (isset($author->wikipedia_extract->fr)) $data['description'] = $author->wikipedia_extract->fr;
        if (isset($author->wikipedia_url->fr)) $data['descriptionUrl'] = $author->wikipedia_url->fr;
        if (isset($author->birth->display)) $data['birth'] = $author->birth->display;
        if (isset($author->death->display)) $data['death'] = $author->death->display;
        return $data;
    }

    /**
     * @param string $request
     * @return mixed
     */
    public function searchResultsWork(string $request)
    {
        $curlService = new CurlService();

        $resf = $curlService->generateAPiUrl('works', $request);
        foreach ($resf->hits->hits as $key => $hit) {
            if (isset($hit->_source->images[0]->urls->huge->url)) {
                $works[$key]['image'] = $hit->_source->images[0]->urls->huge->url;

            }
            if (isset($hit->_source->id)) {
                $works[$key]['apiId'] = $hit->_source->id;

            }
            if (isset($hit->_source->title->fr)) {
                $works[$key]['title'] = $hit->_source->title->fr;

            }
            if (isset($hit->_source->authors[0]->name->fr)) {
                $works[$key]['authorName'] = $hit->_source->authors[0]->name->fr;

            }
        }
        $works['totalMatch'] = $resf->hits->total;

        return $works;
    }

//    /**
//     * @param string $request
//     * @return array
//     */
//    public function searchResultAuthor(string $request)
//    {
//        $curlService = new CurlService();
//        $resf = $curlService->generateAPiUrl('authors', $request);
//        foreach ($resf->hits->hits as $hit) {
//            $titles[] = $hit->_source->name->fr;
//        }
//
//        return $titles;
//    }
/*
    public function findAuthor(string $request)
    {
        $curlService = new CurlService();
        $resf = $curlService->generateAPiUrl('authors', $request);
        $res = $resf->hits->hits[0]->_source;
        $author['name'] = '';
        $author['birth'] = '';
        $author['death'] = '';
        $author['bio'] = '';
        $author['bioUrl'] = '';
        if (isset($res->name->fr)) {
            $author['name'] = $res->name->fr;
        }
        if (isset($res->birth->display)) {
            $author['birth'] = $res->birth->display;
        }
        if (isset($res->death->display)) {
            $author['death'] = $res->death->display;
        }
        if (isset($res->wikipedia_extract->fr)) {
            $author['bio'] = $res->wikipedia_extract->fr;
        }
        if (isset($res->wikipedia_url->fr)) {
            $author['bioUrl'] = $res->wikipedia_url->fr;
        }
        return $author;
    }
*/
}