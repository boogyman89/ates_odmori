<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Entity\VacationRequest;
use Ates\VacationBundle\Form\Type\HolidaysType;
use Ates\VacationBundle\Entity\Holidays;

class AdminController extends Controller
{
    public function showAdminAction()
    {      
        $em = $this->getDoctrine()->getManager();
        $requests = $em->getRepository('AtesVacationBundle:VacationRequest')->findAll();
        $holidays = $em->getRepository('AtesVacationBundle:Holidays')->findAll();
        
        return $this->Render('AtesUserBundle:Admin:panel.html.twig', 
                array(                    
                        'requests' => $requests,
                        'holidays' => $holidays
                ));
    }
    
    public function approveRequestAction($id)
    {
         $em = $this->getDoctrine()->getManager();
         $repository = $em->getRepository('AtesVacationBundle:VacationRequest');
         $vacationRequest = $repository->find($id);
          
         $vacationRequest->setState('approved');
          
         $em->flush();
          
         return $this->redirect($this->generateUrl('show_admin_panel'));
    }
    
    public function rejectRequestAction($id)
    {
          $em = $this->getDoctrine()->getManager();
         $repository = $em->getRepository('AtesVacationBundle:VacationRequest');
         $vacationRequest = $repository->find($id);
          
         $vacationRequest->setState('rejected');
          
         $em->flush();
          
         return $this->redirect($this->generateUrl('show_admin_panel'));
    }
    
    public function addHolidayAction()
    {
         $form = $this->createForm(new HolidaysType());
         
          $request = $this->getRequest();
          $form->handleRequest($request);
       
          if($form->isValid()) 
          {                  
              $holiday = new Holidays();;               
              $holiday = $form->getData();
               
              $em = $this->getDoctrine()->getManager();
              $em->persist($holiday);
              $em->flush();
              
              return $this->redirect($this->generateUrl('show_admin_panel'));
          }
          
          return $this->Render('AtesVacationBundle:Request:anyForm.html.twig', 
               array('form' => $form->createView()));
    }
        
    
    public function deleteHolidayAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $em->remove($em->getRepository('AtesVacationBundle:Holidays')->find($id));
        $em->flush();
        
        return $this->redirect($this->generateUrl('show_admin_panel'));
    }
    
    public function editHolidayAction($id)
    {
        $form = $this->createForm(new HolidaysType());
        $em = $this->getDoctrine()->getManager();
        $holiday = $em->getRepository('AtesVacationBundle:Holidays')->find($id);
        
        $request = $this->getRequest();
        $form->handleRequest($request);
       
        if($form->isValid()) 
        {   
            $holiday->setName($form->get('name')->getData());
            $holiday->setDate($form->get('date')->getData());
             
            $em->flush();
             
            return $this->redirect($this->generateUrl('show_admin_panel'));
        }                  
        $form->setData($holiday);
              
        return $this->Render('AtesVacationBundle:Request:anyForm.html.twig', 
               array('form' => $form->createView()));
    }
}