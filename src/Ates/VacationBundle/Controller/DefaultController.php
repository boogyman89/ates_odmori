<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ates\VacationBundle\Entity\Request;
use Ates\VacationBundle\Form\Type\RequestType;

class DefaultController extends Controller
{
    public function indexAction()
    {
       $form = $this->createForm(new RequestType());
       
       return $this->Render('AtesVacationBundle:Default:request.html.twig', 
               array('form' => $form->createView()));
    }
}
