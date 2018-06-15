<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Works;
use App\Service\CallApi;
use App\Service\SerializerService;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/search/{str}/{page}/{allowBDD}", name="search_result")
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


            // on recherche si l'autheur exist
            $repositoryAuthor = $this->getDoctrine()->getRepository(Author::class);
            $author = $repositoryAuthor->findOneByApiId($resultApi['authorApiId']);

            $entityManager = $this->getDoctrine()->getManager();

            if ($author == null) {
                $author = new Author();
                $author->hydrate($resultApi['author']);
                $entityManager->persist($author);
                $entityManager->flush();
                $author = $repositoryAuthor->findOneByApiId($resultApi['authorApiId']);
            }

            $work->setAuthor($author);
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
        $data['work'] = $works;

        return $this->serializerService->serialize($data);

    }

    /**
     * @param Works $works
     * @return Response
     * @Route("/editShow/{id}",name="show_edit")
     */
    public function editShow(Works $works)
    {
        $form = $this->createFormBuilder($works)
            ->setAction($this->generateUrl('work_edit', array('apiId' => $works->getApiId())))
            ->setMethod('POST')
            ->add('collection')
            ->add('periodStart')
            ->add('periodEnd')
            ->add('technique')
            ->add('locationName')
            ->add('locationCity')
            ->add('image')
            ->add('title')
            ->add('description',TextareaType::class)
            ->add('descriptionUrl')
            ->add('creationDate',NumberType::class)
            ->add('authorName')
            ->add('authorApiId',NumberType::class)
            ->add('badgeId',NumberType::class)
            ->add('author',EntityType::class, array('class' => Author::class, 'choice_label' => 'name'))
            ->add('authorApiId',NumberType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        return $this->render('works/edit.html.twig', array(
            'work' => $works,
            'form' => $form->createView(),
        ));
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
        $form = $this->createFormBuilder($works)
            ->setAction($this->generateUrl('work_edit', array('apiId' => $works->getApiId())))
            ->setMethod('POST')
            ->add('collection')
            ->add('periodStart')
            ->add('periodEnd')
            ->add('technique')
            ->add('locationName')
            ->add('locationCity')
            ->add('image')
            ->add('title')
            ->add('description',TextareaType::class)
            ->add('descriptionUrl')
            ->add('creationDate',NumberType::class)
            ->add('authorName')
            ->add('authorApiId',NumberType::class)
            ->add('badgeId',NumberType::class)
            ->add('author',EntityType::class, array('class' => Author::class, 'choice_label' => 'name'))
            ->add('authorApiId',NumberType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('work_show', [
            'apiId' => $works->getApiId()
        ]);
    }

}
