<?php
namespace Ates\UserBundle\Controller;
  
use Ates\VacationBundle\Entity\VacationRequest;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class ProfileController extends BaseController
{    
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $repository = $this->container->get('doctrine')
          ->getRepository('AtesVacationBundle:VacationRequest');
        
        $requests = $repository->findAllByUserId($user->getId());        
        
        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user, 'requests' => $requests));
    }
}