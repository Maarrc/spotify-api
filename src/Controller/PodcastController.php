<?php

namespace App\Controller;

use App\Entity\Podcast;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class PodcastController extends AbstractController
{
    public function podcasts(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $podcasts = $this ->getDoctrine()->getRepository(Podcast::class)->findAll();
            $podcasts = $serializer->serialize(
                $podcasts,
                'json',
                ['groups'=>['Podcast']]

            );
            return new Response($podcasts);
        }
    }

    public function podcast(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {

            $id = $request->get('id');
            $podcast = $this->getDoctrine()
            ->getRepository(Podcast::class)
            ->findOneBy(['id'=>$id]);

            $podcast = $serializer->serialize(
                $podcast,
                'json',
                ['groups'=>['Podcast']]
            );
            return new Response($podcast);

            
        }
    }

    public function podcast_usuario(Request $request, SerializerInterface $serializer)
    {
        $id = $request->get("id");
        $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id"=>$id]);
        if ($request->isMethod('GET')) {
            $podcastUsuario = $serializer->serialize($usuario->getPodcast(), 'json', ['groups'=>['Podcast']]);
            return new Response($podcastUsuario);
        } 
    }

    public function podcasts_usuario(Request $request, SerializerInterface $serializer)
    {
        $id = $request->get("id");
        $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id"=>$id]);
        $podcast_id = $request->get("id_podcast");
        $podcast = $this->getDoctrine()->getRepository(Podcast::class)->findOneBy(["id"=>$podcast_id]);

        if ($request->isMethod('POST')) {
            $podcasts = $usuario->getPodcast();
            $podcasts->add($podcast);

            $usuario->setPodcast($podcasts);

            $this->getDoctrine()->getManager()->persist($usuario);
            $this->getDoctrine()->getManager()->flush();
            
            return new JsonResponse(['msg' => 'Has comenzado a seguir el podcast']);
        }

        if ($request->isMethod('DELETE')) {
            $podcasts = $usuario->getPodcast();
            $podcasts->removeElement($podcast);

            $usuario->setPodcast($podcasts);

            $this->getDoctrine()->getManager()->persist($usuario);
            $this->getDoctrine()->getManager()->flush();
            
            return new JsonResponse(['msg' => 'Has dejado a seguir el podcast']);
        }
    }
}