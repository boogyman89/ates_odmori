<?php

namespace Ates\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Ates\VacationBundle\Entity\VacationRequest;

class RegistrationController extends BaseController
{
    public function confirmedAction()
    {
        
        $response = parent::confirmedAction();

        // send slava request
        $user = $this->container->get('security.context')->getToken()->getUser();
        $date = new \DateTime("now");

        $vacationRequest = new VacationRequest();

        $vacationRequest->setStartDate($user->getDateOfSlava()); 
        $vacationRequest->setEndDate($user->getDateOfSlava());
        $vacationRequest->setIdUser($user->getId());
        $vacationRequest->setSubmitted($date);
        $vacationRequest->setState("approved");
        $vacationRequest->setEditTime($date);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($vacationRequest);
        $em->flush();
        
        return $response;
    }
}

