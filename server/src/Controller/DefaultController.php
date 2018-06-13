<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 13/06/18
 * Time: 18:04
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\CallApi;

class DefaultController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction ()
    {

        return new Response(
            '<html><body>'.
            'Tapez une oeuvre dans l\'url
            ex: /la joconde'
            .'</body></html>'
        );

    }

    /**
     * @Route("/{string}", name="search_result")
     * @Method("GET")
     */
    public function searchAction(CallApi $callApi, string $string)
    {
        $body = $callApi->searchResultsWork($string);

        return new Response(
            '<html><body>'.
            $body
            .'</body></html>'
        );
    }

    /**
     * @Route("/author/{string}", name="search_result_author")
     * @Method("GET")
     */
    public function searchAuthorAction(CallApi $callApi, string $string)
    {
        $body = $callApi->searchResultAuthor($string);

        return new Response(
            '<html><body>'.
            var_dump($body)
            .'</body></html>'
        );
    }

    /**
     * @Route("/show/{id}", name="show_oeuvre")
     * @Method("GET")
     */
    public function showAction(CallApi $callApi, int $id)
    {
        $result = $callApi->connect($id);
        $collection = '<p>'.$result['collection'].'</p>';
        $periodStart = '<p>'.$result['period']['start'].'</p>';
        $periodEnd = '<p>'.$result['period']['end'].'</p>';
        $technique = '<p>'.$result['techniques'].'</p>';
        $locationName = '<p>'.$result['location']['name'].'</p>';
        $locationCity = '<p>'.$result['location']['city'].'</p>';
        $image = '<p><img src="'.$result['image'].'"style="width: 150px;height: 200px;" ></p>';
        $title = '<p>'.$result['title'].'</p>';
        $wikiText = $result['wikipedia_extract'];
        $wikiUrl = '<p><a href="'.$result['wikipedia_url'].'">'.$result['wikipedia_url'].'</a></p>';
        $date = '<p>'.$result['date'].'</p>';
        $authorName = '<p>'.$result['author']['name'].'</p>';
        $authorBirth = '<p>'.$result['author']['birthday'].'</p>';
        $authorDeath = '<p>'.$result['author']['death'].'</p>';
        $authorWikiText = '<p>'.$result['author']['wikipedia_extract'].'</p>';
        $authorWikiUrl = '<p><a href="'.$result['author']['wikipedia_url'].'">'.$result['author']['wikipedia_url'].'</a></p>';
        $body = $collection.
            $periodStart.
            $periodEnd.
            $technique.
            $locationName.
            $locationCity.
            $image.
            $title.
            $wikiText.
            $wikiUrl.
            $date.
            $authorName.
            $authorBirth.
            $authorDeath.
            $authorWikiText.
            $authorWikiUrl;

        return new Response(
            '<html><body>'. $body .'</body></html>'
        );
    }
}