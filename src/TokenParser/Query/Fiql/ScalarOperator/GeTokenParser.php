<?php
namespace Xiag\Rql\Parser\TokenParser\Query\Fiql\ScalarOperator;

use Xiag\Rql\Parser\TokenParser\Query\Fiql\AbstractScalarOperatorTokenParser;
use Xiag\Rql\Parser\Node\Query\ScalarOperator\GeNode;

/**
 */
class GeTokenParser extends AbstractScalarOperatorTokenParser
{
    /**
     * @inheritdoc
     */
    protected function getOperatorNames()
    {
        return array('ge', '>=');
    }

    /**
     * @inheritdoc
     */
    protected function createNode($field, $value)
    {
        return new GeNode($field, $value);
    }
}
