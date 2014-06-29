<?php

namespace SayAndDo\TaskBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SayAndDo\ProfileBundle\Entity\Profile;
use SayAndDo\PromiseBundle\Entity\Promise;
use SayAndDo\TaskBundle\DependencyInjection\TaskStatus;
use SayAndDo\TaskBundle\Entity\Task;
use SayAndDo\TaskBundle\Exception\TaskStoreException;
use SayAndDo\TaskBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $promise = new Promise();
        $promise->setExcerpt($request->request->get('result'));
        $promise->setUrl($request->request->get('url'));

        $task = new Task();
        $task->setStatus(TaskStatus::STATUS_NEW);

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->getForm();

        $form->handleRequest($request);
        try {

            if ($form->isValid()) {

                $formParams = $request->request->get('form');

                /** @var EntityManager $repo */
                $em = $this->get('doctrine.orm.default_entity_manager');

                /** @var EntityRepository $repo */
                $repo = $em->getRepository('SayAndDoProfileBundle:Profile');

                /** @var Profile $profile */
                $profile = $repo->findOneBy(['title' => $request->request->get('profile')]);

                if (!$profile) {
                    $profile = new Profile();

                    $profile->setTitle($request->request->get('profile'));
                    $profile->setPoints(50);
                    $profile->setDescription('');
                    $profile->setPosition('');
                    $profile->setPoliticalParty('');

                    $em->persist($profile);
                    $em->flush();
                }

                $task->setProfile($profile);

                $task->setPromise($promise);
                $promise->setTask($task);

                $this->get('sd_task.service')->store($task);
                $this->redirect($this->generateUrl('say_and_do_task_success'));
            }
        } catch (TaskStoreException $ex) {
            $form->addError(new FormError($ex->getMessage()));
        }

        return $this->render(
            'SayAndDoTaskBundle:Default:index.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function successAction()
    {
        return new Response('Success..!');
    }

    public function extractAction(Request $request)
    {
        $url = $request->request->get('url');

        $content = $this->get('sad_extract.service')->getArticle($url);

        if ($content === null) {
            $content = 'Negalime išimti straipsnio iš pateiktos nuorodos.';
        }

        return new Response($content);
    }

    public function recentAction()
    {
        /** @var EntityRepository $repo */
        $repo = $this->get('doctrine.orm.default_entity_manager')->getRepository('SayAndDoTaskBundle:Task');

        return $this->render(
            'SayAndDoTaskBundle:Default:recent.html.twig',
            array(
                'recent_tasks' => $repo->findBy(
                    array('status' => TaskStatus::STATUS_CONFIRMED),
                    array('id' => 'desc'),
                    4
                )
            )
        );
    }

}
