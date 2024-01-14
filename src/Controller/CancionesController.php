<?php

namespace App\Controller;

use App\Entity\AnyadeCancionPlaylist;
use App\Entity\Cancion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CancionesController extends AbstractController
{
    public function canciones(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $canciones = $this ->getDoctrine()->getRepository(Cancion::class)->findAll();
            $canciones = $serializer->serialize(
                $canciones,
                'json',
                ['groups'=>['Cancion']]

            );
            return new Response($canciones);
        }
    }

    public function cancion(Request $request, SerializerInterface $serializer)
    {
        $id = $request->get('id');
        if ($request->isMethod('GET')) {
            $cancion = $this ->getDoctrine()->getRepository(Cancion::class)->findOneBy(['id'=> $id]);
            $cancion = $serializer->serialize(
                $cancion,
                'json',
                ['groups'=>['Cancion']]

            );
            return new Response($cancion);
        }
    }

    public function canciones_playlist(Request $request, SerializerInterface $serializer)
    {
        $idPlaylist = $request->get('id');
        if ($request->isMethod('GET')) {
            $playlist = $this ->getDoctrine()->getRepository(AnyadeCancionPlaylist::class)->findBy(['playlist'=> $idPlaylist]);
            $idCanciones = [];
            foreach ($playlist as $play) {
                $idCanciones [] = $play->getCancion();
            }
            $canciones = [];

            foreach($idCanciones as $cancion) {
                $can = $this ->getDoctrine()->getRepository(Cancion::class)->findOneBy(['id'=> $cancion]);
                $canciones [] = $can;
                
            }
            $canciones = $serializer->serialize(
                $canciones,
                'json',
                ['groups'=>['Cancion']]

            );
            return new Response($canciones);
        }
    }

    public function cancion_playlist(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('POST')) {

        }

        if ($request->isMethod('DELETE')) {
            
        }
    }
}