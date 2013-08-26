<?php

namespace Ates\VacationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HolidaysType extends AbstractType
{
      public function buildForm(FormBuilderInterface $builder, array $options)
      {

          $builder->add('date', 'date', array( 'label' => 'Date', 'widget' => 'single_text'))
                  ->add('name', 'text', array( 'label' => 'Name', 'attr' => array('placeholder' => 'Name', 'class' => 'input-block-level')))
                  ->add('Add Holiday', 'submit', array('attr' => array('class' => 'btn btn-primary btn-block')))
                  ;
          
      }
      
      public function setDefaultOptions(OptionsResolverInterface $resolver)
      {
            $resolver->setDefaults(array(
           'data_class' => 'Ates\VacationBundle\Entity\Holidays',
         )); 
      }
      
      public function getName()
      {
          return 'holidays';
      }
}