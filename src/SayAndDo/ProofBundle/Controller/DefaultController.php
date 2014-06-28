<?php

namespace SayAndDo\ProofBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SayAndDoProofBundle:Default:index.html.twig', array('name' => $name));
    }
}
