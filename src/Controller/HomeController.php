<?php
namespace App\Controller;

use App\Repository\CompagnyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name ="home")
     *@param  CompagnyRepository $repository
     * @return Response
     */
 public function index(CompagnyRepository $repository): Response 
 {
        $compagnies = $repository->findLatest();

        return $this->render('pages/home.html.twig', [
            'companies' => $compagnies,
        ]);

 }

}