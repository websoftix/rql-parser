<?php

namespace Xiag\Rql\Parser\NodeParser\Query\ComparisonOperator;

use Xiag\Rql\Parser\Token;
use Xiag\Rql\Parser\TokenStream;
use Xiag\Rql\Parser\Node\Query\BetweenNode;
use Xiag\Rql\Parser\NodeParserInterface;
use Xiag\Rql\Parser\SubParserInterface;

class BetweenNodeParser implements NodeParserInterface
{

    private $valueParser;

    public function __construct( SubParserInterface $valueParser )
    {
        $this->valueParser = $valueParser;
    }

    public function parse( TokenStream $tokenStream )
    {
        $tokenStream->expect( Token::T_OPERATOR, 'between' );
        $tokenStream->expect( Token::T_OPEN_PARENTHESIS );

        $field = $tokenStream->expect( Token::T_STRING )->getValue();
        $tokenStream->expect( Token::T_COMMA );
        $from  = $this->valueParser->parse( $tokenStream );
        $tokenStream->expect( Token::T_COMMA );
        $to    = $this->valueParser->parse( $tokenStream );

        $tokenStream->expect( Token::T_CLOSE_PARENTHESIS );

        return new BetweenNode( $field, $from, $to );
    }

    public function supports( TokenStream $tokenStream )
    {
        return $tokenStream->test( Token::T_OPERATOR, 'between' );
    }

}
