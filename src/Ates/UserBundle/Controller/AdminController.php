<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Form\Type\HolidaysType;
use Ates\VacationBundle\Entity\Holidays;
require('fpdf/fpdf.php');
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
         $vacationRepository = $em->getRepository('AtesVacationBundle:VacationRequest');
         $vacationRequest = $vacationRepository->find($id);
         $userRepository = $em->getRepository('AtesUserBundle:User');
         $user = $userRepository->find($vacationRequest->getIdUser());
         $holidaysRepository = $em->getRepository('AtesVacationBundle:Holidays');
         $holidaysList = $holidaysRepository->findAll();
         
         $holidays = array();
         $i = 0;
         foreach ($holidaysList as $holiday)
         {
            $holidays[] = $holiday->getDate();
         }
          
         $startDate = $vacationRequest->getStartDate();
         $endDate = $vacationRequest->getEndDate();
         $days = $endDate->diff($startDate)->days;
               
         $workingDays = $this->getWorkingDays($days, $startDate,$endDate, $holidays);
  
         $this->createPDF($user,$vacationRequest,$workingDays);
        
         $vacationRequest->setState('approved');
         $user->setNoDaysOff($user->getNoDaysOff() - $workingDays);
               
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
    

    public function getWorkingDays($days,$startDate,$endDate,$holidays)
    {                     
        //floor — Round fractions down
        //fmod — Returns the floating point remainder (modulo) of the division of the arguments
        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = $startDate->format('w');
        $the_last_day_of_week = $endDate->format('w');
                
        if ($the_first_day_of_week <= $the_last_day_of_week) 
        {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        }
        else
        {
            if ($the_first_day_of_week == 7) 
            {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6)
                {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            }
            else
            {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }                
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0 )
        {
            $workingDays += $no_remaining_days;
        }

        $startDate = strtotime($startDate->format('T-m-d H:i:s'));
        $endDate = strtotime($endDate->format('T-m-d H:i:s'));
        
        //We subtract the holidays
        foreach($holidays as $holiday)
        {         
            $holidayDayOfTheWeek = $holiday->format('w');
            $time_stamp=strtotime($holiday->format('T-m-d H:i:s'));
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp 
                    && $time_stamp <= $endDate 
                    && $holidayDayOfTheWeek != 6 
                    && $holidayDayOfTheWeek != 7)
            {
                $workingDays--;
            }
        }         
        return $workingDays;
    }
    
    function createPDF($user,$vacationRequest,$workingDays)
    {
        $pdf = new \FPDF('P', 'mm', 'A4');
                
        $text = "Zaposlenom " . $user->getFirstName() . " " . $user->getLastName() 
                . " sa maticnim brojem " . $user->getSSN() 
                . " se odobrava godisnji odmor u trajanju od " . $workingDays 
                . " radnih dana sa pocetkom dana " . $vacationRequest->getStartDate()->format('Y-m-d')
                . " do " . $vacationRequest->getEndDate()->format('Y-m-d') ;
             
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
         //cell width height text in mm
        $pdf->write(5,$text);
        $path = "PDF/" . $user->getID() . "req" . $vacationRequest->getId() . ".pdf";
        $pdf->Output($path,"F");
       
        $url = "http://localhost/" . $path;
        echo $url;
        $vacationRequest->setPdf($url);
      //  return $this->redirect('http://localhost/pdf/simple.pdf');
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