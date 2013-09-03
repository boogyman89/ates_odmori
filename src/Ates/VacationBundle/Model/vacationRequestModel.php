<?php
namespace Ates\VacationBundle\Model;

use Ates\UserBundle\Entity\User;
use Ates\VacationBundle\Entity\VacationRequest;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManager;

class vacationRequestModel 
{
    const MAX = 5;
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function getUserRequests($user, $page, $filter = null)
    {
        $requestRepository = $this->entityManager->getRepository('AtesVacationBundle:VacationRequest');
        
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
