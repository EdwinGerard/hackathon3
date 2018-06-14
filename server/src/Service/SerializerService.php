<?php
/**
 * Created by PhpStorm.
 * User: wilder10
 * Date: 14/06/18
 * Time: 19:35
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerService
{
    /**
     * @param array $data
     * @return Response
     */
    public function serialize(array $data)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->serialize($data, 'json');
        $response = $this->jsonResponse($data);
        return $response;
    }

    private function jsonResponse($data)
    {
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}