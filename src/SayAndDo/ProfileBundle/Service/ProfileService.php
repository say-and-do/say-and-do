<?php

namespace SayAndDo\ProfileBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use SayAndDo\ProfileBundle\Entity\Profile;
use SayAndDo\TaskBundle\DependencyInjection\TaskStatus;
use SayAndDo\TaskBundle\Entity\Task;

class ProfileService
{
    public function getTasksConfirmed(Profile $profile)
    {
        $tasks = new ArrayCollection();

        /** @var Task $task */
        foreach ($profile->getTasks() as $task) {
            if ($task->getStatus() == TaskStatus::STATUS_CONFIRMED) {
                $tasks->add($task);
            }
        }

        return $tasks;
    }

    public function getTasksNew(Profile $profile)
    {
        $tasks = new ArrayCollection();

        /** @var Task $task */
        foreach ($profile->getTasks() as $task) {
            if ($task->getStatus() == TaskStatus::STATUS_NEW) {
                $tasks->add($task);
            }
        }

        return $tasks;
    }

    public function getTasksInProgress(Profile $profile)
    {
        $tasks = new ArrayCollection();

        /** @var Task $task */
        foreach ($profile->getTasks() as $task) {
            if ($task->getStatus() == TaskStatus::STATUS_IN_PROGRESS) {
                $tasks->add($task);
            }
        }

        return $tasks;
    }

    public function getTasksDone(Profile $profile)
    {
        $tasks = new ArrayCollection();

        /** @var Task $task */
        foreach ($profile->getTasks() as $task) {
            if ($task->getStatus() == TaskStatus::STATUS_DONE) {
                $tasks->add($task);
            }
        }

        return $tasks;
    }
}
