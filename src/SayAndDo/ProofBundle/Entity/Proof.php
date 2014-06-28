<?php

namespace SayAndDo\ProofBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proof
 */
class Proof
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \SayAndDo\PromiseBundle\Entity\Promise
     */
    private $promise;


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
     * Set promise
     *
     * @param \SayAndDo\PromiseBundle\Entity\Promise $promise
     * @return Proof
     */
    public function setPromise(\SayAndDo\PromiseBundle\Entity\Promise $promise = null)
    {
        $this->promise = $promise;

        return $this;
    }

    /**
     * Get promise
     *
     * @return \SayAndDo\PromiseBundle\Entity\Promise 
     */
    public function getPromise()
    {
        return $this->promise;
    }
}
