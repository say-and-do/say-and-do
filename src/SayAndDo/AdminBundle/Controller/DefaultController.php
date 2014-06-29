<?php

namespace SayAndDo\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SayAndDo\TaskBundle\DependencyInjection\TaskStatus;
use SayAndDo\TaskBundle\Entity\Task;
use SayAndDo\TaskBundle\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SayAndDoAdminBundle:Default:index.html.twig', array('name' => $name));
    }

    public function tasksAction()
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('SayAndDoTaskBundle:Task');

        return $this->render(
            'SayAndDoAdminBundle:Default:tasks.html.twig',
            [
                'tasks' => $repo->findBy(
                    [
                        'status' => TaskStatus::STATUS_NEW
                    ]
                )
            ]
        );
    }

    /**
     * @ParamConverter("task", class="SayAndDoTaskBundle:Task")
     */
    public function viewTaskAction(Task $task)
    {
        if ($task) {
            /** @var ProfileService $profileService */
            $profileService = $this->get('sd_profile.service');

            $profile = $task->getProfile();

            return $this->render(
                'SayAndDoAdminBundle:Default:task.html.twig',
                [
                    'task'              => $task,
                    'profile_rating'    => $profile ? $profileService->getRating($profile) : null,
                    'tasks_confirmed'   => $profile ? $profileService->getTasksConfirmed($profile) : null,
                    'tasks_in_progress' => $profile ? $profileService->getTasksInProgress($profile) : null,
                    'tasks_done'        => $profile ? $profileService->getTasksDone($profile) : null,
                ]
            );
        }

        return $this->redirect($this->generateUrl('say_and_do_admin_tasks'));

    }

    public function deleteTaskAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('SayAndDoTaskBundle:Task');

        /** @var TaskService $service */
        $service = $this->get('sd_task.service');

        /** @var Task $task */
        $task = $repo->find($id);

        if ($task) {
            $em->remove($task);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('say_and_do_admin_tasks'));
    }

    public function confirmTaskAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('SayAndDoTaskBundle:Task');

        /** @var TaskService $service */
        $service = $this->get('sd_task.service');

        /** @var Task $task */
        $task = $repo->find($id);

        if ($task) {
            $service->confirmTask($task);
        }

        return $this->redirect($this->generateUrl('say_and_do_admin_tasks'));
    }
}
