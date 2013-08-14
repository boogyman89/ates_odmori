<?php

namespace Ates\UserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email')
            ->add('username')
            ->add('first_name')
            ->add('last_name')
            ->add('ssn')
            ->add('address')
            ->add('phone')
            ->add('date_of_employment')
            ->add('date_of_slava')
            ->add('no_days_off')
            ->add('Submit', 'submit');
    }

    public function getName()
    {
        return 'user';
    }
}