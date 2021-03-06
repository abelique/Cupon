<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{

    // Funciónes para realizar pruebas puntuales
    // Funcionamiento de los servicios
    public function pruebaServicioAction(){
        $mensaje = $this->get('cupon.utilidades')->getSaludo('Abelique');
        return $this->render('OfertaBundle:Default:pruebaServicio.html.twig',array(
            'mensaje' => $mensaje
        ));
    }
    // Funcionamiento de Time para obtener hora min, etc
    public function pruebaTimeAction(){
        $tiempo = new \DateTime('now');
        $peticion = $this->getRequest()->server->get('REQUEST_TIME');;
        //return new Response($peticion . ' Y LA FECHA ES: ' . $tiempo->getOffset());
        return new Response('la hora actual sería: ' . ($peticion/$tiempo->getOffset())%24);
        //return new Response($tiempo[0]);
    }

    public function portadaAction($ciudad)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
              'ciudad' => $ciudad?$ciudad->getId():$this->container->getParameter('cupon.ciudad_por_defecto'),
              //$this->container->getParameter('cupon.ciudad_por_defecto'),
              'fechaPublicacion' => new \DateTime('today'. '23:59:59')
             // \DateTime('2014-08-18' . '23:59:59')//importante concatenar el time para que sea correcto.
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
    {  // PROBANDO PARAMS DE REQUEST, MUY INTERESANTE, ADEMÁS EN UNA LINEA.
        return new Response("Su navegador es: "
            . $this->getRequest()->server->get('HTTP_USER_AGENT') );
    }

    public function ofertaAction($ciudad, $slug){
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        // El error esta en la linea superior, igual la consulta tiene algun problema.
        $relacionadas = $em->getRepository('OfertaBundle:Oferta')->findRelacionadas($ciudad);
        return $this->render('OfertaBundle:Default:detalle.html.twig', array(
            'oferta' => $oferta,
            'relacionadas' => $relacionadas
        ));
        //return new Response('Hasa aquí llega la ejecución...');
    }

}//fin de la clase
