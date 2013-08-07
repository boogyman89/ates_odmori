<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Entity\VacationRequest;


class AdminController extends Controller
{
    public function showAdminAction()
    {            
        $requests = $this->getDoctrine()->getRepository('AtesVacationBundle:VacationRequest')->findAll();
        
        //get all user with confirmed email ( for account approving )
        $users = $this->getDoctrine()->getRepository('AtesUserBundle:User')->findBy(array(
            'enabled' => true,
            'locked' => true
        ));
        
        return $this->container->get('templating')
            ->renderResponse('FOSUserBundle:Admin:panel.html.'.$this->container->getParameter('fos_user.template.engine'), array(
                'requests' => $requests,
                'users' => $users
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
    
    public function approveUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AtesUserBundle:User');
        $user = $repository->find($id);
        
        $user->setLocked(false);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('show_admin_panel'));
        
    }
    
    public function deleteUserOnApprovingAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AtesUserBundle:User');
        $user = $repository->find($id);
        
        $em->remove($user);
        $em->flush();
        
        return $this->redirect($this->generateUrl('show_admin_panel'));
    }
        
}