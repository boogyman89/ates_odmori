<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Ates\VacationBundle\Entity\VacationRequest;
use Ates\VacationBundle\Form\Type\VacationRequestType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
       $form = $this->createForm(new VacationRequestType());
                     
       $form->handleRequest($request);
       
         $user = $this->container->get('security.context')->getToken()->getUser();
       $id= $user->getId();
       
       echo $id;
       
       if($form->isValid()) 
       {
           $user = $this->container->get('security.context')->getToken()->getUser();
           $date = date('Y-m-d H:i:s');
           
           $vacationRequest = new VacationRequest();
           
      //     $vacationRequest->setFrom($form->get('From'));
      //     $vacationRequest->setTo($form->get('To'));
           $vacationRequest->setIdUser($user->getId());
       //    $vacationRequest->setSubmitted($date);
           $vacationRequest->setState('pending');
           
           $em = $this->getDoctrine()->getManager();
           $em->persist($vacationRequest);
           $em->flush();
          
           return $this->redirect($this->generateUrl('/profile'));
       }
       
       return $this->Render('AtesVacationBundle:Default:request.html.twig', 
               array('form' => $form->createView()));
    }
}
