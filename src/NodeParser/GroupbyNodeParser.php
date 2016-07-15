<?php

namespace Xiag\Rql\Parser\NodeParser;

use Xiag\Rql\Parser\Token;
use Xiag\Rql\Parser\TokenStream;
use Xiag\Rql\Parser\NodeParserInterface;
use Xiag\Rql\Parser\Node\GroupbyNode;

class GroupbyNodeParser implements NodeParserInterface
{

    public function parse( TokenStream $tokenStream )
    {
        $fields = [ ];

        $tokenStream->expect( Token::T_OPERATOR, 'groupby' );
        $tokenStream->expect( Token::T_OPEN_PARENTHESIS );

        do {
            $fields[] = $tokenStream->expect( Token::T_STRING )->getValue();
            if ( !$tokenStream->nextIf( Token::T_COMMA ) ) {
                break;
            }
        }
        while ( true );

        $tokenStream->expect( Token::T_CLOSE_PARENTHESIS );

        return new GroupbyNode( $fields );
    }

    public function supports( TokenStream $tokenStream )
    {
        return $tokenStream->test( Token::T_OPERATOR, 'groupby' );
    }

}
