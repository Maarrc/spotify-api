<?php

namespace App\Controller;

use App\Entity\Idioma;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class IdiomaController extends AbstractController
{
    public function idioma(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $idiomas = $this ->getDoctrine()->getRepository(Idioma::class)->findAll();
            $idiomas = $serializer->serialize(
                $idiomas,
                'json',
                ['groups'=>['Idioma']]

            );
            return new Response($idiomas);
        }
    }
}