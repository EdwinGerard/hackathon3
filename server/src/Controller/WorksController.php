<?php

namespace App\Controller;

use App\Entity\Works;
use App\Service\CallApi;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/works")
 * Class WorksController
 * @package App\Controller
 * @ORM\Entity
 * @ORM\Table(name="works_controller")
 *
 */
class WorksController extends Controller
{
    /**
     * @Route("/", name="works")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/WorksController.php',
        ]);
    }

    /**
     * @param CallApi $callApi
     * @param string $work
     * @param bool $allowBDD
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/search/{work}", name="search_result")
     * @Method("GET")
     */
    public function searchByName(CallApi $callApi, string $work , $allowBDD = false)
    {

        if($allowBDD){
            $repository = $this->getDoctrine()->getRepository(Works::class);
            $works = $repository->findBy(['title' => '%' . $work . '%']);
        }
        else{
            $works = $callApi->searchResultsWork($work);
        }


        // attention $works doit être du JSON
        return $this->json($works);
    }

    /**
     * @param CallApi $callApi
     * @param int $apiId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/id/{apiId}",name="work_show")
     * @Method("GET")
     */
    public function show(CallApi $callApi, int $apiId)
    {
        $repository = $this->getDoctrine()->getRepository(Works::class);
        $work = $repository->findOneBy(['apiId' => $apiId]);

        if ( $work != null ){
            return $this->json($work);
        }


        $resultApi = $callApi->connect($apiId);
        // donc si pas en base, on l'ajoute dedans avant l'affichage
        // $work = new Works();
        // $work->setXXX()
        // flush




        return $this->json($resultApi);
    }

    /**
     * A déplacer!!!!!!!!!!!!!!!!!!!!!!!!
     *
     * @Route("/author/{string}", name="temp_search_result_author")
     * @param CallApi $callApi
     * @param string $string
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchAuthorAction(CallApi $callApi, string $string)
    {
        $body = $callApi->searchResultAuthor($string);
        return $this->json($body);
    }
}
