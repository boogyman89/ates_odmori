<?php

namespace Ates\VacationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HolidaysType extends AbstractType
{
      public function buildForm(FormBuilderInterface $builder, array $options)
      {
          $builder->add('date', 'date', array( 'label' => 'Date', 'attr' => array('display' => 'none')))
                  ->add('name', 'text', array( 'label' => 'Name'))
                  ->add('Submit', 'submit')
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