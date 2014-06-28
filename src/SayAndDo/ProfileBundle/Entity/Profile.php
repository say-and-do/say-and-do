<?php

namespace SayAndDo\ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 */
class Profile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $political_party;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tasks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Profile
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Profile
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set political_party
     *
     * @param string $politicalParty
     * @return Profile
     */
    public function setPoliticalParty($politicalParty)
    {
        $this->political_party = $politicalParty;

        return $this;
    }

    /**
     * Get political_party
     *
     * @return string 
     */
    public function getPoliticalParty()
    {
        return $this->political_party;
    }

    /**
     * Add tasks
     *
     * @param \SayAndDo\TaskBundle\Entity\Task $tasks
     * @return Profile
     */
    public function addTask(\SayAndDo\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \SayAndDo\TaskBundle\Entity\Task $tasks
     */
    public function removeTask(\SayAndDo\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
