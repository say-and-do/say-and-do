<?php

namespace SayAndDo\AnalyzisBundle\Controller;

use Elastica\Exception\NotFoundException;
use FOS\ElasticaBundle\Elastica\Index;
use SayAndDo\AnalyzisBundle\Service\Repository;
use SayAndDo\AnalyzisBundle\Service\ThresholdService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function initAction()
    {
        /** @var Index $index */
        $index = $this->get('fos_elastica.index.articles');

        $message = 'Index already exists';
        if (!$index->exists()) {
            $index->create();
            $message = 'Index created';
        }

        return JsonResponse::create($message);
    }

    public function indexAction()
    {
        /** @var Repository $repo */
        $repo = $this->get('say_and_do.analysis.repository.article');

        return $this->render(
            'SayAndDoAnalyzisBundle:Default:index.html.twig',
            array(
                'documents' => $repo->getAll(),
            )
        );
    }

    public function addDocumentAction(Request $request)
    {
        $document = [
            'url'     => $request->request->get('url'),
            'title'   => $request->request->get('title'),
            'content' => $request->request->get('content')
        ];

        /** @var Repository $repo */
        $repo = $this->get('say_and_do.analysis.repository.article');

        $repo->create($document);

        return $this->redirect($this->generateUrl('say_and_do_analyzis_homepage'));
    }

    public function viewDocumentAction($id)
    {
        /** @var Repository $repo */
        $repo     = $this->get('say_and_do.analysis.repository.article');
        $document = $repo->get($id);

        return $this->render('SayAndDoAnalyzisBundle:Default:view.html.twig', ['document' => $document]);
    }

    public function removeDocumentAction($id)
    {
        /** @var Repository $repo */
        $repo = $this->get('say_and_do.analysis.repository.article');
        try {
            $repo->remove($id);
        } catch (NotFoundException $e) {
        }

        return $this->redirect($this->generateUrl('say_and_do_analyzis_homepage'));
    }

    public function queryDocumentsAction(Request $request)
    {
        /** @var ThresholdService $threshold */
        $threshold = $this->get('say_and_do.analysis.threshold');

        $query = $request->isMethod('POST') ? $request->get('query') : '';
        $hits  = $request->isMethod('POST') ? $threshold->getCandidates($query) : null;

        var_dump($hits->getFacets()['terms']);

        return $this->render(
            'SayAndDoAnalyzisBundle:Default:query.html.twig',
            [
                'hits'  => $hits,
                'query' => $query
            ]
        );
    }
}
