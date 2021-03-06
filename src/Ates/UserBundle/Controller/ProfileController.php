<?php
namespace Ates\UserBundle\Controller;
  
use Ates\VacationBundle\Entity\VacationRequest;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Ates\VacationBundle\Model\vacationRequestModel;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends BaseController
{    
    
    /**
    * @Route("/profile/", name="fos_user_profile_show" )
    * @Template("AtesUserBundle:Profile:show.html.twig", vars={"requests","roles","user"})
    */
    public function showAction()
    {
        $page = 1;
                
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $roles = $user->getRoles();
        
        
        $pagerfanta = $this->container->get('vacation_request.model')->getUserRequests($user, $page);
                                
//        $response = new Response();
//        $html = $this->container->get('templating')->render("AtesUserBundle:Profile:show.html.twig",  array(
//            'user' => $user,
//            'requests' => $pagerfanta,
//            'roles' => $roles
//        ));
//        $response->setPublic();
//        $response->setPrivate();
//        $response->setContent($html);
//
//        $response->setMaxAge(200);
//        $response->setSharedMaxAge(200);
//        $response->headers->addCacheControlDirective('must-revalidate', true);
//        return $response;

		return array(
			'user' => $user,
			'requests' => $pagerfanta,
			'roles' => $roles
		);
    } 
    
    
    /**
    * @Route("/profile/edit", name="fos_user_profile_edit")
    * @Template("AtesUserBundle:Profile:edit.html.twig", vars={"form","roles","user"})
    */
    public function editAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //@var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface 
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        //@var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface
        $formFactory = $this->container->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                /// @var $userManager \FOS\UserBundle\Model\UserManagerInterface
                $userManager = $this->container->get('fos_user.user_manager');

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_profile_show');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }
        
        $activeUser = $this->container->get('security.context')->getToken()->getUser();
        $roles = $activeUser->getRoles();
        
        return array(
                'form' => $form->createView(),
                'user' => $activeUser,
                'roles' => $roles
            );
    }
     
}