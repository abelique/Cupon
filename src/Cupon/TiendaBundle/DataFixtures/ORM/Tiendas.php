<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 16/08/14
 * Time: 19:52
 */

namespace Cupon\TiendaBundle\DataFixtures\ORM;


use Cupon\TiendaBundle\Entity\Tienda;
use Cupon\CiudadBundle\Entity\Ciudad;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Tiendas extends  AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Crear 10 tiendas en cada ciudad
        $ciudades = $manager->getRepository('CiudadBundle:Ciudad')->findAll();
        $numTienda = 0;
        foreach ($ciudades as $ciudad)
        {
            for ($i=1; $i<=10 ; $i++)
            {
                $numTienda++;

                $tienda = new Tienda();
                $tienda->setNombre('Tienda #'.$numTienda);
                $tienda->setLogin('tienda'.$numTienda);
                $tienda->setPassword('password'.$numTienda);
                $tienda->setSalt(md5(time()));
                        //$tienda->setSalt("probando");
                $tienda->setDescripcion(
                    "Lorem ipsum dolor sit amet, consectetur adipisicing elit,"
                    ."sed do eiusmod tempor incididunt ut labore et dolore magna"
                    ."aliqua. Ut enim ad minim veniam, quis nostrud exercitation"
                    ."ullamco laboris nisi ut aliquip ex ea commodo consequat."
                );
                $tienda->setDireccion("Calle Lorem Ipsum, $i\n".$ciudad->getNombre());
                $tienda->setCiudad( $ciudad );

                $manager->persist($tienda);
            }
            $manager->flush();
        }
    }


    public function getOrder()
    {
        return 2;
    }

} 