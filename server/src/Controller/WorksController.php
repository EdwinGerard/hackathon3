<?php

namespace App\Controller;

use App\Entity\Works;
use App\Service\CallApi;
use App\Service\SerializerService;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    private $serializerService;
    /**
     * WorksController constructor.
     * @param SerializerService $serializerService
     */
    public function __construct(SerializerService $serializerService)
    {
        $this->serializerService = $serializerService;
    }

    /**
     * @param CallApi $callApi
     * @param string $str
     * @param bool $allowBDD
     * @param int $page
     * @param SerializerService $serializerService
     * @return Response
     * @Route("/search/{str}/{page}", name="search_result")
     */
    public function searchByName(CallApi $callApi, string $str, $allowBDD = true, $page = 0)
    {
        $works = null;
        if ($allowBDD) {
            $repository = $this->getDoctrine()->getRepository(Works::class);
            $works = $repository->findByTitleLike($str, $page);
        }
        if (!$allowBDD || !isset($works[0])) {
            $works = $callApi->searchResultsWork($str);
        }

        $data['works'] = $works;
        return $this->serializerService->serialize($data);

    }

    /**
     * @param CallApi $callApi
     * @param int $apiId
     * @return Response
     * @Route("/id/{apiId}",name="work_show")
     * @Method("GET")
     */
    public function show(CallApi $callApi, int $apiId)
    {
        $repository = $this->getDoctrine()->getRepository(Works::class);
        $work = $repository->findOneBy(['apiId' => $apiId]);

        if ($work == null) {
            $resultApi = $callApi->connect($apiId);
            $work = new Works();

            $data['error'] = $work->hydrate($resultApi);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($work);
            $entityManager->flush();

        }

        $data['work'] = $work;

        return $this->serializerService->serialize($data);

    }

    /**
     * @param Works $works
     * @return Response
     * @Route("/badge/{badgeId}",name="show_badge")
     */
    public function showBadge(Works $works)
    {
        $data['work']=$works;

        return $this->serializerService->serialize($data);

    }

    /**
     * @param Request $request
     * @param Works $works
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/edit/{apiId}",name="work_edit")
     * @Method("POST")
     */
    public function edit(Request $request, Works $works)
    {

        $data = $request->query->all();
        $work = new Works();
        $error = $work->hydrate($data);

        if (!empty($error)) {
            dump($error);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($work);
        $entityManager->flush();

        return $this->redirectToRoute('work_show', [
            'apiId' => $works->getApiId()
        ]);
    }


}
