<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    /**
     *
     * @Route("/api/client/addinfo", name="pages.addapi")
     */
    public function ajouterInfo(Request $request, CallApiService $callApiService): Response
    {

        $formData = [
            'title' => $request->query->get("title"),
            'body' => $request->query->get("body"),
        ];
        /*$form = $this->buildForm(PostType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {

        throw new Exception("Formulaire non valide");
        //print 'Form is not valid';
        //exit();
        }
        // On recupere la donnée provenant du formulaire !!! youpi
        $formData = $form->getData();
        dd($formData);*/
        //On renvoit les donnees via l'api en post

        //** @var PostResponseDto $addinfo */
        $addinfo = $callApiService->sendPost($formData);
        return $this->render('pages/api.html.twig', [
            'form' => [$addinfo],
        ]);
    }

}
