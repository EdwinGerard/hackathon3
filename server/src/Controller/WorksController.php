<?php

namespace App\Controller;

use App\Entity\Works;
use App\Service\CallApi;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Service\CallApi;

/**
 * @Route("/works")
 * Class WorksController
 * @package App\Controller
 * @ORM\Entity
 * @ORM\Table(name="works_controller")
 * @ORM\Embedded
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
     * @Route("/{work}", name="search_result")
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
        $works = json_encode($works);
        return $this->json($works);
    }

    public function show(CallApi $callApi, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Works::class);
        $work = $repository->findOneBy(['apiId' => $id]);

        if ( $work != null ){
            return $this->json($work);
        }


        $resultApi = $callApi->connect($id);
        // donc si pas en base, on l'ajoute dedans avant l'affichage
        // $work = new Works();
        // $work->setXXX()
        // flush




        return $this->json($resultApi);
    }
}
