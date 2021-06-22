<?php

namespace App\Controller;


use Exception;
use App\Entity\Post;
use App\Form\PostEntityType;
use App\Service\CallApiService;
use PhpParser\Node\Expr\Cast\Object_;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\Transformer\PostResponseDtoTransformer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
class ApiClientController extends AbstractController
{

     private PostResponseDtoTransformer $postResponseDtoTransformer;
     private $em;
    public function __construct(PostResponseDtoTransformer $postResponseDtoTransformer, EntityManagerInterface $em)
    {
        $this->postResponseDtoTransformer = $postResponseDtoTransformer;
        $this->em = $em;
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
        //dd($postdata);
        //$numberOfresults = 30;
        //  if($postdata->getStatusCode() == 200){

        //     $formData = json_decode($postdata->getContent());
        //     //$this->addFlash('success', 'le post a ete creer avec success');
        //  }
        //  else{
        //      throw new Exception("le post n'a pas ete creer");
        //  }
       
        //dd($formData);

        return $this->render('pages/api.html.twig', [
            'form' => $postdata,
        ]);
    }

    /** liste tout les post via le processus de DTO/deserialisation
     * @Route("api/list", name ="pages.list")
     * @param CallApiService $callApiService
     */

    public function listAllPost(CallApiService $callApiService, PaginatorInterface $paginator, Request $request): Response
    {
        
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
        //Recuperation des données issues du service
        $listPost = $callApiService->getPosts();
        
        //Passage en Objet(conversion)
        //$data = $this->postResponseDtoTransformer->CollectionPostResponseDto($listPost);
       
         $data  = $serializer->deserialize($listPost,'App\Entity\Post[]','json');
            //dd($data,$listPost);
       
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

    public function listPostById(int $id, CallApiService $callApiService, SerializerInterface $serializer)
    {
        
        $postById = $callApiService->getPostsById($id);
        $data = $serializer->deserialize($postById,Post::class,'json');
        //dd($data);
        //dd($postById);
        return $this->render('pages/show.html.twig', [
            'post' => $data,
        ]);
    }

   

    // /**
    //  * @Route("/api/client/updatenfo", name="pages.updateapi")
    //  */
    // public function modifierInfo(Request $request, HttpClientInterface $httpClient): Response
    // {
    //     $formData = [
           
    //         'title' => $request->query->get("title"),
    //         'body' => $request->query->get("body"),
    //     ];  

    //     $httpClient = HttpClient::create();
    //     //$numberOfresults = 30;
    //     //la concatenation
    //     $url = 'https://jsonplaceholder.typicode.com/' . $request->query->get("id");

    //     $response = $httpClient->request('PUT', $url, [

    //         'headers' => [
    //             'Accept-type' => 'application/json',
    //             'Content-Type' => 'application/json',
    //         ],

    //         'json' => $formData,
    //     ]);

    //     if ($response->getStatusCode() == 200) {
    //         $formData = json_decode($response->getContent());
    //     }

    //     //dd($formData);

    //     return $this->render('pages/api_update.html.twig', [
    //         'form' => [$formData],
    //     ]);
    // }


  /**
     * @Route("/api/post/update/{id}", name="pages.updateapi")
     */
    public function modifierInfo(Request $request, CallApiService $callApiService, int $id, SerializerInterface $serializer): Response
    {
        //Recuperation des données issues du service
         $infosApi = $callApiService->getPostsById($id);
         //dd($infosApi);
       // j'insere les donées dans un oject Post      
         $data  = $serializer->deserialize($infosApi,Post::class,'json');
        //$data = $this->postResponseDtoTransformer->CollectionPostResponseDto($infosApi);
       //dd($data);
       $form = $this->createForm(PostEntityType::class,$data);
       $form->handleRequest($request);
       //dd($form);

        if($form->isSubmitted() && $form->isValid()){
        $serializer = new Serializer([new ObjectNormalizer()]);
        $requete = $serializer->normalize($data,null);
        //dd($requete);
            //$this->em->flush();
         $callApiService->editPosts($id,$requete);
        }
        
        //dd($formData);

        return $this->render('pages/api_update.html.twig', [
            "data" => $data,
            "form_update" => $form->createView(),
        ]);
    }
    // /**
    //  * @Route("/api/client/deleteinfo", name="pages.deleteapi")
    //  */
    // public function supprimerInfo(Request $request, HttpClientInterface $httpClient): Response
    // {

    //     $httpClient = HttpClient::create();
    //     //$numberOfresults = 30;
    //     //la concatenation
    //     $url = 'https://microjobs-api.herokuapp.com/microjobs/' . $request->query->get("id");

    //     $response = $httpClient->request('DELETE', $url);

    //     if ($response->getStatusCode() == 200) {
    //         $formData = json_decode($response->getContent());
    //     }

    //     //dd($formData);

    //     return $this->render('pages/api_delete.html.twig');
    // }

     /**
     * @Route("/api/client/deleteinfo", name="pages.deleteapi")
     */
    public function supprimerInfo(Request $request, CallApiService $callApiService, int $id, SerializerInterface $serializer): Response
    {
        // if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
        $apiInfos = $callApiService->getPostsById($id);
        $data  = $serializer->deserialize($apiInfos,Post::class,'json');
        //dd($formData);

        return $this->render('pages/api_delete.html.twig');
    }

    /**
     * @Route("/api/client/images" , name="pages.download")
     *
     * @param CallApiService $callApiService
     * @return $microjobs
     */
    // public function downladImages(CallApiService $callApiService)
    // {
    //     //Appel l'api depuis le service
    //    $download = $callApiService->getImages();
    //     return $this->render('pages/download.html.twig', [
    //         'infos' => $download,
    //     ]);
    // }

}
