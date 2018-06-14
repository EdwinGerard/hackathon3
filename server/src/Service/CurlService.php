<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 14/06/18
 * Time: 10:23
 */

namespace App\Service;


class CurlService
{
    /**
     * Create request to API and return all results
     * @param string $param
     * @param $request
     * @return mixed
     */
    public function generateAPiUrl(string $param, $request)
    {
        if (is_int($request)) {
            $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/'.$param.'/'.$request;
        }else {
            $request = urlencode($request);
            $wikipediaURL = 'https://api.art.rmngp.fr:443/v1/'.$param.'?q='.$request;
        }
        $apiKey = '210ccc2ea7fc69e80d2bcd929ed801d4d19f21675addf8541be51da48e2b19d8';
        $headers = array(
            'Authorization: ' . $apiKey,
            'ApiKey:' . $apiKey,
        );
        $ch = curl_init();
        //On lui transmet la variable qui contient l'URL
        curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
        //On lui demdande de nous retourner la page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //On envoie un user-agent pour ne pas être considéré comme un bot malicieux
        //On exécute notre requête et met le résultat dans une variable
        $resultat = curl_exec($ch);
        //On ferme la connexion cURL
        curl_close($ch);
        //echo $resultat;
        $resf = json_decode($resultat);

        return $resf;

    }

}