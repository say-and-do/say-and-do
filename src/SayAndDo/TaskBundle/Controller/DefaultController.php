<?php

namespace SayAndDo\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SayAndDoTaskBundle:Default:index.html.twig', array('name' => $name));
    }
}
