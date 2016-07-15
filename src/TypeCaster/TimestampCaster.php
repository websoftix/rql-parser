<?php

namespace Xiag\Rql\Parser\TypeCaster;

use Xiag\Rql\Parser\Token;
use Xiag\Rql\Parser\TypeCasterInterface;

class TimestampCaster implements TypeCasterInterface
{

    /**
     * @inheritdoc
     */
    public function typeCast( Token $token )
    {
        if ( !$token->test( Token::T_INTEGER ) ) {
            throw new SyntaxErrorException( 'Timestamp type caster expects an integer token' );
        }
        return new \DateTime( '@' . $token->getValue() );
    }

}
