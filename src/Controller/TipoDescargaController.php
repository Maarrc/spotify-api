<?php

namespace App\Controller;

use App\Entity\TipoDescarga;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class TipoDescargaController extends AbstractController
{
    public function tipos_descarga(Request $request, SerializerInterface $serializer)
    {
        if ($request->isMethod('GET')) {
            $tipos = $this ->getDoctrine()->getRepository(TipoDescarga::class)->findAll();
            $tipos = $serializer->serialize(
                $tipos,
                'json',
                ['groups'=>['TipoDescarga']]

            );
            return new Response($tipos);
        }
    }
}