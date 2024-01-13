<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Cancion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AlbumsController extends AbstractController
{
    public function albums(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $albums = $this ->getDoctrine()->getRepository(Album::class)->findAll();
            $albums = $serializer->serialize(
                $albums,
                'json',
                ['groups'=>['Album', 'Artistas']]

            );
            return new Response($albums);
        }
    }

    public function album(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {

            $id = $request->get('id');
            $album = $this->getDoctrine()
            ->getRepository(Album::class)
            ->findOneBy(['id'=>$id]);

            $album = $serializer->serialize(
                $album,
                'json',
                ['groups'=>['Album', 'Artistas']]
            );
            return new Response($album);

            
        }
    }

    public function album_canciones(Request $request, SerializerInterface $serializer)
    {
        $id_album = $request->get('id');
        $canciones = $this ->getDoctrine()->getRepository(Cancion::class)->findBy(['album'=>$id_album]);
        $canciones = $serializer->serialize($canciones, 'json', ['groups'=>['Cancion']]);
        return new Response($canciones);
    }
}