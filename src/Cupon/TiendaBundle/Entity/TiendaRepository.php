<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 12/12/14
 * Time: 14:29
 */

namespace Cupon\TiendaBundle\Entity;


use Doctrine\ORM\EntityRepository;

class TiendaRepository extends EntityRepository {

    public function findUltimasOfertasPublicadas($tienda_id, $limite = 10){

        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, t
            FROM OfertaBundle:Oferta o
            JOIN o.tienda t
            WHERE o.revisada = true
            AND o.fechaPublicacion < :fecha
            AND o.tienda = :id
            ORDER BY o.fechaExpiracion desc
        ');
        $consulta->setMaxResults($limite);
        $consulta->setParameter('fecha', new \DateTime('now'));
        $consulta->setParameter('id', $tienda_id);
        return $consulta->getResult();
    }

    public function findCercanas($s_tienda, $s_ciudad){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT t
            FROM TiendaBundle:Tienda t
            JOIN t.ciudad c
            WHERE t.slug != :tienda
            AND c.slug = :ciudad
        ');
        $consulta->setMaxResults(5);
        $consulta->setParameter('tienda', $s_tienda);
        $consulta->setParameter('ciudad', $s_ciudad);
        return $consulta->getResult();
    }


} 