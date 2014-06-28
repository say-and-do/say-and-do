<?php

namespace SayAndDo\AnalyzisBundle\Controller;

use Elastica\Document;
use Elastica\Exception\NotFoundException;
use FOS\ElasticaBundle\Elastica\Index;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /** @var Index $index */
        $index = $this->get('fos_elastica.index.articles');

        $documents = $index->getType('articles')->search();

        return $this->render(
            'SayAndDoAnalyzisBundle:Default:index.html.twig',
            array(
                'index'     => $index->getOriginalName(),
                'documents' => $documents,
            )
        );
    }

    public function addDocumentAction(Request $request)
    {
        /** @var Index $index */
        $index    = $this->get('fos_elastica.index.articles');
        $document = new Document(
            '',
            [
                'url'     => $request->request->get('url'),
                'title'   => $request->request->get('title'),
                'content' => $request->request->get('content')
            ], 'article'
        );
        $index->addDocuments([$document]);
        $index->flush();

        return $this->redirect($this->generateUrl('say_and_do_analyzis_homepage'));
    }

    public function viewDocumentAction($id)
    {
        /** @var Index $index */
        $index    = $this->get('fos_elastica.index.articles');
        $document = $index->getType('articles')->getDocument($id);

        return $this->render('SayAndDoAnalyzisBundle:Default:view.html.twig', ['document' => $document]);
    }

    public function removeDocumentAction($id)
    {
        /** @var Index $index */
        $index = $this->get('fos_elastica.index.articles');
        try {
            $index->getType('articles')->deleteById($id);
            $index->flush();
        } catch (NotFoundException $e) {
        }

        return $this->redirect($this->generateUrl('say_and_do_analyzis_homepage'));
    }
}
