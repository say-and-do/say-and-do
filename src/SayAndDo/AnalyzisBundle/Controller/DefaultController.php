<?php

namespace SayAndDo\AnalyzisBundle\Controller;

use FOS\ElasticaBundle\Elastica\Index;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /** @var Index $index */
        $index = $this->get('fos_elastica.index.articles');
        print_r($index->getStats()->getData());
        return $this->render('SayAndDoAnalyzisBundle:Default:index.html.twig', array('name' => ''));
    }
}
