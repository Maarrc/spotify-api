<?php

namespace App\Controller;

use App\Entity\Calidad;
use App\Entity\Configuracion;
use App\Entity\Free;
use App\Entity\Idioma;
use App\Entity\TipoDescarga;
use App\Entity\Usuario;
use DateTime;
use phpDocumentor\Reflection\PseudoTypes\True_;
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
            $bodydata = $request->getContent();
                $usuario_new = $serializer->deserialize(
                    $bodydata,
                    Usuario::class,
                    'json'
                );

            $this->getDoctrine()->getManager()->persist($usuario_new);

            $configuracion = new Configuracion();
            $configuracion->setAutoplay(true);
            $configuracion->setAjuste(true);

            $configuracion->setNormalizacion(true);

            $tipo_descarga = $this->getDoctrine()->getRepository(TipoDescarga::class)->findOneBy(['id'=> 4]);
            $configuracion->setTipoDescarga($tipo_descarga);
            $configuracion->setUsuario($usuario_new);

            $Calidad = $this->getDoctrine()->getRepository(Calidad::class)->findOneBy(['id'=> 1]);
            $configuracion->setCalidad($Calidad);

            $Idioma = $this->getDoctrine()->getRepository(Idioma::class)->findOneBy(['id'=> 1]);
            $configuracion->setIdioma($Idioma);

            $this->getDoctrine()->getManager()->persist($configuracion);
            
            $Free = new Free();
            $Free->setFechaRevision(new \DateTime());
            $Free->setUsuario($usuario_new);
            $this->getDoctrine()->getManager()->persist($Free);
            $this->getDoctrine()->getManager()->flush();

            $Free = $serializer->serialize(
                $Free,
                'json',
                ['groups'=>['Free', 'Usuario']]

            );
            return new Response($Free);

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
