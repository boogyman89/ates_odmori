<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Entity\VacationRequest;


class AdminController extends Controller
{
    public function showAdminAction()
    {            
        $requests = $this->getDoctrine()->getRepository('AtesVacationBundle:VacationRequest')->findAll();
        
        return $this->container->get('templating')
            ->renderResponse(
                    'FOSUserBundle:Admin:panel.html.'.$this->container
                    ->getParameter('fos_user.template.engine'), array(
                        'requests' => $requests
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
        
}