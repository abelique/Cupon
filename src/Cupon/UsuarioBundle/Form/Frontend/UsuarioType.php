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
        $builder->add('nombre')
                ->add('apellidos')
                ->add('email','email')
                ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas no coinciden',
                'options' =>array('label' => 'Contraseña')
                ))
                ->add('direccion')
                ->add('permite_email', 'checkbox', array('required' => true))
                ->add('fecha_nacimiento','birthday')
                ->add('dni')
                ->add('numero_tarjeta')
                ->add('ciudad');
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