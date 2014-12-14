<?php

namespace Cupon\CiudadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function cambiarAction($ciudad){
        return new RedirectResponse($this->generateUrl('portada', array('ciudad' => $ciudad)) );
        //return new Response('Nos cambiamos a esta ciudad: ' . $ciudad);
    }

    public function listaCiudadesAction($ciudad){
        $em = $this->getDoctrine()->getManager();
        $ciudades = $em->getRepository('CiudadBundle:Ciudad')->findAll();
        return $this->render('CiudadBundle:Default:listaCiudades.html.twig',
            array(
                'ciudadActual'       => $ciudad,
                'ciudades'     => $ciudades));
    }

    public function recientesAction($ciudad){

        $em = $this->getDoctrine()->getManager();
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        if(!$ciudad){
            throw $this->createNotFoundException('No existe ciudad');
        }
        $cercanas = $em->getRepository('CiudadBundle:Ciudad')->findCercanas($ciudad->getId());
        $recientes = $em->getRepository('OfertaBundle:Oferta')->findRecientes($ciudad->getId());
        return $this->render('CiudadBundle:Default:recientes.html.twig', array(
            'ciudad'    => $ciudad,
            'cercanas'  => $cercanas,
            'recientes' => $recientes
        ));
    }

}
