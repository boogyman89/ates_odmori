<?php

namespace Ates\VacationBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VacationRequestRepository extends EntityRepository
{
    public function findAllByUserId($user_id)
    {
        return $this->getEntityManager()
                ->createQuery(
                        'SELECT p 
                         FROM AtesVacationBundle:VacationRequest p
                         WHERE p.id_user = :user_id')
                ->setParameter('user_id', $user_id)
                ->getResult();
    }
}
