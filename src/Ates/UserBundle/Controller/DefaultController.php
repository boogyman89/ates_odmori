<?php

namespace Ates\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AtesUserBundle:Default:index.html.twig', array('name' => 'Nenad'));
    }
}
