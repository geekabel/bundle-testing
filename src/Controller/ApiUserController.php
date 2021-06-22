<?php

namespace App\Controller;

use App\Entity\User;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user", methods={"GET","POST"})
     */
    public function create(Request $request, SerializerInterface $serializer): Response
    {
        //Avec post
        $jsonRecu = $request->getContent();
        
        $user = $serializer->deserialize($jsonRecu, User::class, 'json');
        dd($user);
        /* return $this->render('api_user/index.html.twig', [
        'controller_name' => 'ApiUserController',
        ]);*/
        //return new Response('utilisateur sauve avec succes' . $user->getId());
    }
}
