<?php

namespace App\Controller;

use App\Entity\Eliminada;
use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PlaylistsController extends AbstractController
{
    public function playlists(Request $request, SerializerInterface $serializer)
    {

        if($request->isMethod('GET'))
        {
            $playlists = $this->getDoctrine()->getRepository(Playlist::class)->findAll();

            $playlists = $serializer->serialize(
                $playlists,
                'json',
                ['groups'=>['Playlist']]

            );
            return new Response($playlists);
        }

        if($request->isMethod('POST'))
        {

        }
        
    }


    public function playlists_usuario(Request $request, SerializerInterface $serializer)
    {

        if($request->isMethod('GET'))
        {
            $id_usuario = $request->get('id');
            $playlists = $this->getDoctrine()->getRepository(Playlist::class)->findBy(['usuario'=>$id_usuario]);

            $playlists = $serializer->serialize(
                $playlists,
                'json',
                ['groups'=>['Playlist', 'Usuario']]

            );
            return new Response($playlists);

        }
        

    }

    public function playlist(Request $request, SerializerInterface $serializer)
    {
        if($request->isMethod('GET'))
        {   
            $id = $request->get('id');
            $playlist = $this->getDoctrine()->getRepository(Playlist::class)->findOneBy(['id'=>$id]);
            
            $playlist = $serializer->serialize(
                $playlist,
                'json',
                ['groups'=>['Playlist']]

            );
            return new Response($playlist);
        }
    }


    public function playlist_usuario (Request $request, SerializerInterface $serializer)
    {
        $id_usuario = $request->get('id');
        $id_playlist = $request->get('id_playlist');

        if($request->isMethod('GET'))
        {
            $playlist = $this->getDoctrine()->getRepository(Playlist::class)->findBy(['id'=>$id_playlist, 'usuario' => $id_usuario]);
        
            $playlist = $serializer->serialize(
                $playlist,
                'json',
                ['groups'=>['Playlist', 'Usuario']]

            );
            return new Response($playlist);

        }

        if($request->isMethod('DELETE'))
        {
            $playlist = $this->getDoctrine()->getRepository(Playlist::class)->findOneBy(['id'=>$id_playlist, 'usuario' => $id_usuario]); 
            $hoy = getdate();



            $this->getDoctrine()->getManager(Eliminada::class)->persist($hoy, $playlist);
            $this->getDoctrine()->getManager(Eliminada::class)->flush();

            
        
        
        }
    }
}