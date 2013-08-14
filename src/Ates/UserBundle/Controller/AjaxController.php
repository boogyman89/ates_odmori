<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class AjaxController extends Controller
{
    
    /**
     * @Route("/ajax/admin_find_requests", name="ajax_request_find_requests")
     * @Template("AtesUserBundle:Ajax:requests.html.twig", vars={"all_requests"})
     */
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
        
        
        
        return array(                    
            'all_requests' => $allRequests
        );
         
    }
    
    /**
     * @Route("/ajax/admin_find_users", name="ajax_request_find_user")
     * @Template("AtesUserBundle:Ajax:users.html.twig", vars={"users"})
     */
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
        
        return array(                    
                'users' => $users
            );
    }
    
    /**
     * @Route("/ajax/find_user_requests/{filter}", name="ajax_find_user_request")
     * @Template("AtesUserBundle:Ajax:userRequests.html.twig", vars={"requests"})
     */
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
       
        return array(                    
            'requests' => $requests
        );
         
        //return new Response($filter);
    }
}