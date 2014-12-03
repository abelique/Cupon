<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 22/08/14
 * Time: 10:17
 */

namespace Cupon\OfertaBundle\Entity;


use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository {

    public function findOfertaDelDia($ciudad)
    {
        $fechaPublicacion = new \DateTime('Today');
        $fechaPublicacion->setTime(23,59,59);

        $em = $this->getEntityManager();
        $dql = 'SELECT o,c,t
                FROM OfertaBundle:Oferta o
                JOIN o.ciudad c
                JOIN o.tienda t
                WHERE o.revisada = true
                AND o.fechaPublicacion<: fecha
                AND o.slug =: ciudad
                ORDER BY o.fechaPublicacion DESC ';
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', $fechaPublicacion);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);

        return $consulta->getSingleResult();
    }

    public function findOferta($ciudad, $slug){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:Oferta o
            JOIN o.ciudad c
            JOIN o.tienda t
            WHERE o.revisada = true
            AND o.slug = :slug
            AND c.slug = :ciudad');
        $consulta->getParameter('slug', $slug);
        $consulta->getParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);
        return $consulta->getSingleResult();
    }

} 