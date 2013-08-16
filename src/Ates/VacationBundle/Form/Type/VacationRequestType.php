<?php

namespace Ates\VacationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VacationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('start_date', 'date', array( 'label' => 'From', 'attr'=>array('class' => '')))
                ->add('end_date', 'date', array( 'label' => 'To'))
                ->add('Submit', 'submit', array('attr' => array('class' => 'btn btn-primary')));
               ;
                
             //   ->add('submitted', 'datetime', array('label' => " ", 'data' =>
             //       (new \DateTime("NOW")), 'attr' => array('style' => 'display:none;')));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => 'Ates\VacationBundle\Entity\VacationRequest',
         ));
    }

   public function getName()
   {
       return 'vacation_request';
   }
}