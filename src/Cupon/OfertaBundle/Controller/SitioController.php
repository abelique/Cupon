<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 9/08/14
 * Time: 14:03
 */

namespace Cupon\OfertaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SitioController extends Controller
{

    public function estaticaAction($pagina)
    {
        return $this->render('OfertaBundle:Sitio:'. $pagina .'.html.twig');
    }

} 