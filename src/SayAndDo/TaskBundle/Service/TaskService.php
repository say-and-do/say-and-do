<?php


namespace SayAndDo\TaskBundle\Service;


use Doctrine\ORM\EntityManager;
use SayAndDo\TaskBundle\DependencyInjection\TaskPoints;
use SayAndDo\TaskBundle\DependencyInjection\TaskStatus;
use SayAndDo\TaskBundle\Entity\Task;
use SayAndDo\TaskBundle\Exception\TaskAlreadyCompletedException;
use SayAndDo\TaskBundle\Exception\TaskAlreadyInProgressException;

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

        if ($task->getProfile()) {
            $task->getProfile()->setPoints($task->getProfile()->getPoints() + TaskPoints::FOR_NEW_TASK);
            $this->saveEntity($task->getProfile());
        }
    }

    public function startTask(Task $task)
    {
        if ($task->getStatus() == TaskStatus::STATUS_IN_PROGRESS) {
            throw new TaskAlreadyInProgressException();
        }

        $task->setStatus(TaskStatus::STATUS_IN_PROGRESS);
        $this->store($task);
    }

    public function completeTask(Task $task)
    {
        if ($task->getStatus() == TaskStatus::STATUS_DONE) {
            throw new TaskAlreadyCompletedException();
        }

        $task->setStatus(TaskStatus::STATUS_DONE);
        $this->store($task);

        if ($task->getProfile()) {
            $task->getProfile()->setPoints($task->getProfile()->getPoints() + TaskPoints::FOR_FINISHED_TASK);
            $this->saveEntity($task->getProfile());
        }
    }
} 