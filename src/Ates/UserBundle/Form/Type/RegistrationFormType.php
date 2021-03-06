<?php

namespace Ates\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('first_name');
        $builder->add('last_name');
        $builder->add('ssn');
        $builder->add('address');
        $builder->add('phone');
        $builder->add('date_of_employment', 'date', array( 'widget' => 'single_text', 'attr' => array('class' => 'employment-date')));
        $builder->add('date_of_slava', 'date', array( 'widget' => 'single_text', 'attr' => array('class' => 'slava-date')));
        
    }

    public function getName()
    {
        return 'ates_user_registration';
    }
}