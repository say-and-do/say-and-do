<?php

namespace SayAndDo\TaskBundle\Controller;

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
        $promise->setUrl($request->request->get('result'));
        //$promise->setUrl($request->request->get('result');
        //$this->get('sad_promise.service')->store($pr);

        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setStatus(TaskStatus::STATUS_NEW);

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description', 'textarea')
//            ->add(
//                'link',
//                'entity',
//                array(
//                    'class' => 'SayAndDoPromiseBundle:Promise',
//                    'property' => 'url'
//                )
//            )
//            ->add('submit', 'submit', array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);
        try {

            if ($form->isValid()) {

                $task->setPromise($promise);

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

    public function extractAction()
    {
        return new Response('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');
    }

}
