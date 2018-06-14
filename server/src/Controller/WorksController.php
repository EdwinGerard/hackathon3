<?php

namespace App\Controller;

use App\Entity\Works;
use App\Service\CallApi;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
    public function searchByName(CallApi $callApi, string $work, $allowBDD = false)
    {

        if ($allowBDD) {
            $repository = $this->getDoctrine()->getRepository(Works::class);
            $works = $repository->findBy(['title' => '%' . $work . '%']);
        } else {
            $works = $callApi->searchResultsWork($work);
        }

        return $this->json($works);
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

            $work->hydrate($resultApi);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($work);
            $entityManager->flush();

        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($work, 'json');

        return new Response($jsonContent);
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
