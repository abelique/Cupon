<?php

namespace Cupon\UsuarioBundle\Controller;

use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Time;

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

    public function ant_registroAction(){
        $usuario = new Usuario();

        $usuario->setPermiteEmail(true);
        $usuario->setFechaNacimiento(new \DateTime('today - 18 years'));

        $formulario = $this->createForm(new UsuarioType(), $usuario);
        return $this->render('UsuarioBundle:Default:registro.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    public function registroAction(){
        $peticion = $this->getRequest();
        $usuario = new Usuario();

        $formulario = $this->createForm(new UsuarioType(), $usuario);
        $formulario->handleRequest($peticion);

        if($formulario->isValid()){

            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);

            $fechaUltimaConexion = new \DateTime('today');
            $fechaUltimaConexion->setTime(11,00,00); //Habrá que encontrar la manera de saber hora actual desde el request

            $usuario->setUltimaConexion($fechaUltimaConexion);  //new \DateTime('today'));
            $usuario->setSalt( md5(time()) );
            $passwordCodificado = $encoder->encodePassword( $usuario->getPassword(), $usuario->getSalt() );
            $usuario->setPassword($passwordCodificado);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            // Asignar un mensaje flash con información
            $this->get('session')->getFlashBag()->add('info', '¡Enhorabuena! Te has registrado correctamente en Cupon');

            // Loguear al usuario con la función UsernamePasswordToken()
            $token = new UsernamePasswordToken(
                $usuario,
                $usuario->getPassword(),
                'frontend',
                $usuario->getRoles()
            );
            $this->container->get('security.context')->setToken($token);

            // Al final lo redirigimos
            return $this->redirect($this->generateUrl('portada', array(
                'ciudad' => $usuario->getCiudad()->getSlug()

            )));
        }
        return $this->render('UsuarioBundle:Default:registro.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    public function perfilAction(){

        $usuario = $this->get('security.context')->getToken()->getUser();
        $formulario = $this->createForm(new UsuarioType(), $usuario);

        $peticion = $this->getRequest();
        $passwordOriginal = $formulario->getData()->getPassword();
        $formulario->handleRequest($peticion);

        if($formulario->isValid()){
            // Operación de post para update del perfíl de usuario
            if(null == $usuario->getPassword()){
                $usuario->setPassword($passwordOriginal);
            }else{
                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $passCodificado = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
                $usuario->setPassword($passCodificado);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
        }
        return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
            'usuario'    => $usuario,
            'formulario' => $formulario->createView()
        ));

    }

}
