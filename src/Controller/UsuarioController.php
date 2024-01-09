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
                ['group'=>['Usuario']]

            );
            return new Response($usuarios);
        }

        if ($request->isMethod('POST')) {
            
        }

    }

    public function usuario(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {

            $id = $request->get('id');
            $usuario = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findOneBy(['id'=>$id]);

            $usuario = $serializer->serialize(
                $usuario,
                'json',
                ['group'=>['Usuario']]
            );
            return new Response($usuario);

            
        }

        if ($request->isMethod('PUT')) {

            
            
        }

        if ($request->isMethod('DELETE')) {
            $id = $request->get('id');
            $usuario = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findOneBy(['id'=>$id]);

            $usuariodelete = clone $usuario;
            $this->getDoctrine()->getManager()->remove($usuario);
            $this->getDoctrine()->getManager()->flush();

            $usuariodelete = $serializer->serialize(
                $usuariodelete,
                'json',
                ['group'=>['Usuario']]

            );

            return new Response($usuariodelete);
        }
    }


}
