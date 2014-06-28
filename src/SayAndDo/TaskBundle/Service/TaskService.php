<?php


namespace SayAndDo\TaskBundle\Service;


use Doctrine\ORM\EntityManager;
use SayAndDo\TaskBundle\DependencyInjection\TaskPoints;
use SayAndDo\TaskBundle\DependencyInjection\TaskStatus;
use SayAndDo\TaskBundle\Entity\Task;

class TaskService {

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function store($task)
    {
        $this->saveEntity($task);
    }

    private function saveEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function confirmTask(Task $task)
    {
        $task->setStatus(TaskStatus::STATUS_CONFIRMED);
        $this->store($task);
    }

    public function startTask(Task $task)
    {
        $task->setStatus(TaskStatus::STATUS_IN_PROGRESS);
        $this->store($task);
    }

    public function completeTask(Task $task)
    {
        $task->setStatus(TaskStatus::STATUS_DONE);
        $this->store($task);

        $task->getProfile()->setPoints($task->getProfile()->getPoints() + TaskPoints::FOR_FINISHED_TASK);
        $this->saveEntity($task->getProfile());
    }
} 