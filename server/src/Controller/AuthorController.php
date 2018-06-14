<?php

namespace App\Controller;

use App\Entity\Author;
use App\Service\CallApi;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthorController extends Controller
{
    /**
     * @Route("/author", name="author")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    /**
     * @param CallApi $callApi
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/author/show/{name}", name="show_author")
     */
    public function show(CallApi $callApi, string $name)
    {
        $repository = $this->getDoctrine()->getRepository(Author::class);

        $author = $repository->findOneBy(['name' => $name]);

        if ( $author != null ){
            return $this->json($author);
        }


        $resultApi = $callApi->findAuthor($name);
        $author = new Author();

        $author->hydrate($resultApi);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($author);
        $entityManager->flush();





        return $this->json($resultApi);

    }

    /**
     * @Route("/author/search/{string}", name="temp_search_result_author")
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
