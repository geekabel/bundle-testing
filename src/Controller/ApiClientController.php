<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClientController extends AbstractController
{
    /**
     * @Route("/api/client", name="pages.api")
     */
    public function fetchGitHubInformation(HttpClientInterface $httpClient): Response
    {

        $formData = [
            'title' => 'mon premier titre',
            'body' => 'le contenu de test fictif deuxieme partie',
        ];

        $httpClient = HttpClient::create();
        //$numberOfresults = 30;
        $url = 'https://jsonplaceholder.typicode.com/posts';

        $response = $httpClient->request('POST', $url, [

            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],

            'json' => $formData,
        ]);

        $formData = json_decode($response->getContent());
        //dd($formData);

        return $this->render('pages/api.html.twig', [
            'form' => [$formData],
        ]);
    }

    /**
     * @Route("api/list", name ="pages.list")
     */

    public function listAllPost(HttpClientInterface $httpClient, Request $request)
    {
        //$request = Request::createFromGlobals();
        //$page = $request->query->get('page');
        //dd($page);
        $httpClient = HttpClient::create();

        $url = 'https://jsonplaceholder.typicode.com/posts';

        $apiResponse = $httpClient->request('GET', $url, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($apiResponse->getStatusCode() == 200) {
            $listPost = $apiResponse->getContent();
            $listPost = $apiResponse->toArray();
        } else {
            throw new Exception('La requete nas pas abouti');
        }

        return $this->render('pages/list.html.twig', [
            'posts' => $listPost,
        ]);
    }
    /**
     * @Route("api/list/{id}", name ="pages.show")
     */

    public function listPostById(int $id, HttpClientInterface $httpClient)
    {
        //$request = Request::createFromGlobals();
        //$page = $request->query->get('page');
        //dd($page);
        $httpClient = HttpClient::create();

        $url = 'https://jsonplaceholder.typicode.com/posts/' . $id;

        $apiResponse = $httpClient->request('GET', $url, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($apiResponse->getStatusCode() == 200) {
            $PostById = $apiResponse->getContent();
            $PostById = $apiResponse->toArray();
            //dd($PostById);
        } else {
            throw new Exception('La requete nas pas abouti');
        }

        return $this->render('pages/show.html.twig', [
            'post' => $PostById,
        ]);
    }

    /**
     * @Route("/api/client/addinfo", name="pages.addapi")
     */
    public function ajouterInfo(Request $request, HttpClientInterface $httpClient): Response
    {
        $formData = [
            'title' => $request->query->get("title"),
            'body' => $request->query->get("body"),
        ];

        $httpClient = HttpClient::create();
        //$numberOfresults = 30;
        $url = 'https://jsonplaceholder.typicode.com/posts';

        $response = $httpClient->request('POST', $url, [

            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],

            'json' => $formData,
        ]);

        $formData = json_decode($response->getContent());
        //dd($formData);

        return $this->render('pages/api.html.twig', [
            'form' => [$formData],
        ]);
    }

    /**
     * @Route("/api/client/updatenfo", name="pages.updateapi")
     */
    public function modifierInfo(Request $request, HttpClientInterface $httpClient): Response
    {
        $formData = [
            'id' => $request->query->get("id"),
            'userId' => $request->query->get("userId"),
            'title' => $request->query->get("title"),
            'body' => $request->query->get("body"),
        ];

        $httpClient = HttpClient::create();
        //$numberOfresults = 30;
        //la concatenation
        $url = 'https://jsonplaceholder.typicode.com/posts/' . $request->query->get("id");

        $response = $httpClient->request('PUT', $url, [

            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],

            'json' => $formData,
        ]);

        if ($response->getStatusCode() == 200) {
            $formData = json_decode($response->getContent());
        }

        //dd($formData);

        return $this->render('pages/api_update.html.twig', [
            'form' => [$formData],
        ]);
    }

    /**
     * @Route("/api/client/deleteinfo", name="pages.deleteapi")
     */
    public function supprimerInfo(Request $request, HttpClientInterface $httpClient): Response
    {

        $httpClient = HttpClient::create();
        //$numberOfresults = 30;
        //la concatenation
        $url = 'https://jsonplaceholder.typicode.com/posts/' . $request->query->get("id");

        $response = $httpClient->request('DELETE', $url);

        if ($response->getStatusCode() == 200) {
            $formData = json_decode($response->getContent());
        }

        //dd($formData);

        return $this->render('pages/api_delete.html.twig');
    }

}
