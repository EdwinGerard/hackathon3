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
     * @Route("/", name="temp_homepage")
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
     * @Route("/{string}", name="temp_search_result")
     * @Method("GET")
     */
    public function searchAction(CallApi $callApi, string $string)
    {
        $body = $callApi->searchResultsWork($string);

        return new Response(
            '<html><body>'.
            var_dump($body)
            .'</body></html>'
        );
    }

    /**
     * @Route("/author/{string}", name="temp_search_result_author")
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
     * @Route("/show/{id}", name="temp_show_oeuvre")
     * @Method("GET")
     */
    public function showAction(CallApi $callApi, int $id)
    {
        $result = $callApi->connect($id);
        $collection = '<p>'.$result['collection'].'</p>';
        $periodStart = '<p>'.$result['periodStart'].'</p>';
        $periodEnd = '<p>'.$result['periodEnd'].'</p>';
        $technique = '<p>'.$result['technique'].'</p>';
        $locationName = '<p>'.$result['locationName'].'</p>';
        $locationCity = '<p>'.$result['locationCity'].'</p>';
        $image = '<p><img src="'.$result['image'].'"style="width: 150px;height: 200px;" ></p>';
        $title = '<p>'.$result['title'].'</p>';
        $description = $result['description'];
        $descriptionUrl = '<p><a href="'.$result['descriptionUrl'].'">'.$result['descriptionUrl'].'</a></p>';
        $creationDate = '<p>'.$result['creationDate'].'</p>';
        $authorName = '<p>'.$result['authorName'].'</p>';
        $authorApiId = '<p>'.$result['authorApiId'].'</p>';
        $body = $collection.
            $periodStart.
            $periodEnd.
            $technique.
            $locationName.
            $locationCity.
            $image.
            $title.
            $description.
            $descriptionUrl.
            $creationDate.
            $authorName.
            $authorApiId;

        return new Response(
            '<html><body>'. $body .'</body></html>'
        );
    }
}