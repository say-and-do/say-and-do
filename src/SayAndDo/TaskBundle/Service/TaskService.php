<?php


namespace SayAndDo\TaskBundle\Service;


use Doctrine\ORM\EntityManager;

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

} 