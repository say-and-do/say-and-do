<?php

namespace SayAndDo\AnalyzisBundle\Service;

use Elastica\Facet\Terms;
use Elastica\Query;
use Elastica\Type;

class ThresholdService
{
    const KEYWORDS = '';
    /** @var  Type */
    protected $type;

    /**
     * @param string $keyword
     * @internal param mixed $query
     * @return \Elastica\ResultSet
     */
    public function getCandidates($keyword = self::KEYWORDS)
    {
        $query = new Query\MultiMatch();
        $query->setFields(['content']);
        $query->setQuery($keyword);

        if (empty($keyword)) {
            $query = new Query\MatchAll();
        }
        $facet = new Terms('terms');
        $facet->setField('content');
        $facet->setSize(10);

        $masterQuery = new Query();
        $masterQuery->setQuery($query);
        $masterQuery->addFacet($facet);

        return $this->type->search($masterQuery);
    }

    /**
     * @param Type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
