<?php

namespace App\Controller;

use App\Entity\Capitulo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CapitulosController extends AbstractController
{
    public function capitulos(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')){
            $id_podcast = $request->get('id');
            
            $capitulos_podcast = $this->getDoctrine()->getRepository(Capitulo::class)->findBy(['podcast'=>$id_podcast]);

            $capitulos_podcast = $serializer->serialize(
                $capitulos_podcast,
                'json',
                ['groups'=>['Capitulos', 'Podcast']]

            );
            return new Response($capitulos_podcast);
        

        }
    
    }

    public function capitulo(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')){
            $id_podcast = $request->get('id');
            $id_capitulo = $request->get('id_capitulo');
            
            $capitulos_podcast = $this->getDoctrine()->getRepository(Capitulo::class)->findBy(['podcast'=>$id_podcast, 'id'=>$id_capitulo]);

            $capitulos_podcast = $serializer->serialize(
                $capitulos_podcast,
                'json',
                ['groups'=>['Capitulos', 'Podcast']]

            );
            return new Response($capitulos_podcast);
        

        }
    }
}