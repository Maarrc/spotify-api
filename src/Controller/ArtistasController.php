<?php

namespace App\Controller;

use App\Entity\Artista;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ArtistasController extends AbstractController
{
    public function artistas(Request $request, SerializerInterface $serializer)
    {
        
        if ($request->isMethod('GET')){
            $artista = $this->getDoctrine()->getRepository(Artista::class)->findAll();

            $artista = $serializer->serialize(
                $artista,
                'json',
                ['groups'=>['Artistas']]

            );
            return new Response($artista);


        }
    }
}