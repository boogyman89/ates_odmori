<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Ates\VacationBundle\Entity\VacationRequest;
use Ates\VacationBundle\Form\Type\VacationRequestType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction()
    {
    }
    /**
     * @Route("/request", name="send_request_form")
     * @Template("AtesVacationBundle:Request:anyForm.html.twig")
     */    
    public function sendRequestAction()
    {
       $form = $this->createForm(new VacationRequestType());
       $request = $this->getRequest();
       $form->handleRequest($request);
       
       if($form->isValid()) 
       {                  
                               
           $user = $this->getUser();         
           $vacationRequest = $form->getData();
           $vacationRequest->setUser($user);      
                                       
           $em = $this->getDoctrine()->getManager();
           $em->persist($vacationRequest);
           $em->flush();
          
           return $this->redirect($this->generateUrl('fos_user_profile_show'));
       }
       return array('form' => $form->createView());

    }

    
    /**
     * @Route("/edit_request/{id}", name="edit_request_form")
     * @Template("AtesVacationBundle:Request:anyForm.html.twig")
     */  
    public function editRequestAction($id)
    {        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AtesVacationBundle:VacationRequest');
        $vacationRequest = $repository->find($id);
        $form = $this->createForm(new VacationRequestType());
            
        $formRequest = $this->getRequest();
        $form->handleRequest($formRequest);        
        if($form->isValid()) 
        {    
          $vacationRequest = $repository->find($id);
               
          $vacationRequest->setStartDate($form->get('start_date')->getData());
          $vacationRequest->setEndDate($form->get('end_date')->getData());
          
          $em->flush();     //kraj edita
                            //sledi provera ROLE-a
          $user = $this->getUser();
          $roles = $user->getRoles();
          
          foreach ($roles as $role)
          {
              if($role == 'ROLE_ADMIN')
              {
                  return $this->redirect($this->generateUrl('show_admin_panel')); //ROLE_ADMIN return
              }
          }
          
          return $this->redirect($this->generateUrl('fos_user_profile_show'));   // ROLE_USER return
          
        }            
        $form->setData($vacationRequest);        
        
        return array('form' => $form->createView());       
    }
}
