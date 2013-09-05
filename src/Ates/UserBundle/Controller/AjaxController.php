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
        $filter = $request->request->get('filter');
        
        if(null != $request->request->get('page'))
        {
            $page = $request->request->get('page');
        }
        else
        {
            $page = 1;
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $requestRepository = $em->getRepository('AtesVacationBundle:VacationRequest');
        $queryBuilder = $requestRepository->createQueryBuilder('r')
                        ->orderBy('r.created','DESC');
        
        if(null != $first_name || null != $last_name)
        {
            $queryBuilder->leftJoin('r.user', 'u');
        }
        
        if(null != $first_name)
        {
            //leftJoin('u.Phonenumbers p WITH u.id = 2');
            $queryBuilder->where('u.first_name LIKE :f_name')
                ->setParameter('f_name', '%'.$first_name.'%');
        }
        if(null != $last_name)
        {
            $queryBuilder->andWhere('u.last_name LIKE :l_name')
                ->setParameter('l_name', '%'.$last_name.'%');
        }
        if('all' != $filter)
        {
            $queryBuilder->andWhere('r.state = :state')
                ->setParameter('state', $filter);
        }

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(7);
        $pagerfanta->setCurrentPage(1);  

       

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        
        return array(                    
            'requests' => $pagerfanta
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
       
        $pagerfanta = $this->container->get('vacation_request.model')->getUserRequests($user, $page, $filter);
        
        return array(                    
            'requests' => $pagerfanta,
            'filter' => $filter
        );
    }
    
    /**
     * @Route("/ajax/get_pending_requests/{page}", name="ajax_get_pending_requests",  requirements={"page" = "\d+"}, defaults={ "page" = 1} )
     * @Route("/ajax/get_pending_requests", name="ajax_get_pending_requests_base" )
     * @Template("AtesUserBundle:Ajax:pendingRequests.html.twig", vars={"requests"})
     * @param int $page
     */
    public function getPendingRequests( $page )
    {
        $pagerfanta = $this->container->get('vacation_request.model')->getPendingRequests($page);
        
        return array(
            'requests' => $pagerfanta
        );
    }
}