<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Ates\VacationBundle\Entity\VacationRequest;
use Ates\VacationBundle\Form\Type\VacationRequestType;

class DefaultController extends Controller
{
    public function indexAction()
    {
       $form = $this->createForm(new VacationRequestType());
                     
       $request = $this->getRequest();
       
       $form->handleRequest($request);
       
       if($form->isValid()) 
       {                  
           $user = $this->container->get('security.context')->getToken()->getUser();
           $date = new \DateTime("NOW");
           
           
           $vacationRequest = new VacationRequest();
           
           $vacationRequest->setStartDate($form->get('start_date')->getData()); //moze vako da se vade podaci iz forme
           $vacationRequest->setEndDate($form["end_date"]->getData()); //a moze i vako
           $vacationRequest->setIdUser($user->getId());
           $vacationRequest->setSubmitted($date);
           $vacationRequest->setState("pending");
                                
          // $vacationRequest = $form->getData();
                               
           $em = $this->getDoctrine()->getManager();
           $em->persist($vacationRequest);
           $em->flush();
          
           return $this->redirect($this->generateUrl('\profile'));
            
            
       }
       
       return $this->Render('AtesVacationBundle:Default:request.html.twig', 
               array('form' => $form->createView()));
    }
}
