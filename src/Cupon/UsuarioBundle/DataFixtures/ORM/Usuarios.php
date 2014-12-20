<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 19/12/14
 * Time: 20:33
 */

namespace Cupon\UsuarioBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Proxies\__CG__\Cupon\UsuarioBundle\Entity\Usuario;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Usuarios implements FixtureInterface, ContainerAwareInterface{

    private $container;
    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
// Implementando una solucion propia al problema de volver a escribir en la base de datos conservando otros datos
        $ciudades = $manager->getRepository('CiudadBundle:Ciudad')->findAll();
        foreach($ciudades as $ciudad){
            for($i=1 ; $i<=100 ; $i++){

                $usuario = new Usuario();
                $passwordEnClaro = 'usuario' . $i;
                $salt = md5(time());

                $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
                $password = $encoder->encodePassword($passwordEnClaro, $salt);
                /* -----------------------------------Solución temporal al problema de persistir usuario ------------------ */
                $usuario->setNombre($usuario->getNombre());
                $usuario->setApellidos($usuario->getApellidos());
                $usuario->setEmail($usuario->getEmail());
                $usuario->setDireccion($usuario->getDireccion());
                $usuario->setPermiteEmail($usuario->getPermiteEmail());
                $usuario->setFechaAlta($usuario->getFechaAlta());
                $usuario->setFechaNacimiento($usuario->getFechaNacimiento());
                $usuario->setDni($usuario->getDni());
                $usuario->setNumeroTarjeta($usuario->getNumeroTarjeta());
                $usuario->setUltimaConexion($usuario->getUltimaConexion());
                $usuario->setCiudad($ciudad);
                /* ----------------------------------------------------------------------------------------------------------- */

                $usuario->setPassword($password);
                $usuario->setSalt($salt);
                $manager->persist($usuario);

            }
        }
        $manager->flush();
    }


}