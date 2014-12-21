<?php

namespace Cupon\UsuarioBundle\Controller;

use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends Controller
{

    public function loginAction(){
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(SecurityContext::AUTHENTICATION_ERROR,
                $sesion->get(SecurityContext::AUTHENTICATION_ERROR));

        return $this->render('UsuarioBundle:Default:login.html.twig', array(
            'last_username'=> $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }
    public function cajaLoginAction(){
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(SecurityContext::AUTHENTICATION_ERROR,
        $sesion->get(SecurityContext::AUTHENTICATION_ERROR));

        return $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
            'last_username'=> $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }

    public function comprasAction(){

        $usuario_id = 9;
        $em = $this->getDoctrine()->getManager();
        $compras = $em->getRepository('UsuarioBundle:Usuario')->findTodasLasCompras($usuario_id);

        if(!$compras){
            throw $this->createNotFoundException('Usuario no tiene compras relizadas');
        }

        return $this->render('UsuarioBundle:Default:compras.html.twig', array('compras' => $compras));
    }

    public function testConexionAction(){
        $em = $this->getDoctrine()->getManager();
        $usuario1 = $em->getRepository('UsuarioBundle:Usuario')->find(1);

        $fn = new \DateTime('today');
        $fn->setTime(00, 00, 00);

        $usuario1->setUltimaConexion($fn);
        $em->persist($usuario1);
        $em->flush();

        return new Response('Usuario con ID:1 y DNI:  ' );
    }

    public function registroAction(){
        $usuario = new Usuario();

        $usuario->setPermiteEmail(true);
        $usuario->setFechaNacimiento(new \DateTime('today - 18 years'));

        $formulario = $this->createForm(new UsuarioType(), $usuario);
        return $this->render('UsuarioBundle:Default:registro.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

}
