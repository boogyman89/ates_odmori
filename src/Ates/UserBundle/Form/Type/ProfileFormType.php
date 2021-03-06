<?php

namespace Ates\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);
        
        $builder->add('first_name');
        $builder->add('last_name');
        $builder->add('address');
        $builder->add('phone');
    }

    public function getName()
    {
        return 'ates_user_profile';
    }
}