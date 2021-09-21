<?php

namespace App\Controller;

use App\Entity\Compagny;
use App\Repository\CompagnyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompagnyController extends AbstractController
{
    /**
     * @var CompagnyRepository
     */
    private  $repository;
    private $em;

    public function __construct(CompagnyRepository $repository){
        $this->repository = $repository;
    }

    /**
     * @Route("/compagny", name ="compagny.index")
     * @return Response
     */
    public function index(CompagnyRepository $repository): Response
    {

    //$repository = $this->getDoctrine()->getRepository(Compagny::class);
    $compagny = $repository->findAll();
    dump($compagny);
    
    return $this->render('compagny/index.html.twig', [
           'menu' => 'companies',
       ]);
    }

    /**
     * 
     *@Route("/compagny/{slug}-{id}", name ="compagny.show", requirements={"slug"="[a-z0-9\-]*"})
     * @param Compagny $compagny
     * @return Response
     */
    public function show(Compagny $compagny, string $slug): Response
    {
      
        if($compagny->getSlug() !== $slug){
            $this->redirectToRoute('compagny.show',[
            'id' => $compagny->getId(),
            'slug' => $compagny->getSlug(), 
            ],301);
        }
        return $this->render('compagny/show.html.twig',[
            'compagny' => $compagny,
            'menu' => 'companies',
        ]);
    }
}



