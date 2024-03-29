<?php

namespace App\Controller;

use App\Entity\Pago;
use App\Entity\Paypal;
use App\Entity\Suscripcion;
use App\Entity\FormaPago;
use App\Entity\TarjetaCredito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class SuscripcionesController extends AbstractController
{
    public function suscripciones(Request $request, SerializerInterface $serializer)
    {
        $id_usuario = $request->get("id");
        $suscripciones = $this->getDoctrine()->getRepository(Suscripcion::class)->findBy(["premiumUsuario"=>$id_usuario]);
        if ($request->isMethod('GET')) {
            $suscripcionesUsuario = $serializer->serialize($suscripciones, 'json', ['groups'=>['Suscripcion']]);
            return new Response($suscripcionesUsuario);
        }
    }

    public function suscripcion(Request $request, SerializerInterface $serializer)
    {
        $id_usuario = $request->get("id");
        $id_suscripcion = $request->get("sus_id");
        $suscripcion = $this->getDoctrine()->getRepository(Suscripcion::class)->findOneBy(["premiumUsuario"=>$id_usuario, "id"=>$id_suscripcion]);
        if ($request->isMethod('GET')) {
            $suscripcionesUsuario = $serializer->serialize($suscripcion, 'json', ['groups'=>['Suscripcion']]);
            return new Response($suscripcionesUsuario);
        }
        
    }
}