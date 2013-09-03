<?php

namespace Ates\VacationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VacationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('start_date', 'date', array( 'label' => null, 'widget' => 'single_text'))
                ->add('end_date', 'date', array( 'label' => null, 'widget' => 'single_text'))
                ->add('comment', 'textarea', array('attr' => array('class' => 'input-block-level','placeholder' => "Comment", 'rows' => '4')))
                ->add('Send Request', 'submit', array('attr' => array('class' => 'btn btn-primary btn-block')));
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