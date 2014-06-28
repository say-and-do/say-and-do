<?php

namespace SayAndDo\TaskBundle\Controller;

use SayAndDo\TaskBundle\Entity\Task;
use SayAndDo\TaskBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTitle('');

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('submit', 'submit', array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        try {
            if ($form->isValid()) {
                exit('Success');
                $this->get('sd_task.service')->store($task);
                $this->redirect($this->generateUrl('say_and_do_task_success'));
            }
        } catch (ProfileException $ex) {
            $form->addError(new FormError($ex->getMessage()));
        }

        return $this->render('SayAndDoTaskBundle:Default:index.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    public function successAction()
    {
        exit('Success');
    }

}
