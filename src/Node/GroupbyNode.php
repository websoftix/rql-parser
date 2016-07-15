<?php

namespace Xiag\Rql\Parser\Node;

use Xiag\Rql\Parser\AbstractNode;

/**
 * @codeCoverageIgnore
 * 
 * groupby(field1,field2,...)
 */
class GroupbyNode extends AbstractNode
{

    private $fields;

    public function __construct( array $fields )
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getNodeName()
    {
        return 'groupby';
    }

}
