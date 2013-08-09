<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Form\Type\HolidaysType;
use Ates\VacationBundle\Entity\Holidays;


use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends Controller
{
    public function showAdminAction()
    {      
        $em = $this->getDoctrine()->getManager();
        
        $requestUserArray = array();
        $query = $em->getRepository('AtesVacationBundle:VacationRequest')->createQueryBuilder('r')
            ->where('r.state = :s')
            ->setParameter('s','pending')
            ->orderBy('r.start_date','ASC')
            ->getQuery();
        $requests = $query->getResult();
        /*
        foreach( $requests as $request)
        {
           //echo $request->getIdUser()."<br/>";
           // $user = new User();
           $user = $em->getRepository('AtesUserBundle:User')->find($request->getIdUser());
            //$user->setFirstName('marko');
            $ime = $user->getFirstName();
           echo $ime;
           //$firstLastName = $user->getFirstName().' '.$user->getLastName();
           //$requestUserArray[$user]= $request;
        }
         * 
         */
        
        $holidays = $em->getRepository('AtesVacationBundle:Holidays')->findAll();
        

        //get all user with confirmed email ( for account approving )
        $users = $this->getDoctrine()->getRepository('AtesUserBundle:User')->findBy(array(
            'enabled' => true,
            'locked' => true
        ));
        
        
        
        return $this->Render('AtesUserBundle:Admin:panel.html.twig', 
                array(                    
                        'requests' => $requests,
                        'holidays' => $holidays,
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
    
    
    public function editUserProfileAction($id)
    {
        $request = $this->getRequest();
        
        //$user = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->container->get('doctrine')->getRepository('AtesUserBundle:User')->find($id);
        
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->container->get('fos_user.user_manager');

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_profile_show');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }
}