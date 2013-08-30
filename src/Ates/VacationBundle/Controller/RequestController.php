<?php

namespace Ates\VacationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use \Ates\VacationBundle\Entity\VacationRequest;
use \Ates\VacationBundle\Form\Type\VacationRequestType;

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
     * @Route("/new", name="send_request_form")
     * @Template("AtesVacationBundle:Request:requestForm.html.twig")
     */    
    public function sendRequestAction()
    {
        $request = $this->getRequest();
        $form = $this->createForm(new VacationRequestType());

        $form->handleRequest($request);
        if($form->isValid())
        {
            $vacationRequest = $form->getData();
            $vacationRequest->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($vacationRequest);
            $em->flush();

            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }
        return array(
            'form' => $form->createView()
        );
    }

    
    /**
     * @Route("/{id}/edit", name="edit_request_form")
     * @Template("AtesVacationBundle:Request:requestForm.html.twig")
     */  
    public function editRequestAction(VacationRequest $vacationRequest)
    {        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VacationRequestType(), $vacationRequest);
            
        $form->handleRequest($this->getRequest());
        if($form->isValid()) 
        {
          $em->flush();
          return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
