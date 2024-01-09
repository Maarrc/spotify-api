<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class UsuarioController extends AbstractController
{
    public function usuarios(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $usuarios = $this ->getDoctrine()->getRepository(Usuario::class)->findAll();
            $usuarios = $serializer->serialize(
                $usuarios,
                'json',
                ['groups'=>['Usuario']]

            );
            return new Response($usuarios);
        }

        if ($request->isMethod('POST')) {
            
        }

    }

    public function usuario(Request $request, SerializerInterface $serializer)
    {
        
        $id = $request->get('id');
        $usuario = $this->getDoctrine()
        ->getRepository(Usuario::class)
        ->findOneBy(['id'=>$id]);
        if ($request->isMethod('GET')) {

            $usuario = $serializer->serialize(
                $usuario,
                'json',
                ['groups'=>['Usuario']]
            );
            return new Response($usuario);

            
        }


        if ($request->isMethod("PUT")) 
        {
            if(!empty($usuario)){
                $bodydata = $request->getContent();
                $usuario = $serializer->deserialize(
                    $bodydata,
                    Usuario::class,
                    'json',
                    ['object_to_populate' => $usuario ]
                );
                $this->getDoctrine()->getManager()->persist($usuario);
                $this->getDoctrine()->getManager()->flush();
    
                $usuario = $serializer->serialize(
                    $usuario,
                    'json',
                    ['groups'=>['Usuario']]
                );
    
                return new Response($usuario);
            }
            return new JsonResponse(['msg'=> 'usuario not found'], 404);
          
        }

        if ($request->isMethod('DELETE')) {
        

            $usuariodelete = clone $usuario;
            $this->getDoctrine()->getManager()->remove($usuario);
            $this->getDoctrine()->getManager()->flush();

            $usuariodelete = $serializer->serialize(
                $usuariodelete,
                'json',
                ['groups'=>['Usuario']]

            );

            return new Response($usuariodelete);
        }
    }


}
