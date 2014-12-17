<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 16/08/14
 * Time: 12:23
 */

namespace Cupon\OfertaBundle\Util;


class Util {
    private $parametros;



    public function __construct($params){
        $this->parametros = $params;
    }

    static public function getSlug($cadena, $separador = '-'){
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
        return $slug;
    }

    public function getParams(){
        //if( is_array($this->parametros)){
        //    return 'Es un array';
        //}
        return $this->parametros;
    }
    public function getSaludo($nombre){
        $msg = 'Bienvenido a la ID, ' . $nombre;
        $params =  $this->getParams();
        return $msg . ' Aqui los params: ' . implode('---', $params);

    }

}
