<?php

namespace Cupon\TiendaBundle\Entity;

use Cupon\OfertaBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tienda
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Cupon\TiendaBundle\Entity\TiendaRepository")
 */
class Tienda
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=10)
     */
    protected $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    protected $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="text")
     */
    protected $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="Cupon\CiudadBundle\Entity\Ciudad")
     * @ORM\JoinColumn(name="ciudad_id", referencedColumnName="id")
     */
    protected $ciudad;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tienda
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Tienda
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Tienda
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Tienda
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Tienda
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tienda
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Tienda
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }


    public function setCiudad(\Cupon\CiudadBundle\Entity\Ciudad $ciudad)
    {
        $this->ciudad = $ciudad;
        return $this;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    /* Metodos magicos */

    public function __toString()
    {
        return $this->getNombre();
    }

}
