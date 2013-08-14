<?php
namespace Ates\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    /**
     * @Route("/", name="employees_vacations_homepage")
     * @Template("AtesUserBundle:Default:index.html.twig", vars={"post"})
     */
    public function indexAction()
    {               
        return null;
    }
  
}
