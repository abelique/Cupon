<?php

namespace Cupon\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function comprasAction(){

        $usuario_id = 9;
        $em = $this->getDoctrine()->getManager();
        $compras = $em->getRepository('UsuarioBundle:Usuario')->findTodasLasCompras($usuario_id);

        if(!$compras){
            throw $this->createNotFoundException('Usuario no tiene compras relizadas');
        }

        return $this->render('UsuarioBundle:Default:compras.html.twig', array('compras' => $compras));
    }


}
