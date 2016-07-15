<?php
namespace Xiag\Rql\Parser\NodeParser\Query\ComparisonOperator\Fiql;

use Xiag\Rql\Parser\Node\Query\ScalarOperator\GeNode;
use Xiag\Rql\Parser\NodeParser\Query\ComparisonOperator\AbstractComparisonFiqlNodeParser;

class GteNodeParser extends AbstractComparisonFiqlNodeParser
{
    /**
     * @inheritdoc
     */
    protected function getOperatorName()
    {
        return 'gte';
    }

    /**
     * @inheritdoc
     */
    protected function createNode($field, $value)
    {
        return new GeNode($field, $value);
    }
}
