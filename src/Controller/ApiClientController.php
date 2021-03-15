<?php

namespace App\Controller;

use App\Dto\Transformer\PostResponseDtoTransformer;
use App\Service\CallApiService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClientController extends AbstractController
{

     private PostResponseDtoTransformer $postResponseDtoTransformer;

    public function __construct(PostResponseDtoTransformer $postResponseDtoTransformer)
    {
        $this->postResponseDtoTransformer = $postResponseDtoTransformer;
    }
    /**
     * @Route("/api/client", name="pages.api")
     */
    public function fetchInformation(HttpClientInterface $httpClient): Response
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
         if($response->getStatusCode() == 201){

            $formData = json_decode($response->getContent());
            $this->addFlash('success', 'le post a ete creer avec success');
         }
         else{
             throw new Exception("le post n'a pas ete creer");
         }
       
        //dd($formData);

        return $this->render('pages/api.html.twig', [
            'form' => [$formData],
        ]);
    }

    /**
     * @Route("api/list", name ="pages.list")
     */

    public function listAllPost(CallApiService $callApiService): Response
    {
        //$request = Request::createFromGlobals();
        //$page = $request->query->get('page');
        //dd($page);
        $listPost = $callApiService->getPosts();
        $dto = $this->postResponseDtoTransformer->CollectionPostResponseDto($listPost);
       
       // dd($dto);
        return $this->render('pages/list.html.twig', [
            'posts' => $dto,
        ]);
    }

    /**
     * @Route("api/list/{id}", name ="pages.show")
     */

    public function listPostById(int $id, CallApiService $callApiService)
    {
        //$request = Request::createFromGlobals();
        //$page = $request->query->get('page');
        //dd($page);
        $postById = $callApiService->getPostsById($id);
        return $this->render('pages/show.html.twig', [
            'post' => $postById,
        ]);
    }

    /**
     * @Route("/api/client/addinfo", name="pages.addapi")
     */
    public function ajouterInfo(Request $request,CallApiService $callApiService): Response
    {
        $formData = [
            'title' => $request->query->get("title"),
            'body' => $request->query->get("body"),
        ];
        $formData =  $callApiService->sendPost($formData);
       

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
