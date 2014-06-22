<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use \Ates\VacationBundle\Entity\VacationRequest;
use \Ates\VacationBundle\Form\Type\VacationRequestType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * RequestController
 *
 * @Route("/request")
 */

class RequestController extends Controller
{

	/**
	 * @Route("/request/{id}/pdf", name="request2pdf")
	 * @Template("")
	 */
	public function requestToPdfAction(VacationRequest $vacationRequest) {

		/** @var  $user User */
		$user = $this->getUser();

		$workingDays = $vacationRequest->getNumberOfWorkingDays();

		$vacationRequest->setState(VacationRequest::APPROVED);
		$vacationRequest->setPdf($user->getID() . "req" . $vacationRequest->getId() . ".pdf");

		$noDaysOffLastYear = $user->getNoDaysOffLastYear();
		if($noDaysOffLastYear > 0)
		{
			if($noDaysOffLastYear >= $workingDays)
			{
				$workingDays = 0;
			}
			else
			{
				$workingDays -= $noDaysOffLastYear;
			}
		}
		$params = array(
			'user' => $user,
			'year' => $vacationRequest->getStartDate()->format('Y'),
			'request' => $vacationRequest,
			'numberOfDays' => $workingDays
		);

		$html = $this->renderView('AtesVacationBundle:Request:pdfTemplate.html.twig', $params);

		return new Response(
			$this->get('knp_snappy.pdf')->getOutputFromHtml($html),
			200,
			array(
				'Content-Type'          => 'application/pdf',
			)
		);

	}
    /**
     * @Route("/milos1", name="send_request_form_11")
     * @Template("")
     */
    public function milosAction(){
        $response = new Response();

        $response->setPublic();
        $response->setPrivate();
        $response->setContent('milos novicevic je car');

        $response->setMaxAge(600);
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;

    }

    /**
     * @Route("/new", name="send_request_form")
     * @Template("AtesVacationBundle:Request:requestForm.html.twig")
     */    
    public function sendRequestAction()
    {
       $form = $this->createForm(new VacationRequestType());
       $request = $this->getRequest();
       $form->handleRequest($request);
       
       if($form->isValid()) 
       {     
           $em = $this->getDoctrine()->getManager();                              
           $user = $this->getUser();         
           $vacationRequest = $form->getData();
           $vacationRequest->setUser($user);      
                               
           $startDate = $vacationRequest->getStartDate();
           $endDate = $vacationRequest->getEndDate();
           $days = $endDate->diff($startDate)->days;

           $holidaysRepository = $em->getRepository('AtesVacationBundle:Holidays');
           $holidaysList = $holidaysRepository->findAll();
           
            $holidays = array();
            $i = 0;
            foreach ($holidaysList as $holiday)
            {
               $holidays[] = $holiday->getDate();
            }
         
           $workingDays = $this->getWorkingDays($days, $startDate,$endDate, $holidays);
           
           $vacationRequest->setNumberOfWorkingDays($workingDays);
         
           $em->persist($vacationRequest);
           $em->flush();
          
           return $this->redirect($this->generateUrl('fos_user_profile_show'));
       } 
       return array(
           'form' => $form->createView(), 
           'user' => $this->getUser(), 
           'roles' => $this->getUser()->getRoles());
    }

    
    /**
     * @Route("/{id}/edit", name="edit_request_form")
     * @Template("AtesVacationBundle:Request:requestForm.html.twig")
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
           
       //   $vacationRequest = $form->getData();
       
          $vacationRequest->setStartDate($form->get('start_date')->getData());
          $vacationRequest->setEndDate($form->get('end_date')->getData());
          $vacationRequest->setComment($form->get('comment')->getData());
          
          $holidaysRepository = $em->getRepository('AtesVacationBundle:Holidays');
          $holidaysList = $holidaysRepository->findAll();
         
          $holidays = array();
          $i = 0;
          foreach ($holidaysList as $holiday)
          {
            $holidays[] = $holiday->getDate();
          }
          
          $startDate = $form->get('start_date')->getData();
          $endDate = $form->get('end_date')->getData();
          $days = $endDate->diff($startDate)->days;
               
          $workingDays = $this->getWorkingDays($days, $startDate,$endDate, $holidays);
         
          $vacationRequest->setNumberOfWorkingDays($workingDays);
          
          $em->flush();
          
          return $this->redirect($this->generateUrl('fos_user_profile_show'));
          
        }            
        $form->setData($vacationRequest);        
        
        $activeUser = $this->getUser();
        $roles = $activeUser->getRoles();
        return array(
            'form' => $form->createView(),
            'user' => $activeUser,
            'roles' => $roles
        );       
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
}
