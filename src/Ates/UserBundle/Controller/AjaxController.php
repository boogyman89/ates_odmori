<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ates\VacationBundle\Entity\VacationRequest;
use Ates\VacationBundle\Form\Type\HolidaysType;
use Ates\VacationBundle\Entity\Holidays;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    public function findRequestsAction()
    {
        
        $request = $this->getRequest();
        
        $first_name = $request->request->get('name');
        $last_name = $request->request->get('last_name');
        
        
        $em = $this->getDoctrine()->getManager();
        
        $repository = $em->getRepository('AtesUserBundle:User')->createQueryBuilder('u');
        
        if($first_name != null)
        {
            $repository->where('u.first_name LIKE :f_name')
                ->setParameter('f_name', '%'.$first_name.'%');
        }
        if($last_name != null)
        {
            $repository->andWhere('u.last_name LIKE :l_name')
                ->setParameter('l_name', '%'.$last_name.'%');
        }

        $query = $repository->getQuery();
        $users = $query->getResult();
        
        
        
        
        $allRequests = array();
        foreach($users as $user)
        {
            $query = $em->getRepository('AtesVacationBundle:VacationRequest')->createQueryBuilder('r')
                ->where('r.id_user = :id_u')
                ->setParameter('id_u', $user->getId())
                ->orderBy('r.start_date','ASC')
                ->getQuery();
            $requests = $query->getResult();
            
            $userName = $user->getFirstName().' '.$user->getLastName();
            $allRequests[$userName] = $requests;
        }
        
        
        
        return $this->Render('AtesUserBundle:Ajax:requests.html.twig', array(                    
            'all_requests' => $allRequests
        ));
         
    }
    
    
     public function findUsersAction()
    {
        $request = $this->getRequest();
        
        $first_name = $request->request->get('name');
        $last_name = $request->request->get('last_name');
        
        $em = $this->getDoctrine()->getManager();
        
        $repository = $em->getRepository('AtesUserBundle:User')->createQueryBuilder('u');
        
        if($first_name != null)
        {
            $repository->where('u.first_name LIKE :f_name')
                ->setParameter('f_name', '%'.$first_name.'%');
        }
        if($last_name != null)
        {
            $repository->andWhere('u.last_name LIKE :l_name')
                ->setParameter('l_name', '%'.$last_name.'%');
        }

        $query = $repository->getQuery();
        $users = $query->getResult();
        
        return $this->Render('AtesUserBundle:Ajax:users.html.twig', array(                    
            'users' => $users
        ));
    }
    
    public function findRequestsForUserAction($filter)
    {
       
       $user = $this->container->get('security.context')->getToken()->getUser();
       
       $em = $this->getDoctrine()->getManager();
       if($filter != 'all')
       {
            $query = $em->getRepository('AtesVacationBundle:VacationRequest')->createQueryBuilder('r')
                 ->where('r.id_user = :id_u')
                 ->andWhere('r.state = :filter')
                 ->setParameter('id_u', $user->getId())
                 ->setParameter('filter', $filter)
                 ->orderBy('r.start_date','ASC')
                 ->getQuery();
             $requests = $query->getResult();
       }
       else
       {
           $requests = $em->getRepository('AtesVacationBundle:VacationRequest')->findBy(array( 'id_user' => $user->getId()));
       }
       
        return $this->Render('AtesUserBundle:Ajax:userRequests.html.twig', array(                    
            'requests' => $requests
        ));
         
        //return new Response($filter);
    }
}