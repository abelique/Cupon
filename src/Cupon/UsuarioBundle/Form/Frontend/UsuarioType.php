<?php
/**
 * Created by PhpStorm.
 * User: abelique
 * Date: 20/12/14
 * Time: 19:38
 */

namespace Cupon\UsuarioBundle\Form\Frontend;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('nombre')->add('apellidos')->add('email')->add('password')
            ->add('direccion')->add('permite_email')->add('fecha_nacimiento')
            ->add('dni')->add('numero_tarjeta')->add('ciudad');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Cupon\UsuarioBundle\Entity\Usuario'));
    }

    public function getName()
    {
        return 'cupon_usuariobundle_usuariotype';
    }
}