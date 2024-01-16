<?php

namespace App\Controller;

use App\Entity\Configuracion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ConfiguracionController extends AbstractController
{
    public function usuario_configuracion(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')){
            $id_usuario = $request->get('usuario_id');
            
            $configuracion_usuario = $this->getDoctrine()->getRepository(Configuracion::class)->findBy(['usuario'=>$id_usuario]);

            $configuracion_usuario = $serializer->serialize(
                $configuracion_usuario,
                'json',
                ['groups'=>['Configuraciones', 'Usuario', 'Calidad', 'Idioma', 'TipoDescarga']]

            );
            return new Response($configuracion_usuario);
        

        }

        if ($request->isMethod('PUT')){
            $id_usuario = $request->get('usuario_id');
            $configuracion_usuario = $this->getDoctrine()->getRepository(Configuracion::class)->findBy(['usuario'=>$id_usuario]);

            if (!empty($configuracion_usuario)){
                $bodydata = $request->getContent();
                $configuracion_usuario = $serializer->deserialize(
                    $bodydata,
                    Configuracion::class,
                    'json',
                    ['object_to_populate' => $configuracion_usuario ]
                );
                $this->getDoctrine()->getManager()->persist($configuracion_usuario);
                $this->getDoctrine()->getManager()->flush();

                $configuracion_usuario = $serializer->serialize(
                    $configuracion_usuario,
                    'json',
                    ['groups'=>['Configuraciones', 'Usuario', 'Calidad', 'Idioma', 'TipoDescarga']]
    
                );

                return new Response($configuracion_usuario);
            }
            return new JsonResponse(['msg'=> 'usuario not found'],404);
        }
    }

}