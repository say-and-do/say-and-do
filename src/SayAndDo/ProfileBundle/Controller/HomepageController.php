<?php

namespace SayAndDo\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function homepageAction()
    {
        return $this->render('SayAndDoProfileBundle:Homepage:homepage.html.twig');
    }
}
