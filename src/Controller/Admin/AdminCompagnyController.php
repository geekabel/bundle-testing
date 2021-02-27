<?php

namespace App\Controller\Admin;

use App\Entity\Compagny;
use App\Form\CompagnyType;
use App\Repository\CompagnyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminCompagnyController extends AbstractController
{

    private $repository;
    /**
     *
     * @var ObjectManager
     */
    private $em;

    public function __construct(CompagnyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    

    /**
     * @Route("/admin", name="admin.compagny.index")
     *
     * @return Response
     */
    public function index()
    {

            $compagnies =  $this->repository->findAll();

            return $this->render('admin/compagny/index.html.twig' ,compact('compagnies'));
    }
        /**
         * @Route("/admin/compagny/create",name="admin.compagny.new")
         *
         * @return void
         */
        public function new(Request $request)
        {
            $compagny = new Compagny();
            $form = $this->createForm(CompagnyType::class,$compagny);
            $form->handleRequest($request);
  
            if($form->isSubmitted() && $form->isValid()){
                $this->em->persist($compagny);
                $this->em->flush();
              return $this->redirectToRoute('admin.compagny.index');
            }
               return $this->render('admin/compagny/new.html.twig',[
                  'compagny' => $compagny,
                  'form' => $form->createView(),
               ]);
        }
        /**
         * @Route("/admin/compagny/{id}", name="admin.compagny.edit")
         *@param Compagny $compagny
         * 
         */
        public function edit(Compagny $compagny, Request $request)
        {
    
          $form = $this->createForm(CompagnyType::class,$compagny);
          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('admin.compagny.index');
          }
             return $this->render('admin/compagny/edit.html.twig',[
                'compagny' => $compagny,
                'form' => $form->createView(),
             ]);
        }
}