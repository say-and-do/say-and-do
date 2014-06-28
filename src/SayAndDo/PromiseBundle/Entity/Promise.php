<?php

namespace SayAndDo\PromiseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promise
 */
class Promise
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var \SayAndDo\TaskBundle\Entity\Task
     */
    private $task;


    /**
     * Set task
     *
     * @param \SayAndDo\TaskBundle\Entity\Task $task
     * @return Promise
     */
    public function setTask(\SayAndDo\TaskBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \SayAndDo\TaskBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }
}
