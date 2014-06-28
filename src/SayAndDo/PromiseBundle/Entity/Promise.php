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
     * @var \SayAndDo\TaskBundle\Entity\Task
     */
    private $task;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $proofs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proofs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * Add proofs
     *
     * @param \SayAndDo\ProofBundle\Entity\Proof $proofs
     * @return Promise
     */
    public function addProof(\SayAndDo\ProofBundle\Entity\Proof $proofs)
    {
        $this->proofs[] = $proofs;

        return $this;
    }

    /**
     * Remove proofs
     *
     * @param \SayAndDo\ProofBundle\Entity\Proof $proofs
     */
    public function removeProof(\SayAndDo\ProofBundle\Entity\Proof $proofs)
    {
        $this->proofs->removeElement($proofs);
    }

    /**
     * Get proofs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProofs()
    {
        return $this->proofs;
    }
}
