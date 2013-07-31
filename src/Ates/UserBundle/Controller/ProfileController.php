<?php
namespace Ates\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('AtesUserBundle:Profile:show.html.twig' , array('user' => $user));
    }
}