<?php
namespace Ates\VacationBundle\Model;

use Ates\UserBundle\Entity\User;
use Ates\VacationBundle\Entity\VacationRequest;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Symfony\Component\HttpFoundation\Response;

class vacationRequestModel 
{
    const MAX = 3;
    
    public function getUserRequests($em, $user, $page, $filter = null)
    {
        $requestRepository = $em->getRepository('AtesVacationBundle:VacationRequest');
        
        $queryBuilder = $requestRepository->createQueryBuilder('r')
            ->where('r.user = :user')
            ->setParameter('user', $user);
        
        if( null != $filter && 'all' != $filter )
        {
            $queryBuilder->andWhere('r.state = :filter')
                        ->setParameter('filter', $filter);
        }
        
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::MAX);
        $pagerfanta->setCurrentPage(1);  

       if( !$page ) {
            $page = 1;
       }

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        
        return $pagerfanta;
    }
}
?>
