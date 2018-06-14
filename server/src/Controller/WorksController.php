<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/works")
 * Class WorksController
 * @package App\Controller
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
     * @Route("/{string}", name="search_result")
     * @Method("GET")
     */
    public function searchByName(CallApi $callApi, string $string)
    {

    }
}
