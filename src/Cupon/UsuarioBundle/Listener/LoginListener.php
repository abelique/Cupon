<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 18/12/14
 * Time: 22:15
 */

namespace Cupon\UsuarioBundle\Listener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Validator\Constraints\DateTime;

class LoginListener {

    private $router;
    private $ciudad = null;

    public function __construct($router){
        $this->router = $router;
    }

    public function setCiudad($ciudad){
        $this->ciudad = $ciudad;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event){
       // Para ver el alcance de estas funciones aunque falta el
       // $usuario = $event->getAuthenticationToken()->getUser();
       // $usuario->setUltimaConexion(new \DateTime('today'));

        $token = $event->getAuthenticationToken();
        $ciudad = $token->getUser()->getCiudad()->getSlug();
        $this->setCiudad($ciudad); // Setear la ciudad de manera correcta
    }

    public function onKernelResponse(FilterResponseEvent $event){
        if( null != $this->ciudad ){
            $portada = $this->router->generate('portada', array('ciudad'=> $this->ciudad));
            $event->setResponse(new RedirectResponse($portada));
        }

    }

} 