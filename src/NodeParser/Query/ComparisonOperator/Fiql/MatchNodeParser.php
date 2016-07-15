<?php
namespace Xiag\Rql\Parser\NodeParser\Query\ComparisonOperator\Fiql;

use Xiag\Rql\Parser\Node\Query\ScalarOperator\LikeNode;
use Xiag\Rql\Parser\NodeParser\Query\ComparisonOperator\AbstractComparisonFiqlNodeParser;

class MatchNodeParser extends AbstractComparisonFiqlNodeParser
{
    /**
     * @inheritdoc
     */
    protected function getOperatorName()
    {
        return 'match';
    }

    /**
     * @inheritdoc
     */
    protected function createNode($field, $value)
    {
        return new LikeNode($field, $value);
    }
}
