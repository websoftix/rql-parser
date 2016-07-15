<?php

namespace Xiag\Rql\Parser\SubLexer;

use Xiag\Rql\Parser\Token;
use Xiag\Rql\Parser\SubLexerInterface;
use Xiag\Rql\Parser\Exception\SyntaxErrorException;

class DateSubLexer implements SubLexerInterface
{

    /**
     * @inheritdoc
     */
    public function getTokenAt( $code, $cursor )
    {
        if ( !preg_match( '/(?<y>\d{4})-(?<m>\d{2})-(?<d>\d{2})/A', $code, $matches, null, $cursor ) ) {
            return null;
        }

        if ( !checkdate( $matches['m'], $matches['d'], $matches['y'] ) ) {
            throw new SyntaxErrorException( sprintf( 'Invalid date value "%s"', $matches[0] ) );
        }

        return new Token(
                Token::T_DATE, $matches[0] . 'T00:00:00Z', $cursor, $cursor + strlen( $matches[0] )
        );
    }

}
