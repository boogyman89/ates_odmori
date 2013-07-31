<?php

namespace Ates\VacationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VacationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('From', 'date')
                ->add('To', 'date')
                ->add('Submit', 'submit');
    }
    
    
   public function getName()
   {
       return 'request';
   }
}