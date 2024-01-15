<?php

namespace App\Controller;

use App\Entity\Album;
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


    public function artista_albums(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')){
            $id_artista = $request->get('id');
            
            $album_artista = $this->getDoctrine()->getRepository(Album::class)->findBy(['artista'=>$id_artista]);

            $albums = $serializer->serialize(
                $album_artista,
                'json',
                ['groups'=>['Album', 'Artistas']]

            );
            return new Response($albums);
            

            

            





        }
    }


    public function artista_album(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')){
            $id_artista = $request->get('id');

            $id_album = $request->get('id_album');
            
            $album_artista = $this->getDoctrine()->getRepository(Album::class)->findBy(['artista'=>$id_artista, 'id'=>$id_album]);

            $albums = $serializer->serialize(
                $album_artista,
                'json',
                ['groups'=>['Album', 'Artistas']]

            );
            return new Response($albums);
        }
    }
}