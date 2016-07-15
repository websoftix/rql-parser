<?php

namespace Xiag\Rql\Parser\Node\Query;

/**
 * @codeCoverageIgnore
 */

/**
 * between(field,from,to)
 */
class BetweenNode extends AbstractComparisonOperatorNode
{

    private $from;
    private $to;

    public function __construct( $field, $from, $to )
    {
        $this->field = $field;
        $this->from  = $from;
        $this->to    = $to;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getNodeName()
    {
        return 'between';
    }

}
