<?php

namespace App\Controller;

use App\Entity\Calidad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CalidadController extends AbstractController
{
    public function calidad(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $usuarios = $this ->getDoctrine()->getRepository(Calidad::class)->findAll();
            $usuarios = $serializer->serialize(
                $usuarios,
                'json',
                ['groups'=>['Calidad']]

            );
            return new Response($usuarios);
        }


    }
}