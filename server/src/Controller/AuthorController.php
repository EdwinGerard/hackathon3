<?php

namespace App\Controller;

use App\Entity\Author;
use App\Service\SerializerService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class AuthorController
 * @package App\Controller
 * @Route("/author")
 */
class AuthorController extends Controller
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
     * @param Author $author
     * @param SerializerService $serializerService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="author")
     */
    public function index(SerializerService $serializerService)
    {
        $rep = $this->getDoctrine()->getRepository(Author::class);
        $data = $rep->findAll();

        return $this->serializerService->serialize($data);
    }

    /**
     * @param Author $author
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}",name="show_author")
     */
    public function showAction(Author $author)
    {
        $data['author']=$author;
        return $this->serializerService->serialize($data);
    }

    /**
     * @param Author $author
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/api/{apiId}",name="show_author_api")
     */
    public function showByApiId(Author $author)
    {
        $data['author']=$author;
        return $this->serializerService->serialize($data);
    }

//    /**
//     * @param CallApi $callApi
//     * @param string $name
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     * @Route("/author/show/{name}", name="show_author")
//     */
//    public function show(CallApi $callApi, string $name)
//    {
//        $repository = $this->getDoctrine()->getRepository(Author::class);
//
//        $author = $repository->findOneBy(['name' => $name]);
//
//        if ( $author != null ){
//            return $this->json($author);
//        }
//
//
//        $resultApi = $callApi->findAuthor($name);
//        $author = new Author();
//
//        $author->hydrate($resultApi);
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($author);
//        $entityManager->flush();
//
//
//
//
//
//        return $this->json($resultApi);
//
//    }

//    /**
//     * @Route("/author/search/{string}", name="temp_search_result_author")
//     * @param CallApi $callApi
//     * @param string $string
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     */
//    public function searchAuthorAction(CallApi $callApi, string $string)
//    {
//        $body = $callApi->searchResultAuthor($string);
//        return $this->json($body);
//    }

}
