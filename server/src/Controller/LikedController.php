<?php

namespace App\Controller;

use App\Entity\Liked;
use App\Entity\Works;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LikedController
 * @package App\Controller
 * @Route("/like")
 */
class LikedController extends Controller
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
     * @Route("/", name="like")
     */
    public function index()
    {
        $session = new Session();
        $session->start();
        $likes=[];
        if (!empty($session->get('clientId'))) {
            $repository = $this->getDoctrine()->getRepository(Liked::class);
            $likes = $repository->findBy(['clientId' => $session->get('clientId')]);
        }

        $data['likes'] = $likes;
        return $this->serializerService->serialize($data);
    }

    /**
     * @param Works $work
     * @param $isLike
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/{isLike}",name="add_like")
     */
    public function addLike(Works $work, $isLike)
    {
        $session = new Session();
        $session->start();
        if (empty($session->get('clientId'))) {
            $clientId = uniqid();
            $session->set('clientId', $clientId);
        }
        $clientId = $session->get('clientId');
        $repository = $this->getDoctrine()->getRepository(Liked::class);

        $like = $repository->findOneBy(['clientId' => $clientId, 'works' => $work]);
        if ($like == null) {
            $like = new Liked();
        }
        $like->setClientId($clientId);
        $like->setLikeIt($isLike);
        $like->setWorks($work);
        $em = $this->getDoctrine()->getManager();
        $em->persist($like);
        $em->flush();


        return $this->redirectToRoute('work_show', ['apiId' => $work->getApiId()]);
    }


}
