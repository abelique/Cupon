<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{

    public function portadaAction($ciudad)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
              'ciudad' => $ciudad?$ciudad->getId():$this->container->getParameter('cupon.ciudad_por_defecto'),
              //$this->container->getParameter('cupon.ciudad_por_defecto'),
              'fechaPublicacion' => new \DateTime('2014-08-18' . '23:59:59')//importante concatenar el time para que sea correcto.
            //ademas cambiamos en DateTime('today') por la fecha ('2014-08-18') porq en la fecha actual puede que no haya oferta.
        ));
        if (null == $oferta){
            throw $this->createNotFoundException("No se ha encontrado oferta del día en esta ciudad");
        }
        return $this->render('OfertaBundle:Default:portada.html.twig', array('oferta' => $oferta));

    }

    public function ofertaDelDiaAction()
    {

    }

    public function tipoNavegadorAction()
    {
        $peticion = $this->getRequest();
        $nav = $peticion->server->get('HTTP_USER_AGENT');

        return new Response("Su navegador es: " . $nav );
    }

    public function ofertaAction($ciudad, $slug){
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        return $this->render('OfertaBundle:Default:detalle.html.twig', array(
            'oferta' => $oferta
        ));
    }

}//fin de la clase
