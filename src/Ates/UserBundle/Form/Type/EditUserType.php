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
            ->add('date_of_employment', 'date', array( 'widget' => 'single_text', 'attr' => array('class' => 'employment-date')))
            ->add('date_of_slava', 'date', array( 'widget' => 'single_text', 'attr' => array('class' => 'slava-date')))
            ->add('no_days_off')
            ->add('Save', 'submit', array('attr' => array('class' => 'btn btn-primary btn-block btn-large marginTop20')));
    }

    public function getName()
    {
        return 'user';
    }
}