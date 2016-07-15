<?php

namespace Xiag\Rql\Parser\Node;

use Xiag\Rql\Parser\AbstractNode;

/**
 * @codeCoverageIgnore
 * 
 * aggregate(fieldName)
 */
class AggregateFunctionNode extends AbstractNode
{

    private $function;
    private $field;

    public function __construct( $function, $field )
    {
        $this->function = $function;
        $this->field    = $field;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function getNodeName()
    {
        return $this->function;
    }

    public function __toString()
    {
        return sprintf( '%s(%s)', $this->function, $this->field );
    }

}
