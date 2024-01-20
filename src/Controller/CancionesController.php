<?php

namespace App\Controller;

use App\Entity\AnyadeCancionPlaylist;
use App\Entity\Cancion;
use App\Entity\Playlist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Usuario;

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
        $idPlaylist = $request->get('id');
        $idCancion = $request->get('id_cancion');
        $playlist = $this ->getDoctrine()->getRepository(Playlist::class)->findOneBy(['id'=> $idPlaylist]);
        $cancion = $this ->getDoctrine()->getRepository(Cancion::class)->findOneBy(['id'=> $idCancion]);
        if ($request->isMethod('POST')) {
            $id = $request->getContent();
            $idUsu = $serializer->deserialize(
                $id,
                Usuario::class,
                'json'
            );
            $usuarioAnyade = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(['id'=> $idUsu]);

            $anyadeCancion = new AnyadeCancionPlaylist();
            $anyadeCancion->setCancion($cancion);
            $anyadeCancion->setPlaylist($playlist);
            $anyadeCancion->setUsuario($usuarioAnyade);
            $anyadeCancion->setFechaAnyadida(new \DateTime());

            $this->getDoctrine()->getManager()->persist($anyadeCancion);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(['msg' => 'Has añadido la cancion a la playlist']);

            
        }

        if ($request->isMethod('DELETE')) {
            $id = $request->getContent();
            $idUsu = $serializer->deserialize(
                $id,
                Usuario::class,
                'json'
            );
            $usuarioAnyade = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(['id'=> $idUsu]);
            
            $anyadeCancion = $this->getDoctrine()->getRepository(AnyadeCancionPlaylist::class)->findOneBy(['cancion'=>$cancion, 'playlist'=>$playlist, 'usuario'=>$usuarioAnyade]);

            $this->getDoctrine()->getManager()->remove($anyadeCancion);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(['msg' => 'Has eliminado la cancion de la playlist']);
        }
    }
}