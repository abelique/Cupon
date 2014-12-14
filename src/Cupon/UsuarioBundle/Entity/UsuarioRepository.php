<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 14/12/14
 * Time: 15:04
 */

namespace Cupon\UsuarioBundle\Entity;


use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository {

    public function findTodasLasCompras($usuario_id){

        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT v, o, t
            FROM OfertaBundle:Venta v
            JOIN v.oferta o
            JOIN o.tienda t
            WHERE v.usuario = :id
            ORDER BY v.fecha DESC
        ');
        $consulta->setParameter('id', $usuario_id);
        return $consulta->getResult();
    }


} 