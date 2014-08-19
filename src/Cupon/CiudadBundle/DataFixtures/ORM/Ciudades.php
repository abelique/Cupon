<?php

namespace Cupon\CiudadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cupon\CiudadBundle\Entity\Ciudad;

class Ciudades extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $ciudades = array(
            array('nombre' => 'Barcelona' ),
            array('nombre' => 'Madrid'),
            array('nombre' => 'Valencia'),
            array('nombre' => 'Sevilla'),
            array('nombre' => 'Bilbao'),
        );
        foreach($ciudades as $ciudad)
        {
            $entidad = new Ciudad();

            $entidad->setNombre($ciudad['nombre']);
            // ---- $entidad->setSlug($ciudad['slug']); // Seteado en la misma entidad atraves de setNombre()
            // Se podría setear más propiedades de la entidad Ciudad
            $manager->persist($entidad);


        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}


