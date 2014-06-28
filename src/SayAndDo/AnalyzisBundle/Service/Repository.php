<?php

namespace SayAndDo\AnalyzisBundle\Service;

use Elastica\Type;
use FOS\ElasticaBundle\Elastica\Index;

class Repository
{
    /** @var  Type */
    protected $type;
    /** @var  Index */
    protected $index;

    /**
     * @param string $id
     * @return \Elastica\Document
     */
    public function get($id)
    {
        return $this->type->getDocument($id);
    }

    /**
     * @param mixed $data
     */
    public function create($data)
    {
        $this->type->getIndex()->addDocuments([$this->type->createDocument('', $data)]);
        $this->type->getIndex()->flush();
    }

    /**
     * @param string $id
     */
    public function remove($id)
    {
        $this->type->deleteById($id);
        $this->type->getIndex()->flush();
    }

    /**
     * @return \Elastica\ResultSet
     */
    public function getAll()
    {
        return $this->type->search();
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @param Index $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }
}
