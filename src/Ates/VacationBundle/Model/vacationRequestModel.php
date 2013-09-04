<?php
namespace Ates\VacationBundle\Model;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Doctrine\ORM\EntityManager;

class vacationRequestModel 
{
    const MAX_PROFILE = 10;
    const MAX_PENDING = 5;
    const MAX_SEARCH = 5;
    
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function getUserRequests($user, $page, $filter = null)
    {
        $requestRepository = $this->entityManager->getRepository('AtesVacationBundle:VacationRequest');
        
        $queryBuilder = $requestRepository->createQueryBuilder('r')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->orderBy('r.created','DESC');
        
        if( null != $filter && 'all' != $filter )
        {
            $queryBuilder->andWhere('r.state = :filter')
                        ->setParameter('filter', $filter);
        }
        
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::MAX_PROFILE);
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
    
    public function getPendingRequests($page = null)
    {
        $requestRepository = $this->entityManager->getRepository('AtesVacationBundle:VacationRequest');
        
        $queryBuilder = $requestRepository->createQueryBuilder('r')
            ->where('r.state = :s')
            ->setParameter('s','pending')
            ->orderBy('r.created','DESC');
        
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::MAX_PENDING);
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
