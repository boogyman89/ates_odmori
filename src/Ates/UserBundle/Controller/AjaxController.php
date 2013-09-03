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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Ates\UserBundle\Entity\User;

use Ates\VacationBundle\Model\vacationRequestModel;


class AjaxController extends Controller
{
    //const MAX = 5;
    
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
            /*
            $query = $em->getRepository('AtesVacationBundle:VacationRequest')->createQueryBuilder('r')
                ->where('r.user_id = :id_u')
                ->setParameter('id_u', $user->getId())
                ->orderBy('r.start_date','ASC')
                ->getQuery();
            $requests = $query->getResult();
            
            return new Response(count($requests));
             * 
             */
            
            $requests = $user->getVacationRequests();

            $userName = $user->getFirstName().' '.$user->getLastName();
            $allRequests[$userName] = $requests;
        }
        
        
        return array(                    
            'all_requests' => $allRequests
        );

         
       
    }
    
    /**
     * @Route("/ajax/find_request_by_id", name="ajax_find_request_by_id")
     * @Template("AtesUserBundle:Ajax:singleRequest.html.twig", vars={"request"})
     */
    
    public function findRequestByIdAction()
    {
        $request = $this->getRequest();
        
        $id = $request->request->get('id');
        
         $em = $this->getDoctrine()->getManager();
         $repository = $em->getRepository('AtesVacationBundle:VacationRequest');
         $vacationRequest = $repository->find($id);
         
         return array(
             'request' => $vacationRequest
         );
    }


    /**
     * @Route("/ajax/admin_find_users", name="ajax_request_find_user")
     * @Template("AtesUserBundle:Ajax:users.html.twig", vars={"users"})
     */
     public function findUsersAction()
    {
         
         
         //
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
     * @Route("/ajax/find_user_requests/{filter}/{page}", name="ajax_find_user_request",  requirements={"page" = "\d+"}, defaults={ "page" = 1} )
     * @Route("/ajax/find_user_requests", name="ajax_find_user_request_base" )
     * @Template("AtesUserBundle:Ajax:userRequests.html.twig", vars={"requests","filter"})
     * @param int $page
     */
    public function findRequestsForUserAction($filter, $page )
    {
        $user = $this->getUser();
//        \Doctrine\Common\Util\Debug::dump($user,2);exit;
       
        $em = $this->getDoctrine()->getManager();
        
        $vRModel = new vacationRequestModel();
        $pagerfanta = $vRModel->getUserRequests($em, $user, $page, $filter);
        /*
        $queryBuilder = $em->createQueryBuilder();
        
        $queryBuilder->select('r')
            ->from('AtesVacationBundle:VacationRequest', 'r')
            ->where('r.user = :user')
            ->setParameter('user', $user);
            
        if('all' != $filter)
        {
            $queryBuilder->andWhere('r.state = :filter')
                        ->setParameter('filter', $filter);
        }

        
        $adapter = new DoctrineORMAdapter($queryBuilder);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::MAX);   

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
       */
        return array(                    
            'requests' => $pagerfanta,
            'filter' => $filter
        );
         
        //return new Response($filter);
    }
}