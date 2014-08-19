<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{

    public function x_portadaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
            'ciudad' => $this->container->getParameter('cupon.ciudad_por_defecto'), //1,
            'fechaPublicacion' => new \DateTime('today' . '23:59:59')//importante concatenar el time para que sea correcto.
        ));
        return $this->render('OfertaBundle:Default:portada.html.twig', array('oferta' => $oferta));
    }

    public function portadaAction($ciudad = null)
    {
        $em = $this->getDoctrine()->getManager();

        if(null == $ciudad)
        {
            $ciudad = $this->container->getParameter('cupon.ciudad_por_defecto');
            return new RedirectResponse($this->generateUrl('portada', array('ciudad' => $ciudad)));
        }
        return $this->x_portadaAction();
    }

}//fin de la clase
