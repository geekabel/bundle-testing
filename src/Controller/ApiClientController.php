<?php

namespace App\Controller;


use App\Dto\Transformer\PostResponseDtoTransformer;
use App\Service\CallApiService;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
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
    public function fetchInformation(CallApiService $callApiService): Response
    {

        $formData = [
            'title' => 'mon premier titre',
            'body' => 'le contenu de test fictif deuxieme partie',
        ];
        $postdata = $callApiService->sendPost($formData);
        
        //$numberOfresults = 30;
         if($postdata->getStatusCode() == 201){

            $formData = json_decode($postdata->getContent());
            //$this->addFlash('success', 'le post a ete creer avec success');
         }
         else{
             throw new Exception("le post n'a pas ete creer");
         }
       
        //dd($formData);

        return $this->render('pages/api.html.twig', [
            'form' => [$postdata],
        ]);
    }

    /** liste tout les post via le processus de DTO
     * @Route("api/list", name ="pages.list")
     * @param CallApiService $callApiService
     */

    public function listAllPost(CallApiService $callApiService, PaginatorInterface $paginator, Request $request): Response
    {
        
        //Recuperation des données issues du service
        $listPost = $callApiService->getPosts();
        //Passage en Objet(conversion)
        $data = $this->postResponseDtoTransformer->CollectionPostResponseDto($listPost);
        
        //Utilisation du Bundle KnpPaginator et de la donnee
        $dto = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
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
     * @Route("/api/client/updatenfo", name="pages.updateapi")
     */
    public function modifierInfo(Request $request, HttpClientInterface $httpClient): Response
    {
        $formData = [
           
            'title' => $request->query->get("title"),
            'body' => $request->query->get("body"),
        ];

        $httpClient = HttpClient::create();
        //$numberOfresults = 30;
        //la concatenation
        $url = 'https://jsonplaceholder.typicode.com/' . $request->query->get("id");

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
        $url = 'https://microjobs-api.herokuapp.com/microjobs/' . $request->query->get("id");

        $response = $httpClient->request('DELETE', $url);

        if ($response->getStatusCode() == 200) {
            $formData = json_decode($response->getContent());
        }

        //dd($formData);

        return $this->render('pages/api_delete.html.twig');
    }
    /**
     * @Route("/api/client/microjobs" , name="pages.microjobs")
     *
     * @param CallApiService $callApiService
     * @return $microjobs
     */
    /*public function listMicrojobs(CallApiService $callApiService)
    {
        $microjobs = $callApiService->getUser();
        dd($microjobs);
    return $this->render('pages/microjobs.html.twig',[
            'microjobs'=> $microjobs
    ]);

    }*/

}
